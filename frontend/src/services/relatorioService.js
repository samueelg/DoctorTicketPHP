import { api } from "./api";

export const relatorioService = {
  getTicketsChat: (params) => api.get('/relatorios/getTicketsChat', params)
};