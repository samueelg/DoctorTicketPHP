import { Outlet } from "react-router-dom";
import { Sidebar } from "../../components/layout/Sidebar";
import UserData from "../../components/layout/UserData";

export default function AppLayout(){
    return (
    <div className="flex h-screen">
        <Sidebar />
        <main className="flex-1 overflow-auto">
            <Outlet />
        </main>

        <UserData/>
    </div>
    );
}