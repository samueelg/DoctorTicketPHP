import { DataTable } from 'primereact/datatable';
import { Column } from 'primereact/column';
import "primereact/resources/themes/lara-light-blue/theme.css";
import "primereact/resources/primereact.min.css";

export default function CadastroUsuarios(){

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
                    <div className="mb-6">
                        <h1 className="text-2xl font-semibold">Cadastro de Usuários</h1>
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
                </div>
            </div>
        </div>
    );
}