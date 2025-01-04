<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Storage;

class UploadDocs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:upload-docs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uploads the docs to OpenAI';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $uploadedFile = OpenAI::files()->upload([
            'file' => Storage::disk('local')->readStream('full-laravel-docs.md'),
            'purpose' => 'assistants',
        ]);

        $this->info('File ID: ' . $uploadedFile->id);
    }
}
