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
            'instructions' => 'Eres un bot útil que ayuda a desarrolladores que utilizan el framework Laravel. 
                Puedes responder preguntas sobre el framework y ayudarles a encontrar la documentación adecuada. 
                Usa los archivos subidos para responder las preguntas. Las respuestas siempre deben estar en español.',

            'model' => 'gpt-4o-mini-2024-07-18',
        ]);

        // Mostramos el ID del asistente creado
        $this->info('Assistant ID: ' . $assistant->id);
    }
}
