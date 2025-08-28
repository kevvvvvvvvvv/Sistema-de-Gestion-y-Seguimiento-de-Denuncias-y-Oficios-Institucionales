import { Link } from '@inertiajs/react';
import ApplicationLogo from '@/Components/ApplicationLogo';

export default function MainLayout({ children, auth, topHeader, insideHeader }) {
    return (
        <main className="grid grid-cols-5 gap-4 h-screen bg-[#F9F7F5]">

            {/* Sidebar Izquierdo */}
            <div className="col-span-1 grid grid-rows-[20%_60%_20%] my-10 items-center justify-center">
                <div>
                    <ApplicationLogo className="h-[140px] w-[220px] fill-current text-gray-500" />
                </div>

                <div></div>

                <div>
                    <p className='mb-4'>{auth.user?.nombre} {auth.user?.apPaterno}</p>
                    <Link 
                        className="flex items-center" 
                        href={route('logout')} 
                        method="post" 
                        as="button"
                    >
                        <svg 
                            xmlns="http://www.w3.org/2000/svg" 
                            fill="none" 
                            viewBox="0 0 24 24" 
                            strokeWidth="1.5" 
                            stroke="currentColor" 
                            className="size-6 mr-2"
                        >
                            <path 
                                strokeLinecap="round" 
                                strokeLinejoin="round" 
                                d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" 
                            />
                        </svg>
                        <p>Cerrar sesión</p>
                    </Link>
                </div>
            </div>

            {/* Contenido central */}
            <div className="col-span-3">
                <div className="flex items-center mb-6 mt-6">
                    <button className="rounded-xl font-bold justify-center text-sm text-black border border-[#A7A7A7] p-2 flex items-center bg-[#FFFFFF] hover:bg-cafeIMTA hover hover:text-white transition">
                        <svg 
                            xmlns="http://www.w3.org/2000/svg" 
                            fill="none" 
                            viewBox="0 0 24 24" 
                            strokeWidth="1.5" 
                            stroke="currentColor" 
                            className="size-6"
                        >
                            <path 
                                strokeLinecap="round" 
                                strokeLinejoin="round" 
                                d="M15.75 19.5 8.25 12l7.5-7.5" 
                            />
                        </svg>
                        Atrás
                    </button>
                    <h1 className="text-[20px] ml-5 font-bold"> {topHeader} </h1>
                </div>

                <div className="rounded-3xl bg-[#FFFFFF] mb-10 p-8 h-[85vh] ">
                    <h2 className='text-xl font-semibold'>{insideHeader}</h2>
                    {children}
                </div>
            </div>

            {/* Sidebar Derecho */}
            <div className="mt-16 col-span-1 grid grid-rows-[28%_5%_55%_20%] items-center">
                <div className="justify-center text-center">
                    <div className="m-5 rounded-xl bg-[#FFFFFF] flex flex-col items-center justify-center p-5">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            strokeWidth={1.5}
                            stroke="currentColor"
                            className="w-12 h-12 mb-2"
                        >
                            <path
                            strokeLinecap="round"
                            strokeLinejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"
                            />
                        </svg>

                        <span className="text-center font-medium">
                            {auth.user?.nombre} {auth.user?.apPaterno} 
                        </span>
                    </div>
                </div>
                <div className="flex items-center my-4 px-6">
                    <div className="flex-grow border-t border-gray-400"></div>
                        <span className="mx-4 text-gray-600">Notificaciones</span>
                    <div className="flex-grow border-t border-gray-400"></div>
                </div>

            </div>
        </main>
    );
}
