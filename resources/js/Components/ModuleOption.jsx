import { Link, router } from '@inertiajs/react';


export default function ModuleOption({
    managementLink,
    children,
    href
}){
    return(
        <a href={href} className = "bg-blancoIMTA border boder-[#C9C9C9] h-40 rounded-xl m-5 w-1/3 hover:shadow-lg hover:scale-105 transition transform duration-300 ease-in-out cursor-pointer ">
            <div className="flex h-full p-3">
                <div className='w-1/3 flex justify-center items-center'>
                    <div className='rounded-full bg-azulIMTA p-3'>
                        {children}
                    </div>
                </div>
                <div className='w-2/3 flex items-center'>
                    {managementLink}
                </div>
            </div>
        </a>
    );
}