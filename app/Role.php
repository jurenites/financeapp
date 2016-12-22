<?php namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    const ROLE_ADMIN = 'admin';
    const ROLE_BUDGET_MANAGER = 'budget_manager';
    const ROLE_USER = 'user';

    public function users()
    {
        return $this->belongsToMany('App\User', 'role_user', 'role_id', 'user_id');
    }
}