import { BellIcon, XCircleIcon } from "@heroicons/react/24/outline";
import { Badge } from 'primereact/badge';
import Button from "../atoms/Button";
import { OverlayPanel } from "primereact/overlaypanel";
import { useEffect, useRef, useState } from "react";
import echo from "../../services/echo";
import { notificacaoService } from "../../services/notificacaoService";

export function Notificacao() {
    const op = useRef(null);
    const [notificacoes, setNotificacoes] = useState([]);
    const [erro, setErro] = useState();
    const qtdeNotificacoes = notificacoes.filter(n => !n.lida_em).length;

    function abreOverlay(e) {
        op.current?.toggle(e);
    }

    async function lerNotificacao(notificacao){
        try{
            if(notificacao.lida_em){
                return;
            }

            const response = await notificacaoService.ler(notificacao.id)

            if(response.status == 200 && response.data.success){
                carregarNotificacoes();
            }

        }catch(err){
            setErro(err);
            console.log(err)
        }
    }

    async function removeNotificacao(notificacao){
        try{
            const idNotificacao = notificacao.id;

            //TODO - Adicionar debounce para enviar varias de uma vez
            const response = await notificacaoService.remover(idNotificacao);

            if(response.status == 200){
                carregarNotificacoes();
            }
        }catch(error){
            setErro(error);
            console.log(error);
        }
    }

    async function carregarNotificacoes() {
        try {

            const response = await notificacaoService.listar();

            setNotificacoes(response.data.data);

        } catch (error) {
            setErro(error);
            console.error('Erro ao carregar notificações', error);
        }
    }

    useEffect(() => {

    carregarNotificacoes();

        //Ajstar depois para private e para ecutar o usuário da sessão
        echo.channel('usuario.1')
            .listen('.notificacao.criada', (e) => {
                setNotificacoes(prev => [
                    e,
                    ...prev
                ]);
            });

        return () => {
            echo.leave('usuario.1');
        };}, []);

    return (
        <div className="flex justify-end pr-4 pt-4">
            <Button
                variant="none"
                buttonClassName="p-overlay-badge relative p-0"
                icon={<BellIcon className="h-8 w-8" />}
                onClick={abreOverlay}
            >
            
            {(qtdeNotificacoes > 0) ?
            <Badge
                className="!text-xs !min-w-5 !h-5 flex items-center justify-center pointer-events-none"
                severity="danger"
                value={qtdeNotificacoes}
            />
            : ''}
            </Button>

            <OverlayPanel
    ref={op}
    className="w-72 p-0 overflow-hidden"
>
    <div className="bg-white rounded-lg">

        {/* Header */}
        <div className="flex items-center justify-between px-3 py-2 border-b">
            <h2 className="text-base font-semibold text-gray-800">
                Notificações
            </h2>

            <button className="text-xs font-medium text-gray-600 hover:text-black transition">
                ✓ Marcar todas
            </button>
        </div>

        {/* Lista com scroll */}
        <div className="divide-y max-h-80 overflow-y-auto">

                        {notificacoes.map((n, index) => (
                            <div key={index} onClick={() => lerNotificacao(n)}>
                                <button className="w-full text-left px-3 py-1 hover:bg-gray-50 transition">
                                    <div className={n.lida_em ? "" : "flex gap-2"}>
                                        {!n.lida_em && (
                                            <div className="w-2 h-2 rounded-full bg-gray-900 mt-1.5 shrink-0" />
                                        )}

                                        <div>
                                            <div className="flex justify-between items-center">
                                            <p className="text-sm font-medium text-gray-900">
                                                {n.titulo}
                                            </p>
                                            <Button
                                                icon={<XCircleIcon className="h-5 w-5"/>}
                                                variant="none"
                                                onClick={() => removeNotificacao(n)}
                                            />
                                            </div>

                                            <p
                                                className={`text-sm ${n.lida_em ? "text-gray-500" : "text-blue-500"
                                                    }`}
                                            >
                                                {n.mensagem}
                                            </p>

                                            <span className="text-xs text-gray-400">
                                                {n.tempo}
                                            </span>
                                        </div>
                                    </div>
                                </button>
                            </div>
                        ))}

        </div>
    </div>
</OverlayPanel>
        </div>
    );
}