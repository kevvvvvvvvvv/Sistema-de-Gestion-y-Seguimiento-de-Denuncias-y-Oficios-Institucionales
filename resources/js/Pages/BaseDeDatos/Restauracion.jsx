import MainLayout from "@/Layouts/MainLayout";
import { Head, useForm } from "@inertiajs/react";
import { useState } from 'react';

export default function Respaldo({auth}) {
    const permissions = auth.permissions;

    const [fileName, setFileName] = useState('Ningún archivo seleccionado');
    const { data, setData, post, processing, errors } = useForm({
        sql_file: null,
    });

    function handleFileChange(e) {
        if (e.target.files.length > 0) {
            const file = e.target.files[0];
            setData('sql_file', file);
            setFileName(file.name); 
        }
    }

    function handleSubmit(e) {
        e.preventDefault();
        if (!data.sql_file) {
            alert('Por favor, selecciona un archivo .sql primero.');
            return;
        }
        
        post(route(''), {
            onSuccess: () => {
                setFileName('Ningún archivo seleccionado');
                e.target.reset(); 
            }
        });
    }

    return (
        <>
            <MainLayout auth={auth} topHeader="Restauración de la base de datos" insideHeader={""}>
                <Head title="Restauración de la base de datos" />
                <img className="h-64 place-self-center mt-10" src="/images/BD.png" alt="Imagen de base de datos" />

                <form onSubmit={handleSubmit} className="mt-8 w-full">
                    <div className="flex flex-col items-center gap-4">

                        <input
                            type="file"
                            accept=".sql"
                            onChange={handleFileChange}
                            id="sql_file_input"
                            className="hidden"
                        />

                        <label
                            htmlFor="sql_file_input"
                            className="bg-blue-600 text-white px-6 py-2 rounded-lg font-medium cursor-pointer hover:bg-blue-700 transition duration-200 w-64 text-center"
                        >
                            Subir archivo .sql
                        </label>

                        <span className="text-sm text-gray-500 h-5">
                            {fileName}
                        </span>

                        <button
                            type="submit"
                            disabled={processing || !data.sql_file}
                            className="bg-white text-black border border-black px-6 py-2 rounded-lg font-medium hover:bg-gray-100 transition duration-200 w-72 disabled:bg-gray-300 disabled:text-gray-500 disabled:border-gray-400"
                        >
                            {processing ? 'Restaurando...' : 'Restaurar'}
                        </button>
                        
                        {errors.sql_file && <span className="text-red-500 text-sm mt-2">{errors.sql_file}</span>}
                    </div>
                </form>
            </MainLayout>
        </> 
    );
}