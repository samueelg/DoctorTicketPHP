<?php

namespace App\Services\Transcricao;

use App\Services\Transcricao\Providers\TranscricaoProvider;

class TranscricaoService
{
    private $provider;

    public function __construct(TranscricaoProvider $provider) {
        $this->provider = $provider;
    }

    public function transcrever($audioPath) {
        return $this->provider->transcrever($audioPath);
    }
}