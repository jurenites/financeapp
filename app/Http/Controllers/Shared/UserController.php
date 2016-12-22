<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;

use Auth;
use Illuminate\Http\Request;
use Validator;

use App\User;
use App\Role;
use App\BudgetCategory;

class UserController extends Controller
{
    protected $currentNamespace = 'Shared';

    public function index()
    {
        $users = $this->getUsers();
        return view('shared.users.index', compact('users'));
    }

    public function create()
    {
        $user = new User;

        $roles = Role::all();
        $budgetCategories = BudgetCategory::all();

        return view('shared.users.create', compact('user', 'roles', 'budgetCategories'));
    }

    public function store(Request $request)
    {
        $user = $this->save(new User, $request);

        if (!$this->isCanStore($user)) {
            $user->forceDelete();
        }

        $request->session()->flash('success', 'User created.');
        return redirect()->action("{$this->currentNamespace}\UserController@index");
    }

    public function show($id)
    {
        return $this->edit($id);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        if (!$this->isCanEdit($user)) {
            return redirect()->action("{$this->currentNamespace}\RequestFormController@index");
        }

        $roles = Role::all();
        $budgetCategories = BudgetCategory::all();

        return view('shared.users.edit', compact('user', 'roles', 'budgetCategories'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if (!$this->isCanEdit($user)) {
            return redirect()->action("{$this->currentNamespace}\UserController@index");
        }

        $user = $this->save($user, $request);

        $request->session()->flash('success', 'User profile updated.');
        if ($id == Auth::user()->id) {
            return redirect('/');
        } else {
            return redirect()->action("{$this->currentNamespace}\UserController@index");
        }
    }

    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (!$this->isCanDestroy($user)) {
            return redirect()->action("{$this->currentNamespace}\UserController@index");
        }

        foreach ($user->createdRequestForms as $requestForm) {
            $requestForm->delete();
        }

        $user->delete();

        $request->session()->flash('success', 'User removed.');
        return redirect()->action("{$this->currentNamespace}\UserController@index");
    }

    private function save($user, $request)
    {
        $data = $request->all();
        if ($data['password']) {
            $data['password'] = bcrypt($data['password']);
        } else {
            $data['password'] = $user->password;
            $data['password_confirmation'] = $user->password;
        }

        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $user->fill($data);
        $user->save();

        $user->roles()->detach();
        $user->roles()->attach($data['role']);

        if ($this->isCanSetBudgetCategories($user)) {
            $user->budgetCategories()->detach();
            if (isset($data['budgetCategories'])) {
                foreach ($data['budgetCategories'] as $budgetCategoryId) {
                    $user->budgetCategories()->attach($budgetCategoryId);
                }
            }
        }

        return $user;
    }

    protected function getUsers()
    {
        return [];
    }

    protected function isCanStore($user)
    {
        return false;
    }

    protected function isCanEdit($user)
    {
        return false;
    }

    protected function isCanDestroy($user)
    {
        return false;
    }

    protected function isCanSetBudgetCategories($user)
    {
        return false;
    }

    private function validator(array $data)
    {
        if (isset($data['id'])) {
            return Validator::make($data, [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users,email,'.$data['id'],
                'password' => 'confirmed',
            ]);
        } else {
            return Validator::make($data, [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|confirmed',
            ]);
        }
    }
}