import { DataTable } from 'primereact/datatable';
import { Column } from 'primereact/column';
import { Dialog } from 'primereact/dialog';
import "primereact/resources/themes/lara-light-blue/theme.css";
import "primereact/resources/primereact.min.css";
import { PlusIcon } from '@heroicons/react/24/outline';
import { useState } from 'react';
import Button from "../components/atoms/Button";

export default function CadastroUsuarios(){
    const [visible, setVisible] = useState(false);
    //Dados para teste temporario
      const data = [
        { id: 1, nome: "Ana", email: "ana@email.com", tipo: 'Analista', ramal: 232, status: 'ativo'},
        { id: 2, nome: "Lucas", email: "lucas@email.com", tipo: 'Analista', ramal: 310, status: 'ativo'},
        { id: 3, nome: "Mikael", email: "mikael@email.com", tipo: 'Administrador', ramal: 235, status: 'ativo'},
        { id: 4, nome: "Sameul", email: "samuel@email.com", tipo: 'Analista', ramal: 233, status: 'ativo' },
        { id: 5, nome: "Pedro", email: "pedro@email.com", tipo: 'Analista', ramal: 234, status: 'inativo' },
    ];

    const Acoes = (row) => (
        <div className="flex gap-2">
            
        </div>
    );

    return (
        <div className="cadastro-page">
            <div className="min-h-screen bg-gray-50">
                <div className="mx-auto w-full max-w-3xl px-6 p-6 min-h-screen flex flex-col justify-center">
                    <div className="mb-6 flex justify-between">
                        <h1 className="text-2xl font-semibold">Cadastro de Usuários</h1>
                        <div>
                        <Button
                            type="button"
                            text="Cadastrar Usuário"
                            onClick={() => setVisible(true)}
                            buttonClassName="w-full rounded-2xl shadow-md"
                            variant="green"
                            icon={<PlusIcon className="h-5 w-5 ml-1"/>}
                            iconPos='right'
                        />
                        </div>
                    </div>
                    <div className="space-y-4">
                        <section className="rounded-2xl min-h-80 p-3 bg-white shadow-sm">
                            <DataTable value={data} stripedRows showGridlines rowHover size="medium" paginator rows={5}>
                                <Column field="nome" header="Nome"></Column>
                                <Column field="email" header="E-mail"></Column>
                                <Column field="tipo" header="Tipo"></Column>
                                <Column field="ramal" header="Ramal"></Column>
                                <Column field="status" header="Status"></Column>
                                <Column body={Acoes} header="Ações"></Column>
                            </DataTable>
                        </section>
                    </div>
                    <div className="modal-cadastro">
                        <Dialog header="Header" visible={visible} style={{ width: '50vw' }} onHide={() => { if (!visible) return; setVisible(false); }}>
                            <p className="m-0">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </p>
                        </Dialog>
                    </div>
                </div>
            </div>
        </div>
    );
}