import Button from "../components/atoms/Button";
import InputField from "../components/atoms/InputField";
import { FunnelIcon } from "@heroicons/react/24/outline";

export default function RelatorioBase(){
    return (
        <div className="relatorio-base-page">
            <div className="min-h-screen bg-gray-50">
                <div className="mx-auto w-full max-w-2xl px-6 p-6">
                    <div className="mb-6">
                        <h1 className="text-2xl font-semibold">Relatório</h1>
                    </div>
                    <div className="space-y-4">
                        <section className="rounded-2xl p-3 bg-white shadow-sm">
                            <div className="border-b mb-4 flex items-center">
                                <FunnelIcon className="h-6 w-6 text-green-500" />
                                <h1 className="text-xl">Filtros</h1>
                            </div>
                            {/* Inputs */}
                            <div className="grid grid-cols-2 gap-6">
                                <InputField
                                    label={'Data Inicio'}
                                    id='dataInicio'
                                    type='date'
                                    className='max-w-sm h-14'
                                    inputClassName='text-base'
                                />
                                
                                <InputField
                                    label={'Data Fim'}
                                    id='dataFim'
                                    type='date'
                                    className='max-w-sm h-14'
                                    inputClassName='text-base'
                                />
                            </div>
                            <div className="mx-auto mt-4 mb-2">
                                <InputField
                                    label={'Usuário'}
                                    id='nomeUsuario'
                                    placeholder={'Digite o nome do usuário'}
                                    className='h-14'
                                    type='text'
                                    inputClassName='text-base'
                                />
                            </div>

                            {/* Buttons */}
                            <div className="grid grid-cols-4 py-2 gap-1">
                                <div className="col-span-3">
                                <Button
                                    text={'Aplicar'}
                                    buttonClassName="w-full h-8 rounded-2xl shadow-sm"
                                />
                                </div>
                                <div className="col-span-1">
                                <Button
                                    text={'Limpar'}
                                    className="w-full"
                                    variant="outline"
                                    buttonClassName="w-full h-8 rounded-2xl shadow-sm font-semibold"
                                />
                                </div>
                            </div>
                        </section>
                        <section className="rounded-2xl p-3 bg-white shadow-sm">
                            <div className="mb-4">
                                <h1 className="text-xl">Dados Encontrados</h1>
                            </div>

                            <div id="dataTicket" className="rounded-xl border m-4 p-3 bg-white shadow-md">
                                <div className="flex flex-cols gap-4">
                                    <div className="my-auto">
                                        <h1 id="idTicket" className="text-xs text-gray-500">TK-000000</h1>
                                    </div>
                                    <div className="rounded-xl bg-green-600 text-white p-1 h-6 w-auto text-center">
                                        <h1 id="ticketStatus" className="text-xs">Concluído</h1>
                                    </div>
                                </div>
                                <div id="divTitulo">
                                    <h1 id="tituloTicket" className="font-semibold text-md">Titulo Ticket</h1>
                                </div>
                                <div id="divSolicitante">
                                    <h1 id="solicitanteTicket" className="text-gray-500 text-sm">Solicitante</h1>
                                </div>
                                <div id="divAnalista">
                                    <h1 id="analistaTicket" className="text-gray-500 text-sm">Analista</h1>
                                </div>
                                <div id="divData">
                                    <h1 id="dataTicket" className="text-gray-500 text-sm">Data/Hora</h1>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    );
}