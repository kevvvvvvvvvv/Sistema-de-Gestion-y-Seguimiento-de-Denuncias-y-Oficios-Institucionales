import MainLayout from "@/Layouts/MainLayout";
import { Head, useForm  } from "@inertiajs/react";
import React from "react";
import { useCreateBlockNote } from "@blocknote/react";
import "@blocknote/mantine/style.css";
import "@blocknote/core/fonts/inter.css";
import { BlockNoteView } from "@blocknote/mantine";
import RegisterButton from "@/Components/RegisterButton";
import InputText from "@/Components/InputText";

export default function EditorActualizar({ auth, plantilla }) {
    const editor = useCreateBlockNote({
        initialContent: plantilla?.contenido ? JSON.parse(plantilla.contenido) : undefined,
    });

    const { data, setData, put } = useForm({
        titulo: plantilla?.titulo || '',
        contenido: plantilla?.contenido || '',
    });

    const handleSubmit = async (e) => {
        e.preventDefault();
        put(route("modulo.oficios.actualizar", plantilla.idPlantilla));
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
                        Actualizar oficio
                    </RegisterButton>
                </div>
                
                <InputText
                    placeholder="Aa"
                    description="Título del oficio"
                    id="titulo"
                    value={data.titulo}
                    onChange={(e) => setData("titulo", e.target.value)}
                />

                <p className="text-sm mt-10">Contenido del oficio</p>
                <BlockNoteView className="mt-4" 
                    editor={editor} 
                    onChange={() => {
                        const updatedContent = JSON.stringify(editor.topLevelBlocks);
                        setData("contenido", updatedContent);
                    }}
                />
            </form>
        </MainLayout>
    );
}
