import { PhoneIcon } from "@heroicons/react/24/solid";
import { HomeIcon,UserIcon,Cog6ToothIcon,ChatBubbleLeftRightIcon, FolderIcon } from "@heroicons/react/24/outline";

export default function Inicio() {

return (
  <div className="inicio-page">
    <div className="flex w-full h-screen relative">
      {/* Barra lateral */}
      <aside className="w-20 flex-none border-r">
        <nav className="h-full flex flex-col items-center gap-6 py-6">
          <button className="flex flex-col items-center gap-1 text-gray-600 hover:text-gray-900">
            <HomeIcon className="h-6 w-6" />
            <span className="text-[10px] leading-none">Início</span>
          </button>

          <button className="flex flex-col items-center gap-1 text-gray-600 hover:text-gray-900">
            <FolderIcon className="h-6 w-6" />
            <span className="text-[10px] leading-none">Relatórios</span>
          </button>

          <button className="flex flex-col items-center gap-1 text-gray-600 hover:text-gray-900">
            <ChatBubbleLeftRightIcon className="h-6 w-6" />
            <span className="text-[10px] leading-none">Dashboard</span>
          </button>

          <button className="flex flex-col items-center gap-1 text-gray-600 hover:text-gray-900">
            <UserIcon className="h-6 w-6" />
            <span className="text-[10px] leading-none">Perfil</span>
          </button>

          <button className="mt-auto flex flex-col items-center gap-1 text-gray-600 hover:text-gray-900">
            <Cog6ToothIcon className="h-6 w-6" />
            <span className="text-[10px] leading-none">Config</span>
          </button>
        </nav>
      </aside>

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