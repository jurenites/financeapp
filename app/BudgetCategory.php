<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BudgetCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function budgetManagers()
    {
        return $this->belongsToMany('App\User', 'budget_manager_categories', 'budget_category_id', 'budget_manager_id');
    }
}
