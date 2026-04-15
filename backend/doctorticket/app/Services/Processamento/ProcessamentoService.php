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

            Sua tarefa é analisar a transcrição de uma ligação e extrair informações estruturadas para criação de um chamado no Movidesk.

            Retorne APENAS um JSON válido no seguinte formato:

            {
            "titulo": "Solicitação Telefone - (Tipo da solicitação)",
            "assunto": "",
            "solicitante": "",
            "unidade": ""
            }

            Regras:
            - "titulo": "Solicitação Telefone - (resumo curto e claro do problema (máximo 10 palavras)"
            - "assunto": Preencha as informaçẽos coletadas com base na seguinte estrutura:
                Olá! Bom dia/Boa tarde!\n\n

                Foi registrado a Solicitação por telefone ao SAF.\n\n

                Dúvida/Solicitação: (Solicitação feita pelo franqueado, ou duvida referente ao sistema)\n\n

                Orientação/Solução: (Descreva de forma objetiva a ação realizada pelo analista para resolver a solicitação, siga essas regras: 1.Use frases curtas e diretas; 2.Descreva a ação concluída (ex: "Transferência de paciente realizada"); 3.Sempre escrever no passado. Exemplo de Respostas Validas: 1."Transferência de paciente realizada conforme solicitado"; 2."Auxílio na alteração de contrato atráves do AnyDesk"; 3."Contrato cancelado revertido durante a ligação") 

                Solicitante: (Se não houver, colocar: Não informado)\n\n

                Paciente: (Se não houver, colocar: Não informado)\n\n

                Unidade: (Se não houver, colocar: Não informado)\n\n

                A sua avaliação é muito importante, se possível avalie o meu atendimento através da mensagem desse ticket. Obrigado!\n\n
            
            - "solicitante": nome da pessoa que iniciou a ligação
            - "unidade": cidade ou unidade da clínica mencionada (se não encontrar, retornar "Não informado")

            Variaveis:' . "
            hora = {$horario}
            " . '

            Regras importantes:
            - Se hora < 12, use "Bom dia" no assunto 
            - Se hora >= 12, use "Boa tarde"
            - NÃO inventar informações
            - Se não souber algum campo, usar "Não informado"
            - Respeitar a estrutura do assunto, deixando no mesmo formato
            - Corrigir pequenos erros de português da transcrição
            - Entender contexto mesmo com fala informal
            - Identificar o problema principal da ligação

            Considere que os problemas mais comuns incluem:
            -Transferencia de paciente entre unidades
            -Ajuda para alteração de contrato
            -Reverter paciente finalizado no sistema
            -Reverter contrato cancelado
            -Ajuda com agendamento de paciente
            -Duvida sobre problema no sistema
            ' . "
            Transcrição:
            {{$transcricao}}
            " . '
            Responda apenas com JSON válido, sem explicações adicionais.
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