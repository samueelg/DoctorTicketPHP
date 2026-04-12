import { useState } from "react";
import { PhoneIcon } from "@heroicons/react/24/solid";
import Button from "../components/atoms/Button";
import { ligacaoService } from "../services/ligacaoService";
import { useNavigate } from "react-router-dom";

export default function Inicio() {
  const navigate = useNavigate();

  async function enviarAudio(e) {
    e.preventDefault();
    //TODO - Usar audio do servidor ao invés de audio local
    const result = await ligacaoService.transcrever();
    const data = result.data

    if(result.status == 200){
      navigate('/ligacaoFinalizada', {
        state: { data }
      });
    }
  }

return (
  <div className="inicio-page">
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
              onClick={enviarAudio}
            />
    </div>
  </div>
);


}