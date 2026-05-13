<?php

namespace App\Services\Transcricao\Providers;

use Illuminate\Support\Facades\Http;
use App\Services\Transcricao\Providers\TranscricaoProvider;
use Illuminate\Http\UploadedFile;

class GroqTranscricaoProvider implements TranscricaoProvider {
    public function transcrever(UploadedFile $audio): string {
        $apiKey = env('GROQ_API_KEY');
        
        $response = Http::timeout(300)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $apiKey
            ])
            ->attach(
                'file',
                file_get_contents($audio->getPathname()),
                $audio->getClientOriginalName()
            )
            ->post('https://api.groq.com/openai/v1/audio/transcriptions', [
                'model' => 'whisper-large-v3',
            ]);

        if(!$response->successful()){
            throw new \Exception("Erro na transcrição: " . $response->body()); 
        }

        return $response->json()['text'] ?? 'Sem resposta';
    }
}