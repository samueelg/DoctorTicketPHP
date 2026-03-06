import { HashRouter, Navigate, Route, Routes } from "react-router-dom";
import Inicio from "../pages/Inicio";
import Login from "../pages/auth/Login";
import LigacaoFinalizada from "../pages/LigacaoFinalizada";
import AppLayout from "../pages/layouts/AppLayout";
import Relatorios from "../pages/Relatorios";
import RelatorioBase from "../pages/RelatorioBase";
import PrivateRoute from "./AppPrivateRoutes";

export default function AppRoutes(){
    return(
        <HashRouter>
            <Routes>
                <Route path="/login" element={
                    <Login/>
                }/> 
                <Route element={<AppLayout />}>
                    <Route path="/" element={
                        <PrivateRoute>
                            <Inicio/>
                        </PrivateRoute>
                    }/>
                    <Route path="/ligacaoFinalizada" element={
                        <PrivateRoute>
                            <LigacaoFinalizada/>
                        </PrivateRoute>
                    }/>
                    <Route path="/relatorios" element={
                        <PrivateRoute>
                            <Relatorios/>
                        </PrivateRoute>
                    }/>
                    <Route path="/relatorio/base" element={
                        <PrivateRoute>
                            <RelatorioBase/>
                        </PrivateRoute>
                    }/>
                </Route>
            </Routes>
        </HashRouter>
    );
}