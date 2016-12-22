<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use SoftDeletes;

    const TYPE_REQUESTER = 'to requester';
    const TYPE_BUDGET_MANAGER = 'to budget managers';
    const TYPE_ADMIN = 'to admin';

    protected $fillable = [
        'text', 'type', 
    ];

    public function requestForm()
    {
        return $this->belongsTo('App\RequestForm', 'request_form_id');
	}

    public function author()
    {
        return $this->belongsTo('App\User', 'author_id');
	}
}
