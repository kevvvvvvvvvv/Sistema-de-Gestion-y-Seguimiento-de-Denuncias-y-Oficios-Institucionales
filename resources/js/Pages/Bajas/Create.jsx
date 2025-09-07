import { useState } from "react";
import { Head, router } from "@inertiajs/react";
import MainLayout from "@/Layouts/MainLayout";
import InputText from "@/Components/InputText";
import RegisterButton from "@/Components/RegisterButton";
import SelectInput from "@/Components/SelectInput";
import InputDate from "@/Components/InputDate";
import InputTextArea from "@/Components/InputTextArea";

export default function Create({ auth, errors, expedientes, servidores  }) {
    // Estado de los inputs
    const [values, setValues] = useState({
        idServidor: "",
        numero: "",
        fechaBaja: "",
        descripcion: "",
    });

    // Actualiza el estado al escribir
    function handleChange(e) {
        setValues({
        ...values,
        [e.target.id]: e.target.value,
        });
    }

    // Función que envía los datos al backend
    function store() {
        router.post("/bajas", values);
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
        <MainLayout auth={auth} topHeader="Registro de bajas de servidores" insideHeader={""} backURL="/bajas">
            <Head title="Registro de Bajas de Servidores" />

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

            <RegisterButton onClick={store}>Registrar</RegisterButton>
        </MainLayout>
    );
}