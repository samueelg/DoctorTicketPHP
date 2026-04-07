import { useState } from "react";
import { PhoneIcon } from "@heroicons/react/24/solid";
import Button from "../components/atoms/Button";
import { ligacaoService } from "../services/ligacaoService";

export default function Inicio() {

  async function enviarAudio(e) {
    e.preventDefault();
    console.log('abriu');
    const response = await fetch("/audio/audio4.mp3"); // pode ser local/public
    const blob = await response.blob();

    const formData = new FormData();
    formData.append("audio", blob, "audio.mp3");

    const result = await ligacaoService.transcrever(formData);

    console.log(result.data);
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