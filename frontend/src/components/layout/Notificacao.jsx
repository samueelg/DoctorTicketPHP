import { BellIcon } from "@heroicons/react/24/outline";
import { Badge } from 'primereact/badge';
import Button from "../atoms/Button";
import { OverlayPanel } from "primereact/overlaypanel";
import { useRef } from "react";

export function Notificacao() {
    const op = useRef(null);

    function abreOverlay(e) {
        op.current?.toggle(e);
    }

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

            {/* Notificação */}
            <button className="w-full text-left px-3 py-3 hover:bg-gray-50 transition">
                <p className="text-sm font-medium text-gray-900">
                    Novo Ticket transferido para sua fila.
                </p>

                <p className="text-sm text-gray-500">
                    Um ticket foi transferido para a sua fila.
                </p>

                <span className="text-xs text-gray-400">
                    há 2 min
                </span>
            </button>

            {/* Não lida */}
            <button className="w-full text-left px-3 py-3 hover:bg-gray-50 transition">
                <div className="flex gap-2">
                    <div className="w-2 h-2 rounded-full bg-gray-900 mt-1.5 shrink-0" />

                    <div>
                        <p className="text-sm font-medium text-gray-900">
                            Pagamento recebido
                        </p>

                        <p className="text-sm text-blue-500">
                            Você recebeu R$ 250,00.
                        </p>

                        <span className="text-xs text-gray-400">
                            há 1 h
                        </span>
                    </div>
                </div>
            </button>

            {/* Notificação */}
            <button className="w-full text-left px-3 py-3 hover:bg-gray-50 transition">
                <p className="text-sm font-medium text-gray-900">
                    Atualização do sistema
                </p>

                <p className="text-sm text-gray-500">
                    Nova versão disponível.
                </p>

                <span className="text-xs text-gray-400">
                    ontem
                </span>
            </button>

            {/* Exemplo extra pra testar scroll */}
            <button className="w-full text-left px-3 py-3 hover:bg-gray-50 transition">
                <p className="text-sm font-medium text-gray-900">
                    Backup concluído
                </p>

                <p className="text-sm text-gray-500">
                    Seus dados foram salvos.
                </p>

                <span className="text-xs text-gray-400">
                    ontem
                </span>
            </button>

        </div>
    </div>
</OverlayPanel>
        </div>
    );
}