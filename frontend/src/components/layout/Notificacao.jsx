import { BellIcon } from "@heroicons/react/24/outline";
import { Badge } from 'primereact/badge';
import Button from "../atoms/Button";
import { OverlayPanel } from "primereact/overlaypanel";
import { useEffect, useRef, useState } from "react";
import echo from "../../services/echo";

export function Notificacao() {
    const op = useRef(null);
    const [notificacoes, setNotificacoes] = useState([]);

    function abreOverlay(e) {
        op.current?.toggle(e);
    }

    useEffect(() => {
        //Ajstar depois para private e para ecutar o usuário da sessão
        echo.channel('usuario.1')
            .listen('.notificacao.criada', (e) => {

                console.log('NOTIFICAÇÃO RECEBIDA');

                console.log(e);

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
            <Badge
                className="!text-xs !min-w-5 !h-5 flex items-center justify-center pointer-events-none"
                severity="danger"
                value="2"
            />
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
                <div key={index}>
                    <h3>{n.titulo}</h3>
                    <p>{n.mensagem}</p>
                </div>
            ))}

        </div>
    </div>
</OverlayPanel>
        </div>
    );
}