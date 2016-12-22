<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;

use Auth;
use Storage;
use Exception;
use Response;
use Illuminate\Http\Request;

use App\RequestForm;
use App\Document;
use App\Role;

class DocumentController extends Controller
{
    protected $currentNamespace = 'Shared';

    public function download($id)
    {
        $document = Document::findOrFail($id);
        if ($this->isCanDownload($document)) {
            $file_path = $document->getFilePath();
            if (file_exists($file_path)) {
                return Response::download($file_path, $document->original_name, [
                    'Content-Length: ' . filesize($file_path)
                ]);
            }
        }
        throw new Exception('Error when attempting to download document');
    }

    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        if ($this->isCanDestroy($document)) {
            $document->delete();
            return Response::json([], 200);
        }
        throw new Exception('Error when attempting to delete document');
    }

    protected function isCanDownload($document)
    {
        return false;
    }

    protected function isCanDestroy($document)
    {
        return false;
    }
}
