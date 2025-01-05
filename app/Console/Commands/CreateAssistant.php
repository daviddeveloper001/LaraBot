<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use OpenAI\Laravel\Facades\OpenAI;

class CreateAssistant extends Command
{

    protected $signature = 'app:create-assistant {file_id}';


    protected $description = 'Command description';

    public function handle()
    {
        /* $models = OpenAI::models()->list();

        foreach ($models->data as $model) {
            $this->info('Model ID: ' . $model->id);
        } */
        // Obtenemos el ID del archivo pasado como argumento
        $fileId = $this->argument('file_id');

        // Creamos el asistente
        $assistant = OpenAI::assistants()->create([
            'name' => 'LaraBOT',
            'tools' => [
                [
                    'type' => 'code_interpreter', // Definimos la herramienta
                ],
            ],
            'tool_resources' => [
                'code_interpreter' => [ // Vinculamos los recursos al tipo de herramienta
                    'file_ids' => [$fileId], // Pasamos el ID del archivo subido
                ],
            ],
            'instructions' => 'You are a useful bot that helps developers using Laravel Framework.
                You can answer questions about the framework and help them find the appropriate documentation.
                Use the uploaded files to answer questions. Answers must always be returned in Spanish.',

            'model' => 'gpt-4o-mini-2024-07-18',
        ]);

        // Mostramos el ID del asistente creado
        $this->info('Assistant ID: ' . $assistant->id);
    }
}
