<?php

namespace App;

use Zizaco\Entrust\Traits\EntrustUserTrait;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use SoftDeletes, EntrustUserTrait {
        SoftDeletes::restore as sfRestore;
        EntrustUserTrait::restore as euRestore;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function budgetCategories()
    {
        return $this->belongsToMany('App\BudgetCategory', 'budget_manager_categories', 'budget_manager_id', 'budget_category_id');
    }

    // User forms
    public function createdRequestForms()
    {
        return $this->hasMany('App\RequestForm', 'user_id')
            ->orderBy('created_at', 'desc');
    }

    // Budget manager forms
    public function assignedRequestForms()
    {
        return $this->hasMany('App\RequestForm', 'budget_manager_id')
            ->orderBy('created_at', 'desc');
    }

    public function eventLog()
    {
        return $this->hasMany('App\RequestFormEvent', 'author_id');
    }

    public function notes()
    {
        return $this->hasMany('App\Note', 'author_id');
    }

    public function actionTokens()
    {
        return $this->hasMany('App\ActionToken', 'user_id');
    }

    public function restore()
    {
        $this->sfRestore();
        \Cache::tags(\Config::get('entrust.role_user_table'))->flush();
    }
}
