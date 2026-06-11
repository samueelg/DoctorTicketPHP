<?php

namespace App\Services\Processamento;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProcessamentoService{
    public function processarDados($transcricao){
        $apiKey = env('GROQ_API_KEY');
        $horario = date('H');

        $prompt = '
            Você é um assistente especializado em atendimento de suporte de clínicas odontológicas da Oral Sin.
            
            A transcrição recebida será um resumo curto e informal gravado por um analista logo após encerrar uma ligação telefônica com o franqueado.
            
            A fala normalmente contém:
            - tipo do problema
            - nome do solicitante
            - unidade
            - breve resumo da solução aplicada
            -nome do paciente(pode não conter)

            A transcrição pode conter:
            - frases incompletas
            - ausência de pontuação
            - palavras abreviadas
            - erros de fala ou transcrição

            Retorne APENAS um JSON válido no seguinte formato:
            {
            "titulo": "Solicitação Telefone - (Tipo da solicitação)",
            "assunto": "",
            "solicitante": "",
            "unidade": "",
            }

            Exemplo com resposta:
            Transcrição:
            "transferencia de paciente solicitante joao unidade londrina gleba palhano"

            Resposta:
            {
            "titulo": "Solicitação Telefone - Transferência de paciente",
            "assunto": "Olá! Bom dia...",
            "descricaoAssunto": "Transferência de paciente entre unidades",
            "acao": "Transferencia realizada conforme o solicitado"
            "solicitante": "João",
            "unidade": "Londrina Gleba Palhano",
            }

            O campo "assunto" deve seguir EXATAMENTE este template:
                "Olá! Bom dia/Boa tarde!\n\n

                Foi registrado a Solicitação por telefone ao SAF.\n\n

                Dúvida/Solicitação: {descricaoAssunto}\n\n

                Orientação/Solução: {acao}\n\n 

                Solicitante: {solicitante}\n\n

                Paciente: {paciente OU "Não Informado"}\n\n

                Unidade: {unidade}\n\n

                A sua avaliação é muito importante, se possível avalie o meu atendimento através da mensagem desse ticket. Obrigado!\n\n"

            Variaveis:' . "
            hora = {$horario}
            " . '

            Regras importantes:
            - A transcrição podera vir no formato "Tipo da solicitação - Nome do Solicitante - Unidade - Paciente"
            - Se hora < 12, use "Bom dia" no assunto 
            - Se hora >= 12, use "Boa tarde"

            Regras para "Orientação/Solução":
            - usar frases curtas e diretas
            - sempre escrever no passado
            - descrever apenas ações concluídas

            Exemplos válidos:
            - "Transferência de paciente realizada conforme solicitado"
            - "Auxílio na alteração de contrato através do AnyDesk"
            - "Contrato cancelado revertido durante a ligação"     
            
            Responda apenas com JSON válido.
            Não utilize markdown.
            Não utilize blocos ```json.
            Não adicione explicações.
            ' . "
            Transcrição:
            {{$transcricao}}
            " . '
        ';     

        $response = Http::timeout(300)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $apiKey
            ])
            ->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama-3.3-70b-versatile',
                'temperature' => 0,
                'messages' => [
                    [
                        'role'    => 'system',
                        'content' => 'Você extrai dados estruturados de atendimentos telefonicos entre Analista de Suporte e franqueado'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ]
            ]);

        if(!$response->successful()){
            throw new \Exception("Erro na transcrição: " . $response->body()); 
        }

        $content = $response->json()['choices'][0]['message']['content'];

        $content = trim($content);
        $content = str_replace(['```json', '```'], '', $content);

        $data = json_decode($content, true);

        if (!$data) {
            throw new \Exception("Erro ao converter JSON: " . $content);
        }

        return $data;
    }
}