import { useState } from "react";
import Input from "../../components/atoms/InputField";
import Button from "../../components/atoms/Button";
import logo from "../../assets/images/oralsinlogo.jpg"

export default function Login() {
    const [email, setEmail] = useState("");
    const [senha, setSenha] = useState("");

    async function handleSubmit(e) {
        e.preventDefault();

        console.log({ email, senha });
    }

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
                    <div className="container pt-5">
                    <div className="row p-8">
                        <div className="col">
                            <div className="text-3xl">Realizar Login</div>
                        </div>
                        <div className="col">
                            <div className="container">
                                <form action="POST" onSubmit={handleSubmit}>
                                <div className="row pt-6">

                                    {/*Input E-mail */}
                                    <div className="col">
                                        <Input
                                        id='email'
                                        label='E-mail'
                                        type='email'
                                        onChange={(e) => setEmail(e.target.value)}
                                        placeholder="Digite seu e-mail"
                                        className='max-w-md mt-4'
                                        inputClassName='text-base'
                                        />
                                    </div>

                                    {/*Input Senha */}
                                    <div className="col">
                                        <Input
                                        id='senha'
                                        label='Senha'
                                        type='password'
                                        onChange={(e) => setSenha(e.target.value)}
                                        placeholder="Digite sua senha"
                                        className='max-w-md mt-4'
                                        inputClassName='text-base'
                                        />
                                    </div>

                                    {/*Input E-mail */}
                                    <div className="col">
                                        <Button
                                            type="submit"
                                            text="Entrar"
                                            className="mt-6 max-w-md"
                                            buttonClassName="w-full"
                                        />
                                    </div>
                                    <div className="col">
                                        <hr className="my-7 border-t border-gray-300" />
                                    </div>

                                    <div className="col">
                                        <div className="grid content-center">
                                        <button type="button" className="text-md text-blue-600 hover:underline hover:text-blue-300">
                                            Esqueci minha senha
                                        </button>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
