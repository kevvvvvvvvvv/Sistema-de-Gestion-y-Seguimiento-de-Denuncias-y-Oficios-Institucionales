import PDFButton from "@/Components/PDFButton";
import MainLayout from "@/Layouts/MainLayout";
import { Head } from "@inertiajs/react";

export default function Respaldo({auth}) {
    const permissions = auth.permissions;
    
    return (
        <>
            <MainLayout auth={auth} topHeader="Respaldo de la base de datos" insideHeader={""}>
                <Head title="Respaldo de la base de datos" />
                <img className="h-64 place-self-center mt-10" src="/images/BD.png" alt="Imagen de base de datos" />
                <div className="flex justify-center">
                    <PDFButton>
                        Hacer respaldo
                    </PDFButton>
                </div>
            </MainLayout>
        </> 
    );
}