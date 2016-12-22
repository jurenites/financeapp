<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

use App\Note;

class RequestForm extends Model
{
    use SoftDeletes;

    const STATUS_SUBMITTED = 'Waiting on Approval';
    const STATUS_RESUBMITTED = 'Re-Submitted';
    const STATUS_APPROVED_BY_MANAGER = 'Approved by Budget Manager';
    const STATUS_DECLINED_BY_MANAGER = 'Declined by Budget Manager';
    const STATUS_APPROVED_BY_ADMIN = 'Approved by Finance Admin';
    const STATUS_DECLINED_BY_ADMIN = 'Declined by Finance Admin';
    const STATUS_COMPLETED = 'Completed & Paid';
    const STATUS_DELETED = 'Deleted';


    public static $types = array(
        'CHECK' => 'Check',
        'DIRECT_DEPOSIT' => 'Direct Deposit (staff and pre-approved independent contractors only)',
        'CASH' => 'Cash (Short Term Missions, Per Diem or Petty Cash only)',
        'COSTCO_CASH_CARD' => 'Costco Cash card',
    );

    public static $paymentMethods = array(
        'CHECK' => array(
            'MAIL' => 'Mail',
            'PICK_UP' => 'Pick up',
        ),
        'DIRECT_DEPOSIT' => array(
            'STAFF' => 'Staff',
            'INDEPENDENT_CONTRACTOR' => 'Independent contractor',
        ),
        'CASH' => array(
            'SHORT_TERM_MISSIONS' => 'Short Term Missions',
            'PER_DIEM' => 'Per Diem',
            'PETTY_CASH' => 'Petty Cash (under $25 only)',
        ),
        'COSTCO_CASH_CARD' => array(
            'PICK_UP' => 'Pick up',
        ),
    );

    public static $payableToTypes = array(
        'STAFF' => 'Staff',
        'CONTRACTOR' => 'Contractor',
        'OTHER' => 'Other',
    );

    public static $accountTypes = array(
        'CHECKING' => 'Checking',
        'SAVINGS' => 'Savings',
    );

    protected $fillable = [
        'type', 'payment_method', 'address1', 'address2', 'city',
        'state', 'zip', 'payable_to_name', 'payable_to_type', 'amount',
        'explanation', 'requester_notes', 'budget_manager_notes', 'admin_notes',
        'status', 'user_id', 'email', 'name', 'phone', 'budget_manager_id', 'budget_category_id',
        'status_changed_at', 'bank_name', 'account_type', 'routing_number', 'account_number', 'cash_request_type'
    ];

    public static function getStatuses() {
        return [
            RequestForm::STATUS_SUBMITTED,
            RequestForm::STATUS_RESUBMITTED,
            RequestForm::STATUS_APPROVED_BY_MANAGER,
            RequestForm::STATUS_DECLINED_BY_MANAGER,
            RequestForm::STATUS_APPROVED_BY_ADMIN,
            RequestForm::STATUS_DECLINED_BY_ADMIN,
            RequestForm::STATUS_COMPLETED,
        ];
    }

    public static function pendingBudgetManager()
    {
        $submittedForms = self::where('status', '=', self::STATUS_SUBMITTED)
            ->orWhere('status', '=', self::STATUS_RESUBMITTED)
            ->get();
        $pendingForms = [];
        // waiting 3 days except Sundays
        $now = Carbon::now();
        foreach ($submittedForms as $requestForm) {
            $statusChangeDate = new Carbon($requestForm->status_changed_at);
            $diffInDays = $statusChangeDate->diffInDays();
            if ($statusChangeDate->dayOfWeek >= 4) {
                if ($diffInDays >= 4) {
                    $pendingForms[] = $requestForm;
                }
            } else {
                if ($diffInDays >= 3) {
                    $pendingForms[] = $requestForm;
                }
            }
        }
        return $pendingForms;
    }

    public function requester()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function budgetManager()
    {
        return $this->belongsTo('App\User', 'budget_manager_id');
    }

    public function budgetCategory()
    {
        return $this->belongsTo('App\BudgetCategory', 'budget_category_id');
    }

    public function documents()
    {
        return $this->hasMany('App\Document', 'request_form_id');
    }

    public function eventLog()
    {
        return $this->hasMany('App\RequestFormEvent', 'request_form_id');
    }

    public function notes()
    {
        return $this->hasMany('App\Note', 'request_form_id');
    }

    public function requesterNotes()
    {
        return $this->notes()->whereType(Note::TYPE_REQUESTER);
    }

    public function budgetManagerNotes()
    {
        return $this->notes()->whereType(Note::TYPE_BUDGET_MANAGER);
    }

    public function adminNotes()
    {
        return $this->notes()->whereType(Note::TYPE_ADMIN);
    }

    public function actionTokens()
    {
        return $this->hasMany('App\ActionToken', 'request_form_id');
    }

    public function setBudgetManagerIdAttribute($value) {
        $this->attributes['budget_manager_id'] = $value ?: null;
    }

    public function setBudgetCategoryIdAttribute($value) {
        $this->attributes['budget_category_id'] = $value ?: null;
    }

    public function isManagerCanApprove() {
        return $this->status == self::STATUS_SUBMITTED ||
            $this->status == self::STATUS_RESUBMITTED ||
            $this->status == self::STATUS_DECLINED_BY_ADMIN;
    }

    public function isManagerCanDecline() {
        return $this->status == self::STATUS_SUBMITTED ||
            $this->status == self::STATUS_RESUBMITTED ||
            $this->status == self::STATUS_DECLINED_BY_ADMIN;
    }

    public function isAdminCanApprove() {
        return $this->status == self::STATUS_APPROVED_BY_MANAGER;
    }

    public function isAdminCanDecline() {
        return $this->status == self::STATUS_APPROVED_BY_MANAGER;
    }

    public function isAdminCanPay() {
        return $this->status != self::STATUS_COMPLETED;
    }

    public function isUserCanEdit() {
        return $this->status == self::STATUS_SUBMITTED ||
            $this->status == self::STATUS_RESUBMITTED ||
            $this->status == self::STATUS_DECLINED_BY_MANAGER;
    }

    public function getType() {
        return $this->type;
    }
}
