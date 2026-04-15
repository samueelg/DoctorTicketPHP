import { useRef, useState } from "react";
import { PhoneIcon } from "@heroicons/react/24/solid";
import Button from "../components/atoms/Button";
import { ligacaoService } from "../services/ligacaoService";
import { useNavigate } from "react-router-dom";
import LoadingScreen from "../components/layout/LoadingScreen";
import { Toast } from "primereact/toast";

export default function Inicio() {
  const navigate = useNavigate();
  const [loading, setLoading] = useState(false);
  const toast = useRef(null);

    function showToast(tipo, titulo, mensagem){
        toast.current.show({
            severity: tipo,
            summary: titulo,
            detail: mensagem,
            life: 3000
        });
    }
  
  async function finalizaLigacao(e) {
    //TODO - Usar audio do servidor ao invés de audio local
    e.preventDefault();
    setLoading(true);

    try{
      const result = await ligacaoService.transcrever();
      const data = result.data

      if(result.status == 200){
        navigate('/ligacaoFinalizada', {
          state: { data }
        });
      }
    }catch(error){
      navigate('/');
      showToast('error', 'Erro', 'Ocorreu um erro ao processar a requisição!');
      console.log(error);
    }finally{
      setLoading(false);
    }
  }

return (
  
  <div className="inicio-page">
    <Toast ref={toast} />
    <LoadingScreen visible={loading} />
    <div className="flex w-full h-screen relative">

      {/* Conteúdo central */}
      <main className="flex-1"></main>

      {/* Overlay central */}
      <div className="absolute inset-0 flex items-center justify-center pointer-events-none">
        <div className="flex flex-col items-center gap-3">
          <PhoneIcon className="h-28 w-28 text-gray-800" />
          <p className="text-lg text-gray-600">Aguardando Ligação...</p>
        </div>
      </div>
            <Button
              type="button"
              text="Enviar Audio"
              variant="green"
              onClick={finalizaLigacao}
            />
    </div>
  </div>
);


}