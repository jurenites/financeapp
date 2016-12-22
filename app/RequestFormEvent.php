<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestFormEvent extends Model
{
    use SoftDeletes;

    const TYPE_SUBMITTED = 'submitted';
    const TYPE_EDITED = 'edited';
    const TYPE_APPROVED = 'approved';
    const TYPE_DECLINED = 'declined';
    const TYPE_NOTE_ADDED = 'note_added';
    const TYPE_COMPLETED = 'completed';

    public function requestForm()
    {
        return $this->belongsTo('App\RequestForm', 'request_form_id');
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'author_id');
    }

    public function getMessage() {
        $author_name = $this->author ? $this->author->name : 'N\A';
        switch ($this->type) {
            case self::TYPE_SUBMITTED:
                return 'Request Submitted';

            case self::TYPE_EDITED:
                return 'Request edited by ' . $author_name;

            case self::TYPE_APPROVED:
                return 'Request approved by ' . $author_name;

            case self::TYPE_DECLINED:
                return 'Request declined by ' . $author_name;

            case self::TYPE_NOTE_ADDED:
                return 'Note added by ' . $author_name;

            case self::TYPE_COMPLETED:
                return 'Request completed by ' . $author_name;

            default:
                return '';
        }
    }
}
