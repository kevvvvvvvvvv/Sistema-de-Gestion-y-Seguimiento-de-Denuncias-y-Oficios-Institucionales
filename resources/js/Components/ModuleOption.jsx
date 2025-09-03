import { Link, router } from '@inertiajs/react';


export default function ModuleOption({

}){
    return(
        <div className = "bg-blancoIMTA border boder-[#C9C9C9] h-40 rounded-xl m-5 w-1/3 hover:shadow-lg hover:scale-105 transition transform duration-300 ease-in-out cursor-pointer ">
            <div className="flex h-full p-3">
                <div className='w-1/3 flex justify-center items-center'>
                    <div className='rounded-full bg-azulIMTA p-3'>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" className="size-9 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                    </div>
                </div>
                <div className='w-2/3 flex items-center'>h</div>
            </div>
        </div>
    );
}