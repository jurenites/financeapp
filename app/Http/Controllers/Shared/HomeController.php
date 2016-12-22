<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;

use Auth;

use App\Role;
use App\ActionToken;

class HomeController extends Controller
{
    protected $currentNamespace = 'Shared';

    public function index()
    {
        if (Auth::user()) {
            return $this->redirectByRole('dashboard');
        }
        return redirect('login');
    }

    public function token($token)
    {
        $actionToken = ActionToken::whereToken($token)->first();
        if ($actionToken->is_used) {
            return redirect('/');
        }
        $actionToken->is_used = true;
        $actionToken->save();

        Auth::loginUsingId($actionToken->user_id);
        return redirect($actionToken->redirect_url);
    }

    private $rolePrefixes = [
        Role::ROLE_ADMIN => 'admin',
        Role::ROLE_BUDGET_MANAGER => 'manager',
        Role::ROLE_USER => 'user',
    ];

    private function redirectByRole($url)
    {
        if (Auth::guest()) {
            return redirect($url);
        }
        $prefix = $this->rolePrefixes[Auth::user()->roles->first()->name];
        return redirect("$prefix/$url");
    }
}
