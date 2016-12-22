<?php

namespace App\Services\Pdf;

class DocToPdfConverter extends AbstractPdfConverter
{
    public function convert()
    {
        $libreOfficePythonPath = env('LIBREOFFICE_PYTHON_PATH', false);
        $unoconvPath = env('UNOCONV_PATH', false);
        $convertCmd = '';
        if ($libreOfficePythonPath) {
            $convertCmd .= "\"$libreOfficePythonPath\" ";
        }
        if ($unoconvPath) {
            $convertCmd .= "\"$unoconvPath\" ";
        } else {
            $convertCmd .= "unoconv ";
        }
        $convertCmd .= "-f pdf \"{$this->file_path}\"";

        return exec($convertCmd);
    }
}