<?php

namespace App\Services\Pdf;

abstract class AbstractPdfConverter
{
    protected $file_path;

    public static function getConverter($file_path)
    {
        $extension_converters = [
            'doc' => DocToPdfConverter::class,
            'docx' => DocToPdfConverter::class,
            'txt' => TxtToPdfConverter::class,
            'jpg' => ImageToPdfConverter::class,
            'jpeg' => ImageToPdfConverter::class,
            'png' => ImageToPdfConverter::class,
            'gif' => ImageToPdfConverter::class,
            'bmp' => ImageToPdfConverter::class,
        ];

        $pathinfo = pathinfo($file_path);
        $extension = strtolower($pathinfo['extension']);

        $converterClass = isset($extension_converters[$extension]) ?
            $extension_converters[$extension] : DefaultConverter::class;

        return new $converterClass($file_path);
    }

    public function __construct($file_path)
    {
        $this->file_path = $file_path;
    }

    abstract public function convert();
}
