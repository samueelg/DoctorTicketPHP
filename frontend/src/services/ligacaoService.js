import { api } from "./api";

export const ligacaoService = {
  transcrever: () => api.post('/transcrever')
};