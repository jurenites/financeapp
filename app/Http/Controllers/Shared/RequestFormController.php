<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;

use Auth;
use Storage;
use Illuminate\Http\Request;
use Event;
use PDF;
use Carbon\Carbon;
use Validator;
use Excel;

use App\RequestForm;
use App\Role;
use App\Document;
use App\Note;
use App\ActionToken;
use App\Events\RequestFormSubmitted;
use App\Events\RequestFormEdited;
use App\Events\NoteAddedToRequestForm;

class RequestFormController extends Controller
{
    protected $currentNamespace = 'Shared';

    public function index($month = null)
    {
        $date = new Carbon($month);
        $to = new Carbon($date->endOfMonth());
        $from = new Carbon($date->startOfMonth());

        $requestForms = $this->getRequestForms()
            ->where('created_at', '>=', $from)
            ->where('created_at', '<=', $to)
            ->get();

        $from->subMonth(1);
        $to->subMonth(1);
        $prevMonthCount = $this->getRequestForms()
            ->where('created_at', '>=', $from)
            ->where('created_at', '<=', $to)
            ->count();

        $from->addMonth(2);
        $to->addMonth(2);
        $nextMonthCount = $this->getRequestForms()
            ->where('created_at', '>=', $from)
            ->where('created_at', '<=', $to)
            ->count();

        return view('shared.requestForms.index', compact('requestForms', 'prevMonthCount', 'nextMonthCount', 'date'));
    }

    public function archive()
    {
        return view($this->currentNamespace . '.requestForms.archive');
    }

    public function report(Request $request)
    {
        $from = $request->get('from') ? new Carbon($request->get('from')) : Carbon::now()->subDays(29);
        $from = $from->startOfDay();
        $to = $request->get('to') ? new Carbon($request->get('to')) : Carbon::now();
        $to = $to->endOfDay();
        $status = $request->get('status') ?: RequestForm::STATUS_APPROVED_BY_ADMIN;
        $requestForms = $this->getReportRequestForms($from, $to, $status);

        $format = $request->get('format');
        if ($format == 'csv') {
            $data = [];
            $data[] = ['Date submitted', 'Payable Name', 'Amount', 'Budget Category', 'Method of payment'];
            foreach ($requestForms as $requestForm) {
                $data[] = [
                    $requestForm->created_at->format('m/d/Y'),
                    $requestForm->payable_to_name,
                    $requestForm->amount,
                    $requestForm->budgetCategory ? $requestForm->budgetCategory->name : 'Unknown',
                    $requestForm->payment_method ?: 'N\A',                ];
            }
            $filename = 'Report (' . $status . ') ' . $from->format('m/d/Y') . ' - ' . $to->format('m/d/Y');
            Excel::create($filename, function($excel) use ($data) {
                $excel->sheet('Report', function($sheet) use ($data) {
                    $sheet->rows($data);
                });
            })->download('csv');
        }

        $statuses = RequestForm::getStatuses();
        return view('shared.requestForms.report', compact('requestForms', 'from', 'to', 'status', 'statuses'));
    }

    public function create()
    {
        $requestForm = new RequestForm;
        $requestForm->user_id = Auth::user()->id;
        $requestForm->created_at = Carbon::now();
        
        $requestForm->name = $requestForm->requester->name;
        $requestForm->email = $requestForm->requester->email;
        $requestForm->phone = $requestForm->requester->phone;
        $requestForm->bank_name = $requestForm->requester->bank_name;
        $requestForm->account_type = $requestForm->requester->account_type;
        $requestForm->routing_number = $requestForm->requester->routing_number;
        $requestForm->account_number = $requestForm->requester->account_number;

        $types = RequestForm::$types;
        $paymentMethods = RequestForm::$paymentMethods;
        $payableToTypes = RequestForm::$payableToTypes;
        $accountTypes = RequestForm::$accountTypes;

        $budgetManagers = $this->getAvailableBudgetManagers();

        return view('shared.requestForms.create', compact('requestForm', 'types', 'paymentMethods', 'payableToTypes', 'budgetManagers', 'accountTypes'));
    }

    public function store(Request $request)
    {
        $requestForm = $this->save(new RequestForm, $request);

        if ($requestForm->budgetManager) {
            $actionToken = new ActionToken;
            $actionToken->token = ActionToken::generateToken();
            $actionToken->redirect_url = action("BudgetManager\RequestFormController@approve", $requestForm->id);
            $actionToken->user_id = $requestForm->budgetManager->id;
            $actionToken->request_form_id = $requestForm->id;
            $actionToken->save();
        }

        Auth::user()->bank_name = $requestForm->bank_name;
        Auth::user()->account_type = $requestForm->account_type;
        Auth::user()->routing_number = $requestForm->routing_number;
        Auth::user()->account_number = $requestForm->account_number;
        Auth::user()->save();

        Event::fire(new RequestFormSubmitted($requestForm));

        $request->session()->flash('success', 'Request form created.');
        return redirect()->action("{$this->currentNamespace}\RequestFormController@index");
    }

    public function show($id)
    {
        $requestForm = RequestForm::findOrFail($id);

        if (!$this->isCanView($requestForm)) {
            return redirect()->action("{$this->currentNamespace}\RequestFormController@index");
        }

        return view('shared.requestForms.show', compact('requestForm'));
    }

    public function edit($id)
    {
        $requestForm = RequestForm::findOrFail($id);

        if (!$this->isCanEdit($requestForm)) {
            return redirect()->action("{$this->currentNamespace}\RequestFormController@index");
        }

        $types = RequestForm::$types;
        $paymentMethods = RequestForm::$paymentMethods;
        $payableToTypes = RequestForm::$payableToTypes;
        $accountTypes = RequestForm::$accountTypes;
        $budgetManagers = Role::where('name', 'budget_manager')->first()->users;

        return view('shared.requestForms.edit', compact('requestForm', 'types', 'paymentMethods', 'payableToTypes', 'budgetManagers', 'accountTypes'));
    }

    public function update(Request $request, $id)
    {
        $requestForm = RequestForm::findOrFail($id);
        if (!$this->isCanEdit($requestForm)) {
            return redirect()->action("{$this->currentNamespace}\RequestFormController@index");
        }

        $requestForm = $this->save($requestForm, $request);

        Event::fire(new RequestFormEdited($requestForm));

        $request->session()->flash('success', 'Request form updated.');
        return redirect()->action("{$this->currentNamespace}\RequestFormController@index");
    }

    public function destroy(Request $request, $id)
    {
        $requestForm = RequestForm::findOrFail($id);

        if (!$this->isCanDestroy($requestForm)) {
            return redirect()->action("{$this->currentNamespace}\RequestFormController@index");
        }

        $requestForm->delete();

        $request->session()->flash('success', 'Request form removed.');
        return redirect()->action("{$this->currentNamespace}\RequestFormController@index");
    }

    public function restore(Request $request, $id)
    {
        $requestForm = RequestForm::withTrashed()->findOrFail($id);

        if (!$this->isCanDestroy($requestForm)) {
            return redirect()->action("{$this->currentNamespace}\RequestFormController@index");
        }

        $requestForm->restore();

        $request->session()->flash('success', 'Request form restored.');
        return redirect()->action("{$this->currentNamespace}\RequestFormController@index");
    }

    public function addRequesterNote(Request $request, $id)
    {
        $requestForm = RequestForm::findOrFail($id);
        if ($this->isCanAddRequesterNote($requestForm)) {
            $this->addNote($requestForm, Note::TYPE_REQUESTER, $request->get('note'));
        }

        $request->session()->flash('success', 'Note added.');
        return back();
    }

    public function addBudgetManagerNote(Request $request, $id)
    {
        $requestForm = RequestForm::findOrFail($id);
        if ($this->isCanAddBudgetManagerNote($requestForm)) {
            $this->addNote($requestForm, Note::TYPE_BUDGET_MANAGER, $request->get('note'));
        }

        $request->session()->flash('success', 'Note added.');
        return back();
    }

    public function addAdminNote(Request $request, $id)
    {
        $requestForm = RequestForm::findOrFail($id);
        if ($this->isCanAddAdminNote($requestForm)) {
            $this->addNote($requestForm, Note::TYPE_ADMIN, $request->get('note'));
        }

        $request->session()->flash('success', 'Note added.');
        return back();
    }

    public function approve(Request $request, $id)
    {
        $requestForm = RequestForm::findOrFail($id);

        if (!$this->isCanApprove($requestForm)) {
            return redirect()->action("{$this->currentNamespace}\RequestFormController@index");
        }

        $requestForm->status = $this->getApprovalStatus();
        $requestForm->status_changed_at = Carbon::now();
        $requestForm->save();

        $this->emitApproveEvent($requestForm);

        $request->session()->flash('success', 'Request form approved.');
        return back();
    }

    public function decline(Request $request, $id)
    {
        $requestForm = RequestForm::findOrFail($id);

        if (!$this->isCanDecline($requestForm)) {
            return redirect()->action("{$this->currentNamespace}\RequestFormController@index");
        }

        $note = new Note;
        $note->text = $request->get('decline_reason');
        $note->type = $this->getDeclineNoteType();
        $note->author_id = Auth::user()->id;
        $note->request_form_id = $requestForm->id;
        $note->save();

        Event::fire(new NoteAddedToRequestForm($requestForm));

        $requestForm->status = $this->getDeclineStatus();
        $requestForm->status_changed_at = Carbon::now();
        $requestForm->save();

        $this->emitDeclineEvent($requestForm);

        $request->session()->flash('success', 'Request form declined.');
        return back();
    }

    public function export($id)
    {
        $requestForm = RequestForm::findOrFail($id);

        if (!$this->isCanExport($requestForm)) {
            return redirect()->action("{$this->currentNamespace}\RequestFormController@index");
        }

        $pdf = PDF::loadView('pdf.requestForm', compact('requestForm'));
        $file_path = storage_path() . '/app/request_forms/' . $id . '.pdf';
        $pdf->save($file_path);

        $pdfMerger = new \PDFMerger;
        $pdfMerger->addPDF($file_path);
        foreach ($requestForm->documents as $document) {
            $convertedFilePath = $document->getConvertedFilePath();
            if (file_exists($convertedFilePath)) {
                $pdfMerger->addPDF($convertedFilePath);
            }
        }

        $export_file_path = storage_path() . "/app/request_forms/RequestForm{$id}.pdf";
        $pdfMerger->merge('file', $export_file_path);

        return \Response::download($export_file_path, "RequestForm{$id}.pdf", [
            'Content-Length: ' . filesize($export_file_path)
        ]);
    }

    private function save($requestForm, $request)
    {
        $data = $request->all();
        $now = Carbon::now();
        $created_at = new Carbon($data['created_at']);
        $created_at->addHours($now->hour);
        $created_at->addMinutes($now->minute);
        $created_at->addSeconds($now->second);

        if (!$requestForm->id) {
            $data['user_id'] = Auth::user()->id;
            $data['status'] = RequestForm::STATUS_SUBMITTED;
            $data['status_changed_at'] = Carbon::now();
        }

        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $requestForm->fill($data);
        if ($requestForm->status == RequestForm::STATUS_DECLINED_BY_MANAGER) {
            $requestForm->status = RequestForm::STATUS_RESUBMITTED;
            $requestForm->status_changed_at = Carbon::now();
        }
        foreach (RequestForm::$types as $key => $value) {
            if ($requestForm->type == $value) {
                $requestForm->payment_method = $request->get("payment_method_$key");
                break;
            }
        }
        $requestForm->save();

        $requestForm->created_at = $created_at;
        $requestForm->save();

        foreach ($data['files'] as $file) {
            if (is_null($file)) {
                continue;
            }
            $document = new Document;
            $document->name = md5($file->getClientOriginalName() . time()) . '.'
                . $file->getClientOriginalExtension();
            $document->original_name = $file->getClientOriginalName();
            $document->request_form_id = $requestForm->id;
            Storage::disk('local')->put('documents/' . $document->name, \File::get($file));
            $document->save();
        }

        return $requestForm;
    }

    private function addNote($requestForm, $type, $text)
    {
        $note = new Note;
        $note->text = $text;
        $note->type = $type;
        $note->author_id = Auth::user()->id;
        $note->request_form_id = $requestForm->id;
        $note->save();

        Event::fire(new NoteAddedToRequestForm($requestForm));
    }

    protected function getRequestForms()
    {
        return [];
    }

    protected function getReportRequestForms($from, $to, $status)
    {
        return [];
    }

    protected function isCanView($requestForm)
    {
        return false;
    }

    protected function isCanEdit($requestForm)
    {
        return false;
    }

    protected function isCanDestroy($requestForm)
    {
        return false;
    }

    protected function isCanAddRequesterNote($requestForm)
    {
        return false;
    }

    protected function isCanAddBudgetManagerNote($requestForm)
    {
        return false;
    }

    protected function isCanAddAdminNote($requestForm)
    {
        return false;
    }

    protected function isCanApprove($requestForm)
    {
        return false;
    }

    protected function isCanExport($requestForm)
    {
        return false;
    }

    protected function getApprovalStatus()
    {
        return '';
    }

    protected function emitApproveEvent($requestForm)
    {
        return;
    }

    protected function isCanDecline($requestForm)
    {
        return false;
    }

    protected function getDeclineNoteType()
    {
        return '';
    }

    protected function getDeclineStatus()
    {
        return '';
    }

    protected function emitDeclineEvent($requestForm)
    {
        return;
    }

    protected function getAvailableBudgetManagers()
    {
        return Role::where('name', 'budget_manager')->first()->users;
    }

    private function validator(array $data)
    {
        return Validator::make($data, [
            'type' => 'required',
            'payable_to_name' => 'required',
            'amount' => 'required|numeric',
            'explanation' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);
    }
}