import MainLayout from '@/Layouts/MainLayout';
import {Head} from '@inertiajs/react';

export default function DenunciasInstitucion({ auth }) {

    return (
        <MainLayout auth={auth} topHeader="Reporte de progreso de oficios" insideHeader={""}>
            <Head title="Reporte de Progreso de Oficios " />
            
            

        </MainLayout>
    );
}


