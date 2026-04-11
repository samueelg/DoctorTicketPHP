<?php

namespace App\Services\Transcricao\Providers;

use Illuminate\Support\Facades\Http;
use App\Services\Transcricao\Providers\TranscricaoProvider;

class GroqTranscricaoProvider implements TranscricaoProvider {
    public function transcrever(string $caminhoAudio): string {
        $apiKey = env('GROQ_API_KEY');
        
        $response = Http::timeout(300)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $apiKey
            ])
            ->attach(
                'file',
                file_get_contents($caminhoAudio),
                basename($caminhoAudio)
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