<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionToken extends Model
{
    const TOKEN_LENGHT = 80;

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function requestForm()
    {
        return $this->belongsTo('App\RequestForm', 'request_form_id');
    }

    public static function generateToken()
    {
        $token = str_random(self::TOKEN_LENGHT);
        while (self::whereToken($token)->count() > 0) {
            $token = str_random(self::TOKEN_LENGHT);
        }
        return $token;
    }
}
