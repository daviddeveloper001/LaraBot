<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Self_;

class PrepareDocs extends Command
{

    private static array $FILES_TO_IGNORE = [
        'LICENSE.md',
        'README.md',
        'announcing-pest2.md',
        'documentation.md',
        'pest-spicy-summer-release.md',
        'video-resources.md',
        'why-pest.md',
    ];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:prepare-docs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create one file containing the full Laravel documentation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ini_set('max_execution_time', '10000000');

        $files = Http::get('https://api.github.com/repos/laravel/docs/contents')->collect();

        $fullDocs = $files->filter(fn (array $file) => $file['download_url'] != null)
            ->filter(fn (array $file) => ! in_array($file['name'], self::$FILES_TO_IGNORE))
            ->map(fn (array $file) => Http::get($file['download_url'])->body())
            ->implode(PHP_EOL.PHP_EOL);

        Storage::disk('local')->put('full-laravel-docs.md', $fullDocs);
    
    }
}
