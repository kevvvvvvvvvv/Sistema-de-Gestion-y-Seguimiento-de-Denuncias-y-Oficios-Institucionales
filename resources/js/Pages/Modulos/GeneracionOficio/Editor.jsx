import MainLayout from "@/Layouts/MainLayout";
import { Head, useForm  } from "@inertiajs/react";
import React from "react";
import { useCreateBlockNote } from "@blocknote/react";
import "@blocknote/mantine/style.css";
import "@blocknote/core/fonts/inter.css";
import { BlockNoteView } from "@blocknote/mantine";
import * as locales from "@blocknote/core/locales";
import RegisterButton from "@/Components/RegisterButton";
import InputText from "@/Components/InputText";

const spanishDictionary = locales.es || locales.en;

export default function Editor({auth}) {
    const permissions = auth.permissions;

    const editor = useCreateBlockNote({
        dictionary: spanishDictionary,
    });

    const { data, setData, post, errors } = useForm({
        titulo: "",
        contenido: "",
    });

    const handleSubmit = async (e) => {
        e.preventDefault();
        post(route("modulo.oficios.guardar"));
    };

    return(
        <MainLayout auth={auth} topHeader="Creación de oficio para expediente" insideHeader={""} backURL="/modulo/generacion-de-oficios/ver-oficios">
            <Head title="Creación de oficio para expediente" />

            <div className="bg-blancoIMTA border p-6 rounded-lg">
                <h4 className="text-lg font-bold">Instrucciones de uso</h4>
                <p>Utiliza las siguientes claves para insertar datos dinámicos que se reemplazarán automáticamente:</p>
                <ul>
                    <li><code>{'{servidor}'}</code>: Nombre completo del servidor público.</li>
                    <li><code>{'{grado}'}</code>: Grado del servidor público.</li>
                    <li><code>{'{institucion}'}</code>: Nombre de la institución.</li>
                    <li><code>{'{departamento}'}</code>: Nombre del departamento.</li>
                    <li><code>{'{expediente}'}</code>: Número de expediente.</li>
                </ul>
            </div>

            <form onSubmit={handleSubmit} className="mt-6">
                <div className="flex justify-end mt-6">
                    <RegisterButton type="submit" className="px-6">
                        Guardar oficio
                    </RegisterButton>
                </div>
                
                <InputText
                    placeholder="Aa"
                    description="Título del oficio"
                    id="titulo"
                    value={data.titulo}
                    onChange={(e) => setData("titulo", e.target.value)}
                />
                {errors.titulo && <p className="text-red-500 text-sm mt-1">{errors.titulo}</p>}

                <p className="text-sm mt-10">Contenido del oficio</p>
                <BlockNoteView className="mt-4"
                    editor={editor}
                    onChange={() => {
                        const updatedContent = JSON.stringify(editor.topLevelBlocks);
                        setData("contenido", updatedContent);
                    }} 
                />
                {errors.contenido && <p className="text-red-500 text-sm mt-1">{errors.contenido}</p>}
            </form>
        </MainLayout>
    );
}