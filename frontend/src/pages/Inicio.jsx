import { useState } from "react";
import { PhoneIcon } from "@heroicons/react/24/solid";

export default function Inicio() {

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
    </div>
  </div>
);


}