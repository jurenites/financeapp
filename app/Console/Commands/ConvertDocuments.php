<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Document;
use App\Services\Pdf\AbstractPdfConverter;

class ConvertDocuments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'documents:convert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Converts all new uploaded documents to pdf.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $documents = Document::all();
        foreach ($documents as $document) {
            $file_path = $document->getFilePath();
            $convertedFilePath = $document->getConvertedFilePath();

            if (!file_exists($convertedFilePath)) {
                $pdfConverter = AbstractPdfConverter::getConverter($file_path);
                $pdfConverter->convert();

                if (!file_exists($convertedFilePath)) {
                    // TODO: Exception or something (file not converted)
                }
            }
        }
    }
}
