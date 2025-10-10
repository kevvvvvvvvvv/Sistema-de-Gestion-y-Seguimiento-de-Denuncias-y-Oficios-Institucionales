import MainLayout from "@/Layouts/MainLayout";
import { Head } from "@inertiajs/react";
import React from "react";
import { useCreateBlockNote } from "@blocknote/react";
import "@blocknote/mantine/style.css";
import "@blocknote/core/fonts/inter.css";
import { BlockNoteView } from "@blocknote/mantine";
import RegisterButton from "@/Components/RegisterButton";
import InputText from "@/Components/InputText";

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
                <RegisterButton className="px-6">Guardar oficio</RegisterButton>
            </div>
            
            <InputText
                placeholder="Aa"
                description="Título del oficio"
                id="titulo"
            />

            <p className="text-sm mt-10">Contenido del oficio</p>
            <BlockNoteView className="mt-4" editor={editor} />
        </MainLayout>
    );
}