from fastapi import FastAPI, UploadFile, File
from faster_whisper import WhisperModel
import json
from pathlib import Path
import tempfile
import os

app = FastAPI()

# Carrega o modelo uma vez quando o container inicia
model = WhisperModel(
    "small",
    device="cpu",
    compute_type="int8"
)

config_path = Path(__file__).parent / "config" / "prompts.json"

with open(config_path, "r", encoding="utf-8") as f:
    config = json.load(f)

initial_prompt = config["initial_prompt"]
hotwords = ", ".join(config["hotwords"])

@app.post("/transcribe")
async def transcribe(audio: UploadFile = File(...)):
    # pega extensão do arquivo enviado
    ext = os.path.splitext(audio.filename or "")[1]
    if not ext:
        ext = ".wav"

    temp_path = None

    try:
        # salva temporariamente o áudio
        with tempfile.NamedTemporaryFile(delete=False, suffix=ext) as temp:
            content = await audio.read()
            temp.write(content)
            temp_path = temp.name

        # faz a transcrição
        segments, info = model.transcribe(
            temp_path,
            language="pt",
            task="transcribe",
            beam_size=4,
            vad_filter=True,
            initial_prompt=initial_prompt,
            hotwords=hotwords
            )

        texto = " ".join(segment.text.strip() for segment in segments).strip()

        return {
            "success": True,
            "text": texto,
            "language": info.language,
            "language_probability": info.language_probability
        }

    except Exception as e:
        return {
            "success": False,
            "error": str(e)
        }

    finally:
        if temp_path and os.path.exists(temp_path):
            os.remove(temp_path)