<?php

namespace App\Services\Pdf;

use PDF;

class ImageToPdfConverter extends AbstractPdfConverter
{
    const MAX_WIDTH = 700;
    const MAX_HEIGHT = 1000;

    public function convert()
    {
        $extPos = strrpos($this->file_path, '.');
        $ext = substr($this->file_path, $extPos+1);
        $convertedFilePath = substr($this->file_path, 0, $extPos) . '.pdf';

        $image = file_get_contents($this->file_path);
        $base64image = 'data:image/' . $ext . ';base64,' . base64_encode($image);

        // Prepare size
        $image_size = getimagesize($this->file_path);
        $image_width = $image_size[0];
        $image_height = $image_size[1];
        if ($image_width <= self::MAX_WIDTH) {
            if ($image_height <= self::MAX_HEIGHT) {
                $width = $image_width . 'px';
                $height = $image_height . 'px';
            } else {
                $width = 'auto';
                $height = self::MAX_HEIGHT . 'px';
            }
        } else {
            if ($image_height <= self::MAX_HEIGHT) {
                $width = self::MAX_WIDTH . 'px';
                $height = 'auto';
            } else {
                if (self::MAX_WIDTH / self::MAX_HEIGHT < $image_width / $image_height) {
                    $width = self::MAX_WIDTH . 'px';
                    $height = 'auto';
                } else {
                    $width = 'auto';
                    $height = self::MAX_HEIGHT . 'px';
                }
            }
        }

        $pdf = PDF::loadView('pdf.convert.image', compact('base64image', 'width', 'height'));

        $pdf->save($convertedFilePath);
    }
}