import { useState } from "react";
import { Head, router } from "@inertiajs/react";
import MainLayout from "@/Layouts/MainLayout";
import InputText from "@/Components/InputText";
import RegisterButton from "@/Components/RegisterButton";

export default function Create({ auth, errors, institucion }) {
    const [values, setValues] = useState({
        nombreCompleto: institucion.nombreCompleto,
        siglas: institucion.siglas
    });
    
    function handleChange(e) {
        setValues({
        ...values,
        [e.target.id]: e.target.value,
        });
    }  
        
    function update() {
        router.put(`/instituciones/${institucion.idInstitucion}`, values);
    }
    
        return (
            <MainLayout auth={auth} topHeader="Actualizar institución" insideHeader={""} backURL="/instituciones">
                <Head title="Editar Institución" />
    
                <div className="grid grid-cols-2 gap-4 flex-1">
                    <InputText
                        placeholder="Aa"
                        description="Nombre completo de la institución"
                        id="nombreCompleto"
                        value={values.nombreCompleto}
                        onChange={handleChange}
                        error={errors.nombre}
                    />
                    <InputText
                        placeholder="Aa"
                        description="Siglas de la institución"
                        id="siglas"
                        value={values.siglas}
                        onChange={handleChange}
                        error={errors.siglas}
                    />
                </div>
    
                <RegisterButton onClick={update}>Actualizar</RegisterButton>
            </MainLayout>
        )
}