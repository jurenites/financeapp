<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use Excel;

class ServiceController extends Controller
{
    protected $currentNamespace = 'Admin';

    public function index()
    {
        return view('Admin.service.index');
    }

    public function importBudgetManagers()
    {
        return view('Admin.service.import_budget_managers');
    }

    public function doImportBudgetManagers(Request $request)
    {
        $file = $request->file('file');
        if (is_null($file)) {
            return back();
        }

        $results = Excel::load($file, function($reader) {
            //
        })->get();

        foreach ($results as $budgetManager) {
            if (User::whereEmail($budgetManager['email'])->count() == 0) {
                $user = new User;
                $user->name = $budgetManager['name'];
                $user->email = $budgetManager['email'];
                $user->password = bcrypt($budgetManager['temp_password']);
                $user->save();

                $role = Role::whereName('budget_manager')->first();
                $user->roles()->attach($role);
            }
        }

        return back();
    }
}
