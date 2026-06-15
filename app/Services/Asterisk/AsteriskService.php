<?php

namespace App\Services\Asterisk;

use App\Events\LigacaoStatusEvent;
use Clue\React\Ami\Protocol\Event;
use Illuminate\Support\Facades\Event as FacadesEvent;
use Illuminate\Support\Facades\Log;

class AsteriskService{
    public function processarEvento(Event $event): void{
        match ($event->getName()){
            'Newstate' => $this->processarNewState($event),
            'Hangup' => $this->processarHangUp($event),
            default => null
        };
    }

    public function processarNewState(Event $event){
        /**
            * 4 - Tocando
            * 6 - Atendida
        */
        $channelState = $event->getFieldValue('ChannelState');
        $ramal = $event->getFieldValue('CallerIDNum');

        if ($channelState == '4') {
            Log::info('1 Evento recebido - Ramal tocando', ['ramal: ' => $ramal]);
            FacadesEvent::dispatch(new LigacaoStatusEvent(
                ramalEvent: $ramal,
                statusEvent: 'Tocando'
            ));
        }

        if ($channelState == '6') {
            Log::info('2 Evento recebido - Ligação Atendida', ['ramal: ' => $ramal]);
            FacadesEvent::dispatch(new LigacaoStatusEvent(
                ramalEvent: $ramal,
                statusEvent: 'Ligação em andamento'
            ));
        }
    }

    public function processarHangUp(Event $event){
        /**
         * 0 - Desconhecido
         * 16 - Atendimento Finalizado
         * 17 - Usuário Ocupado (Tela Bloqueada)
         * 26 - Outra pessoa atendeu a ligação
        */
        $cause = $event->getFieldValue('Cause');
        $ramal = $event->getFieldValue('CallerIDNum');

        if ($cause == '16') {
            Log::info('3 Evento recebido - Ligação encerrada', ['ramal: ' => $ramal]);
            FacadesEvent::dispatch(new LigacaoStatusEvent(
                ramalEvent: $ramal,
                statusEvent: 'Ligação Encerrada'
            ));
        }
    }
}