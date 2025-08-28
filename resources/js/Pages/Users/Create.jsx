import MainLayout from "@/Layouts/MainLayout";
import { Head } from "@inertiajs/react";

export default function Create(auth) {
    return(
        <MainLayout auth={auth} topHeader="Registro de usuarios" insideHeader={""}>
            <Head title="Registro de Usuarios" />
            
        </MainLayout>
    )
}