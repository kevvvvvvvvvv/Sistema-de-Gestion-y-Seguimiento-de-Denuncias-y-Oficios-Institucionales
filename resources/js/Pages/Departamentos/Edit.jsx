import { useState } from "react";
import { Head, router } from "@inertiajs/react";
import MainLayout from "@/Layouts/MainLayout";
import InputText from "@/Components/InputText";
import RegisterButton from "@/Components/RegisterButton";
import SelectInput from "@/Components/SelectInput";

export default function Edit({ auth, errors, departamento, instituciones }) {

    const [values, setValues] = useState({
        nombre: departamento.nombre,
        idInstitucion: departamento.idInstitucion
    });
    
    function handleChange(e) {
        setValues({
        ...values,
        [e.target.id]: e.target.value,
        });
    }  
        
    function update() {
        router.put(`/departamentos/${departamento.idDepartamento}`, values);
    }

    const options = instituciones.map((inst) => ({
        value: inst.idInstitucion,
        label: inst.nombreCompleto
    }));
        
    return (
        <MainLayout auth={auth} topHeader="Actualizar departamento" insideHeader={""} backURL="/departamentos">
            <Head title="Editar Departamento" />

            <div className="grid grid-cols-2 gap-4 flex-1">
                <InputText
                    placeholder="Aa"
                    description="Nombre del departamento"
                    id="nombre"
                    value={values.nombre}
                    onChange={handleChange}
                    error={errors.nombre}
                />
        
                <SelectInput
                    label="Institución"
                    id="idInstitucion"
                    options={options}
                    value={values.idInstitucion}
                    onChange={(val) => setValues({ ...values, idInstitucion: val })}
                    error={errors.idInstitucion}
                />
            </div>

            <RegisterButton onClick={update}>Actualizar</RegisterButton>
        </MainLayout>
    )
}