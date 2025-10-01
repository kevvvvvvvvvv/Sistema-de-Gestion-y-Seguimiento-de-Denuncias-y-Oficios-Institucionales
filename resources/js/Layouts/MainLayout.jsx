import { Link, router } from '@inertiajs/react';
import { useState } from 'react'
import ApplicationLogo from '@/Components/ApplicationLogo';
import { Archive, House, StickyNote } from 'lucide-react';
import SidebarDropdown from '@/Components/SidebarDropdown';

export default function MainLayout({ children, auth, topHeader, insideHeader, backURL }) {

    const [open, setOpen] = useState(false)

    const viajerosItems = [];
    const expedientesItems = [];

    if (auth.permissions.includes('consultar viajeros')) {
        viajerosItems.push({ text: 'Ver viajeros', href: route('viajeros.index') });
    }

    if (auth.permissions.includes('crear viajeros')){
        viajerosItems.push({ text: 'Agregar un nuevo viajero', href: route('viajeros.create') });
    }

    if(auth.permissions.includes('consultar expedientes')){
        expedientesItems.push({ text: 'Ver expedientes', href: route('expedientes.index') });
    }

    if(auth.permissions.includes('crear expedientes')){
        expedientesItems.push({ text: 'Agregar un nuevo expediente', href: route('expedientes.create') });
    }

    return (
        <main className="grid grid-cols-5 gap-4 h-screen bg-[#F9F7F5]">

            {/* Sidebar Izquierdo */}
            <div className="col-span-1 grid grid-rows-[20%_60%_20%] m-10 justify-center gap-8">
                <a className='flex items-center' href={route('dashboard')}>
                    <ApplicationLogo className="h-[140px] w-[220px] fill-current text-gray-500" />
                </a>

                <div className='flex flex-col gap-4 items-start justify-start'>
                    <Link className='flex gap-2 hover:bg-black/10 rounded-md w-full p-2' 
                    href={route('dashboard')}>
                        <House />
                        <p>Página principal</p>
                    </Link>

                    <SidebarDropdown 
                        icon={StickyNote} 
                        label="Módulo de viajeros" 
                        items={viajerosItems} 
                    />

                    <SidebarDropdown 
                        icon={Archive} 
                        label="Módulo de expedientes"
                        items={expedientesItems}    
                    />
                </div>

                <div className='flex flex-col justify-center'>
                    <a className='flex mb-4' href=''>
                        <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    strokeWidth={1.5}
                                    stroke="currentColor"
                                    className="size-6 mr-2"
                                >
                                    <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"
                                    />
                                </svg>
                        <p className='mb-4'>{auth.user?.nombre} {auth.user?.apPaterno}</p>
                    </a>
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
            <div className="col-span-3 flex flex-col h-screen">
                <div className="flex items-center mb-6 mt-6">
                    <button
                        onClick={() => router.visit(backURL)} 
                        className="rounded-xl font-bold justify-center text-sm text-black border border-[#A7A7A7] p-2 flex items-center bg-[#FFFFFF] hover:bg-azulIMTA hover:text-white hover:scale-110 transition transform duration-300 ease-in-out cursor-pointer"
                    >
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

                <div className="rounded-3xl bg-[#FFFFFF] mb-10 p-8 flex-1 overflow-y-auto">
                    <h2 className='text-xl font-semibold'>{insideHeader}</h2>
                    {children}
                </div>
            </div>

            {/* Sidebar Derecho */}
            <div className="mt-12 col-span-1 grid grid-rows-[28%_5%_55%_20%] items-center">

                <div className="justify-center text-center">
                    <div className="m-5 rounded-xl bg-[#FFFFFF] flex flex-col items-center p-5 relative">
                        {/* Menú arriba derecha */}
                        <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        strokeWidth={1.5}
                        stroke="currentColor"
                        className="w-6 h-6 absolute top-3 right-3 cursor-pointer"
                        >
                        <path
                            strokeLinecap="round"
                            strokeLinejoin="round"
                            d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z"
                        />
                        </svg>

                        {/* Ícono usuario centrado */}
                        <div className="rounded-full bg-azulIMTA p-4 mb-4">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                strokeWidth={1.5}
                                stroke="currentColor"
                                className="w-12 h-12 text-white"
                            >
                                <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"
                                />
                            </svg>
                        </div>

                        {/* Nombre */}
                        <span className="text-center font-bold">
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
