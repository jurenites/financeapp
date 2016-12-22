<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Event;
use Carbon\Carbon;

use App\RequestForm;
use App\Events\RequestFormPendingBudgetManager;

class CheckPendingRequestForms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'request_forms:check_pending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends emails to budget managers with pending forms';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $pendingRequestForms = RequestForm::pendingBudgetManager();
        foreach ($pendingRequestForms as $requestForm) {
            Event::fire(new RequestFormPendingBudgetManager($requestForm));

            $requestForm->status_changed_at = Carbon::now();
            $requestForm->save();
        }
    }
}
