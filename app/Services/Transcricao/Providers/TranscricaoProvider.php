<?php

namespace App\Services\Transcricao\Providers;

use Illuminate\Http\UploadedFile;

interface TranscricaoProvider {
    public function transcrever(UploadedFile $audio): string;
}