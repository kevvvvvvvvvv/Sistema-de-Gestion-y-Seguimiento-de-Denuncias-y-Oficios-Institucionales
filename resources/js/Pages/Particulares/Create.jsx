import { useState } from "react";
import { Head, router } from "@inertiajs/react";
import MainLayout from "@/Layouts/MainLayout";
import InputText from "@/Components/InputText";
import RegisterButton from "@/Components/RegisterButton";
import SelectInput from "@/Components/SelectInput";
import InputDate from "@/Components/InputDate";
import InputTextArea from "@/Components/InputTextArea";

export default function Create({ auth, errors }) {
    // Estado de los inputs
    const [values, setValues] = useState({
        nombreCompleto: "",
        genero: "",
        grado: "",
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
        router.post("/particulares", values);
    }

    return (
        <MainLayout auth={auth} topHeader="Registro de particulares" insideHeader={""} backURL="/particulares">
        <Head title="Registro de Particulares" />

        <div className="grid grid-cols-2 gap-4 flex-1">
            <InputText
                placeholder="Aa"
                description="Nombre completo del particular"
                id="nombreCompleto"
                value={values.nombreCompleto}
                onChange={handleChange}
                error={errors.nombreCompleto}
            />

            <SelectInput
                label="Género"
                id="genero"
                options={[
                    { value: "Femenino", label: "Femenino" },
                    { value: "Masculino", label: "Masculino" },
                    { value: "Otro", label: "Otro" }
                ]}
                value={values.genero}
                onChange={(val) => setValues({ ...values, genero: val })}
                error={errors.genero}
            />

            <InputText
                placeholder="Aa"
                description="Grado"
                id="grado"
                value={values.grado}
                onChange={handleChange}
                error={errors.grado}
            />

        </div>

        <RegisterButton onClick={store}>Registrar</RegisterButton>
        </MainLayout>
    );
}