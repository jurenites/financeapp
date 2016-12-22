<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    public function author()
    {
        return $this->belongsTo('App\User', 'author_id');
    }

    public function requestForm()
    {
        return $this->belongsTo('App\RequestForm', 'request_form_id');
    }
}
