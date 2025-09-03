import Sidebar from '@/Components/Layout/SideBar';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import MainLayout from '@/Layouts/MainLayout';
import ModuleOption from '@/Components/ModuleOption';

export default function Dashboard({auth}) {
    return (
        <MainLayout
            auth={auth}
            topHeader="Dashboard"
            insideHeader={`Hola, ${auth.user?.nombre}`}
            backURL=""
        >
            <div className='flex items-stretch'>
            <ModuleOption>
                
                </ModuleOption>
                <ModuleOption>
                
                </ModuleOption>
                <ModuleOption>
                
                </ModuleOption>
            </div>

        </MainLayout>
    );
}
