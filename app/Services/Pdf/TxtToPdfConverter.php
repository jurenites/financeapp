<?php

namespace App\Services\Pdf;

use PDF;

class TxtToPdfConverter extends AbstractPdfConverter
{
    public function convert()
    {
        $text = file_get_contents($this->file_path);
        $pdf = PDF::loadView('pdf.convert.txt', compact('text'));

        $extPos = strrpos($this->file_path, '.');
        $convertedFilePath = substr($this->file_path, 0, $extPos) . '.pdf';

        $pdf->save($convertedFilePath);
    }
}