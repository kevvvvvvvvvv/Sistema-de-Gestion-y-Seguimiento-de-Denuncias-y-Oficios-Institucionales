import MainLayout from "@/Layouts/MainLayout";
import { Head } from "@inertiajs/react";
import React from "react";
import { useCreateBlockNote } from "@blocknote/react";
import "@blocknote/mantine/style.css";
import "@blocknote/core/fonts/inter.css";
import { BlockNoteView } from "@blocknote/mantine";
import RegisterButton from "@/Components/RegisterButton";

export default function Editor({auth}) {
    const permissions = auth.permissions;

    const editor = useCreateBlockNote();

    return(
        <MainLayout auth={auth} topHeader="Creación de oficio para expediente" insideHeader={""}>
            <Head title="Creación de oficio para expediente" />

            <div className="bg-blancoIMTA border p-6 rounded-lg">
                <h4 className="text-lg font-bold">Instrucciones de uso</h4>
                <p>Utiliza las siguientes claves para insertar datos dinámicos que se reemplazarán automáticamente:</p>
                <ul>
                    <li><code>{'{servidor}'}</code>: Nombre completo del servidor público.</li>
                    <li><code>{'{institucion}'}</code>: Nombre de la institución.</li>
                    <li><code>{'{departamento}'}</code>: Nombre del departamento.</li>
                    <li><code>{'{expediente}'}</code>: Número de expediente.</li>
                </ul>
            </div>

            <div className="flex justify-end mt-6">
                <RegisterButton>Guardar oficio</RegisterButton>
            </div>
                
            <h3 className="text-xl font-bold mt-10">Editor de texto</h3>
            <BlockNoteView className="mt-6" editor={editor} />
        </MainLayout>
    );
}