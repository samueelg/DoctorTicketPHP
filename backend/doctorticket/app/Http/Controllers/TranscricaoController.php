<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TranscricaoController extends Controller
{
    public function transcreverLigacao(Request $request){
        dd('teste');
        $request->validate([
            'audio' => 'file',
        ]);

        $arquivo = $request->file('audio');

        $response = Http::timeout(300)
            ->attach(
                'audio',
                file_get_contents($arquivo->getRealPath()),
                $arquivo->getClientOriginalName()
            )
            ->post('http://127.0.0.1:8030/transcribe');

        return response()->json($response->json(), $response->status());
    }
}