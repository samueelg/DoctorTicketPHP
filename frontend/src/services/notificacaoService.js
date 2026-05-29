import { api } from "./api";

export const notificacaoService = {
    create: (payload) => api.post("/notificacao", payload),
}