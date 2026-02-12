import { HashRouter, Navigate, Route, Routes } from "react-router-dom";
import Inicio from "./Inicio";
import Login from "./auth/Login";
import AppLayout from "./layouts/AppLayout";

export default function App(){
    return(
        <HashRouter>
            <Routes>
                <Route element={<AppLayout />}>
                    <Route path="/" element={<Inicio/>}/>
                     <Route path="/login" element={<Login/>}/>
                    <Route path="*" element={<Navigate to="/" replace />} />
                </Route>
            </Routes>
        </HashRouter>
    );
}