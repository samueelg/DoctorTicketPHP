import { useRef, useState } from "react";
import Button from "../components/atoms/Button";
import { useNavigate } from "react-router-dom";
import LoadingScreen from "../components/layout/LoadingScreen";
import { Toast } from "primereact/toast";
import { MicrophoneIcon, StopIcon } from "@heroicons/react/24/outline";

export default function GravaAudio() {
  const navigate = useNavigate();
  const [loading, setLoading] = useState(false);
  const [isRecording, setRecording] = useState(false);
  const mediaRecorderRef = useRef(null);
  const toast = useRef(null);
  const chunksRef = useRef([]);
  
  function showToast(tipo, titulo, mensagem) {
    toast.current.show({
      severity: tipo,
      summary: titulo,
      detail: mensagem,
      life: 3000
    });
  }
  
  async function iniciaGravacao(e) {
    //TODO - Usar audio do servidor ao invés de audio local
    e.preventDefault();

    try {
      const stream = await navigator.mediaDevices.getUserMedia({ audio: true });

      const mediaRecorder = new MediaRecorder(stream);
      mediaRecorderRef.current = mediaRecorder;
      chunksRef.current = [];

      mediaRecorder.ondataavailable = (e) => {
        if (e.data.size > 0) {
          chunksRef.current.push(e.data);
        }
      };

      mediaRecorder.onstop = () => {
        const blob = new Blob(chunksRef.current, { type: "audio/webm" });
        const url = URL.createObjectURL(blob);

        console.log("Áudio gravado:", url);

        // opcional: tocar
        new Audio(url).play();

        stream.getTracks().forEach(track => track.stop());
      };

      mediaRecorder.start();
      setRecording(true);
    } catch (err) {
      console.error("Erro ao acessar microfone:", err);
    }
  }

  function finalizaGravacao() {
    if (mediaRecorderRef.current) {
      mediaRecorderRef.current.stop();
      setRecording(false);
    }
  }
    

    // try {
    //   const result = await ligacaoService.transcrever();
    //   const data = result.data

    //   if (result.status == 200) {
    //     navigate('/ligacaoFinalizada', {
    //       state: { data }
    //     });
    //   }
    // } catch (error) {
    //   navigate('/');
    //   showToast('error', 'Erro', 'Ocorreu um erro ao processar a requisição!');
    //   console.log(error);
    // } finally {
    //   setLoading(false);
    // }

  async function finalizaGravacao(e){
    setRecording(false);
  }

  return (

    <div className="inicio-page">
      <Toast ref={toast} />
      <LoadingScreen visible={loading} />
      <div className="flex w-full h-screen relative">

        {/* Conteúdo central */}
        <main className="flex-1"></main>

        {/* Overlay central */}
        <div className="absolute inset-0 flex items-center justify-center">
          <div className="flex flex-col items-center gap-3">
            <span className="text-xl font-semibold">Gravação de Áudio</span>
            <span className="text-sm text-gray-500 w-80 text-center mb-4">Em poucas palavras diga o assunto da ligação, seu nome, o solicitante e a unidade...</span>
            <div className="flex items-center justify-center">
                <Button
                  text=""
                  type="button"
                  variant="none"
                  onClick={(isRecording)? finalizaGravacao : iniciaGravacao}
                  buttonClassName={`
                    ${isRecording ? "bg-red-600 animate-pulse" : "bg-black hover:scale-105"}
                    rounded-full
                    p-10
                    shadow-lg
                    transition
                    `}
                    icon={isRecording ? (<StopIcon className="h-16 w-16 text-white" />) : (<MicrophoneIcon className="h-16 w-16 text-white" />)}
                />
            </div>
              {(isRecording)
              ? <p className="text-xs text-gray-500 mt-2">Gravando...</p> 
              : <p className="text-xs text-gray-500 mt-2">Toque para começar</p>
              }
          </div>
        </div>
      </div>
    </div>
  );


}