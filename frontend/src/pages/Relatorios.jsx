import { ChatBubbleLeftRightIcon, PhoneArrowDownLeftIcon, TicketIcon } from "@heroicons/react/24/outline";
import Button from "../components/atoms/Button";

export default function Relatorios() {
    return (
        <div className="relatorios-page">
            <div className="min-h-screen flex items-center justify-center">
                <div className="w-full max-w-md px-4 flex flex-col items-center gap-4">
                    <div>
                        <h1 className="text-xl font-semibold">Relatórios</h1>
                    </div>
                    <div className="w-full max-w-md space-y-4">
                        <Button
                            type="button"
                            text="Gerar Relatório de Tickets Abertos"
                            buttonClassName="w-full rounded-2xl h-14 shadow-md font-semibold text-green-600"
                            variant="outline"
                            icon={<TicketIcon className="h-5 w-5"/>}
                        />
                        <Button
                            type="button"
                            text="Gerar Relatório de Histórico de Ligações"
                            buttonClassName="w-full rounded-2xl h-14 shadow-md font-semibold text-green-600"
                            variant="outline"
                            icon={<PhoneArrowDownLeftIcon className="h-5 w-5"/>}
                        />
                        <Button
                            type="button"
                            text="Gerar Relatório de Solicitações Pendentes"
                            buttonClassName="w-full rounded-2xl h-14 shadow-md font-semibold text-green-600"
                            variant="outline"
                            icon={<ChatBubbleLeftRightIcon className="h-5 w-5"/>}
                        />
                    </div>
                </div>
            </div>
        </div>
    );
}