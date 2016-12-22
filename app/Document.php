<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'original_name',
    ];

    public function requestForm()
    {
        return $this->belongsTo('App\RequestForm', 'request_form_id');
    }

    public function getFilePath()
    {
        return storage_path() . '/app/documents/' . $this->name;
    }

    public function getConvertedFilePath()
    {
        $file_path = $this->getFilePath();
        $extPos = strrpos($file_path, '.');
        return substr($file_path, 0, $extPos) . '.pdf';
    }
}
