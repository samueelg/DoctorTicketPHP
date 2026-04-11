<?php

namespace App\Services\Transcricao\Providers;

interface TranscricaoProvider {
    public function transcrever(string $caminhoAudio): string;
}