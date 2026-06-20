<?php

namespace App\Console\Commands;

use App\Services\Asterisk\AsteriskService;
use Illuminate\Console\Command;
use Clue\React\Ami\Factory;
use Clue\React\Ami\Client;
use Illuminate\Support\Facades\Log;

class AsteriskListener extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'asterisk:listen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inicia o AMI para escutar os Ramais';

    public function __construct(
        private AsteriskService $asteriskService
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $factory = new Factory();

        $target = sprintf(
            '%s:%s@%s:%s',
            env('ASTERISK_USERNAME'),
            urlencode(env('ASTERISK_PASSWORD')),
            env('ASTERISK_HOST'),
            env('ASTERISK_PORT')
        );


        $factory->createClient($target)->then(
            function (Client $client) {
                Log::info('Conectado ao AMI');

                $client->on('event', function ($event) {

                    if (!str_starts_with($event->getFieldValue('Channel'),'Khomp/')){
                        $this->asteriskService->processarEvento($event);
                    }
                });

                $client->on('close', function () {
                    Log::warning('Conexão com AMI encerrada');
                });
            },
            function (\Exception $e) {
                Log::error('Erro ao conectar no AMI', [
                    'erro' => $e->getMessage(),
                ]);
            }
        );
    }
}
