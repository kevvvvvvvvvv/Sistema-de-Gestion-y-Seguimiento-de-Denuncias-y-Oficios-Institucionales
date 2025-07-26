import SideBar from '@/Components/Layout/SideBar';  
import { Link } from '@inertiajs/react';

export default function GuestLayout({ children }) {
    return (
        <div className="grid grid-cols-5">
            <div className='outline-2 outline-blue-500/100 ...'>
                <Link href="/">
                    <ApplicationLogo className="h-[140px] w-[220px] fill-current text-gray-500" />
                </Link>
            </div>

            <div className="col-span-3">
                {children}
            </div>

            <div>
                
            </div>
        </div>
    );
}

