import { useState } from "react";
import { Head, router } from "@inertiajs/react";
import MainLayout from "@/Layouts/MainLayout";
import InputText from "@/Components/InputText";
import RegisterButton from "@/Components/RegisterButton";
import SelectInput from "@/Components/SelectInput";
import InputTextArea from "@/Components/InputTextArea";
import InputDate from "@/Components/InputDate";

export default function Edit({ auth, errors, baja, expedientes, servidores }) {

    const [values, setValues] = useState({
        idServidor: baja.idServidor,
        numero: baja.numero,
        fechaBaja: baja.fechaBaja,
        descripcion: baja.descripcion,
    });
    
    function handleChange(e) {
        setValues({
        ...values,
        [e.target.id]: e.target.value,
        });
    }  
        
    function update() {
        router.put(`/bajas/${baja.idBaja}`, values);
    }

    // Función que pone el número de expediente de acuerdo al id del servidor
    function handleNumExpediente(idServidor) {
        const expediente = expedientes.find(e => e.idServidor === idServidor);

        setValues({
            ...values,
            idServidor: idServidor,
            numero: expediente ? expediente.numero : "Sin expediente registrado"
        });
    }

    const options = servidores.map((inst) => ({
        value: inst.idServidor,
        label: inst.nombreCompleto
    }));
        
    return (
        <MainLayout auth={auth} topHeader="Actualizar baja" insideHeader={""} backURL="/bajas">
            <Head title="Editar Baja" />

            <div className="grid grid-cols-2 gap-4 flex-1">
                <SelectInput
                    label="Servidor"
                    id="idServidor"
                    options={options}
                    value={values.idServidor}
                    onChange={handleNumExpediente}
                    error={errors.idServidor}
                />

                <InputText
                    placeholder="Aa"
                    description="Número de expediente"
                    id="numero"
                    value={values.numero}
                    onChange={handleChange}
                    error={errors.numero}
                    readOnly={true}
                />

                <InputDate 
                    description="Fecha de la baja"
                    id="fechaBaja"
                    value={values.fechaBaja}
                    onChange={(date) => setValues({ ...values, fechaBaja: date })}
                    error={errors.fechaBaja}
                />

                <InputTextArea 
                    placeholder="Aa"
                    description="Descripción de la baja"
                    id="descripcion"
                    value={values.descripcion}
                    onChange={handleChange}
                    error={errors.descripcion}
                />
            </div>

            <RegisterButton onClick={update}>Actualizar</RegisterButton>
        </MainLayout>
    )
}