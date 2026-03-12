import { DataTable } from 'primereact/datatable';
import { Column } from 'primereact/column';
import { Dialog } from 'primereact/dialog';
import "primereact/resources/themes/lara-light-blue/theme.css";
import "primereact/resources/primereact.min.css";
import { PencilIcon, PlusIcon, TrashIcon } from '@heroicons/react/24/outline';
import { useEffect, useState } from 'react';
import Button from "../components/atoms/Button";
import { usuariosService } from '../services/usuarioService';
import InputField from "../components/atoms/InputField";
import { Toast } from 'primereact/toast';
import { useRef } from 'react';


export default function CadastroUsuarios(){
    const [usuarios, setUsuarios] = useState([]);
    const [visible, setVisible]   = useState(false);
    const [erros, setErro]         = useState('');
    const [loading, setLoading]   = useState(true);
    const [checked, setChecked]   = useState(false);
    const [nome,setNome]          = useState('');
    const [ramal, setRamal]       = useState('');
    const [senha, setSenha]       = useState('');
    const [tipo, setTipo]         = useState('');
    const [email,setEmail]        = useState('');
    const toast = useRef(null);

    //Carrega os dados ao iniciar a página
    useEffect(() => {
        getUsuarios();
    },[]);

    function showToast(tipo, titulo, mensagem){
        toast.current.show({
            severity: tipo,
            summary: titulo,
            detail: mensagem,
            life: 3000
        });
    }

    async function getUsuarios(){
        try{
            const response = await usuariosService.list();
            setUsuarios(response.data.data);
        }catch(err){
            setErro('Erro ao buscar usuários.');
            console.log(err);
        }finally{
            setLoading(false);
        }
    }

    async function cadastrarUsuarioSubmit(e) {
        e.preventDefault();
        const data = {
            nome,
            tipo,
            ramal,
            email,
            senha
        }

        setErro({});
        try {
            const response = await usuariosService.create(data);

            console.log(response);

            if (response.status == 201) {
                setVisible(false);
                showToast('success', 'Sucesso', 'Usuário cadastrado com sucesso!');
                getUsuarios();
            }
        } catch (err) {
            const errosApi = err.response?.data?.errors || {};
            setErro(errosApi);
            console.log('erros: ',erros);
        }
    }

    //Buttons ações
    const Acoes = (row) => (
        <div className="flex gap-2">
            {/* Botão de editar */}
            <Button
                type="button"
                text=""
                onClick={() => setVisible(true)}
                buttonClassName="w-full"
                variant="none"
                icon={<PencilIcon className="h-4 w-4" />}
                iconPos='right'
            />
            {/* Botão de Excluir */}
            <Button
                type="button"
                text=""
                onClick={() => setVisible(true)}
                buttonClassName="w-full"
                variant="none"
                icon={<TrashIcon className="h-4 w-4" />}
                iconPos='right'
            />
        </div>
    );

    const statusTemplate = (rowData) => {
        const status = rowData.status;

        switch(status){
        case 'ativo':
            return <span className='inline-block w-20 text-center bg-green-500 px-2 py-1 rounded-full text-sm text-white'>Ativo</span>;
        case 'inativo':
            return <span className='inline-block w-20 text-center bg-red-500 px-2 py-1 rounded-full text-sm text-white'>Inativo</span>;
        default:
                return <span className='font-semibold'>Não Informado</span>;
        }
    }

    const tipoTemplate = (rowData) => {
        const tipo = rowData.tipo;

        switch(tipo){
            case 'analista':
                return <span className='inline-block w-20 text-center bg-blue-300 px-2 py-1 rounded-full text-sm text-white'>Analista</span>;
            case 'admin':
                return <span className='inline-block w-20 text-center bg-purple-300 px-2 py-1 rounded-full text-sm text-white'>Admin</span>;
            default:
                return <span className='font-semibold'>Não Informado</span>;
        }
    }

    const emailTemplate = (rowData) => {
        const email = rowData.email;

        if(email){
            return email;
        }
        return <span className='font-semibold'>Não Informado</span>;

    }

    const ramalTemplate = (rowData) => {
        const ramal = rowData.ramal;

        if (ramal) {
            return <span className='italic'>{ramal}</span>;
        }
        return <span className='font-semibold'>Não Informado</span>;
    }


    return (
        <div className="cadastro-page">
             <Toast ref={toast} />
            <div className="min-h-screen bg-gray-50">
                <div className="mx-auto w-full max-w-4xl px-6 p-6 min-h-screen flex flex-col justify-center">
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
                    <div id="table-usuarios" className="space-y-4">
                        <section className="rounded-2xl min-h-80 p-3 bg-white shadow-sm">
                            <DataTable value={usuarios} stripedRows showGridlines rowHover size="medium" loading={loading} paginator rows={5}>
                                <Column field="nome" header="Nome" body={(rowData) => rowData.nome ?? "Não Informado"}></Column>
                                <Column field="email" header="E-mail" body={emailTemplate}></Column>
                                <Column field="tipo" header="Tipo" body={tipoTemplate ?? "Não Informado"}></Column>
                                <Column field="ramal" header="Ramal" body={ramalTemplate}></Column>
                                <Column field="status" header="Status" body={statusTemplate}></Column>
                                <Column body={Acoes} header="Ações"></Column>
                            </DataTable>
                        </section>
                    </div>

                    <div className="modal-cadastro">
                        <Dialog header="Cadastro de Usuário" visible={visible} style={{ width: '50vw' }} onHide={() => { if (!visible) return; setVisible(false); }}>
                            <form action="POST" onSubmit={cadastrarUsuarioSubmit}>
                            <div className="justify-center mb-3">
                                <div className="flex flex-row">
                                    <div className='mb-2'>
                                        <input type="radio" value="analista" id="tipoAnalista" name="tipoUsuario" className="w-5 h-5" onChange={(e) => setTipo(e.target.value)}/>
                                        <label className="ml-2" labelFor="checkAnalista">Analista</label>
                                    </div>
                                    <div className='mb-2 ml-4'>
                                        <input type="radio" value="admin" id="tipoAdmin" name="tipoUsuario" className="w-5 h-5" onChange={(e) => setTipo(e.target.value)}/>
                                        <label className="ml-2" labelFor="checkAnalista">Aministrador</label>
                                    </div>
                                </div>
                                    {erros.tipo && (
                                        <small className="text-red-500">{erros.tipo[0]}</small>
                                    )}

                                <div className="flex flex-row mb-2">
                                    <div className="w-full">
                                        <InputField
                                            id='nomeCadastro'
                                            type='text'
                                            label={'Nome do Usuário'}
                                            onChange={(e) => setNome(e.target.value)}
                                             placeholder="Digite o nome do analista"
                                            className='w-full'
                                            inputClassName={`text-base ${erros.nome ? 'border-red-500' : ''}`}
                                        />

                                        {erros.nome && (
                                            <small className="text-red-500">{erros.nome[0]}</small>
                                        )}
                                    </div>
                                </div>
                                <div className="flex flex-row mb-2">
                                        <div className='w-full'>
                                            <InputField
                                                id='emailCadastro'
                                                type='text'
                                                label={'E-mail'}
                                                onChange={(e) => setEmail(e.target.value)}
                                                placeholder="Digite o e-mail do usuário"
                                                className='w-full'
                                                inputClassName={`text-base ${erros.email ? 'border-red-500' : ''}`}
                                            />
                                            
                                            {erros.email && (
                                                <small className="text-red-500">{erros.email[0]}</small>
                                            )}
                                        </div>
                                </div>
                                <div className='grid grid-cols-2 gap-2'>
                                        <div className='w-full'>
                                            <InputField
                                                id='ramalCadastro'
                                                type='text'
                                                label={'Ramal:'}
                                                onChange={(e) => setRamal(e.target.value)}
                                                placeholder="Digite o ramal"
                                                className='w-full'
                                                inputClassName={`text-base ${erros.ramal ? 'border-red-500' : ''}`}
                                            />

                                            {erros.ramal && (
                                                <small className="text-red-500">{erros.ramal[0]}</small>
                                            )}
                                        </div>
                                        <div className='w-full'>
                                            <InputField
                                                id='nomeAnalista'
                                                type='password'
                                                label={'Senha:'}
                                                onChange={(e) => setSenha(e.target.value)}
                                                placeholder="Digite a senha"
                                                className='w-full'
                                                inputClassName={`text-base ${erros.senha ? 'border-red-500' : ''}`}
                                            />

                                            {erros.senha && (
                                                <small className="text-red-500">{erros.senha[0]}</small>
                                            )}
                                        </div>
                                </div>
                            </div>
                            <div className='flex flex-row justify-end'>
                                <Button
                                    type="submit"
                                    text="Cadastrar Usuário"
                                    buttonClassName="w-full rounded-2xl shadow-md"
                                    variant="green"
                                />
                            </div>
                        </form>
                        </Dialog>
                    </div>
                </div>
            </div>
        </div>
    );
}