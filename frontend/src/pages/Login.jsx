import { useState } from "react";
import Input from "../components/atoms/InputField";
import Button from "../components/atoms/Button";
import logo from "../assets/images/oralsinlogo.jpg"

export default function Login() {
    const [email, setEmail] = useState("");

    return (
        <div className="login-page">
            <div className="flex w-full h-screen">
                <div className="w-[45%] bg-slate-50 flex justify-center items-center">
                    <div className="grid grid-rows-3">
                        <div className="row-span-2">
                            <img className="rounded-xl size-56" src={logo} alt="logo" />
                        </div>
                        <div className="flex justify-center mt-2">
                            <h1 className="text-lg font-sans font-semibold">Oral Sin Franchising</h1>
                        </div>
                    </div>
                </div>

                <div className="w-[55%]">
                    Coluna 2 (60%)
                </div>
            </div>
        </div>
    );
}
