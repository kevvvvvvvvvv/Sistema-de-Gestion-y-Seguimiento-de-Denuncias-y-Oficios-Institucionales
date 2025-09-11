import { useState } from "react";
import { Head, router } from "@inertiajs/react";
import MainLayout from "@/Layouts/MainLayout";
import InputText from "@/Components/InputText";
import RegisterButton from "@/Components/RegisterButton";
import SelectInput from "@/Components/SelectInput";
import InputDate from "@/Components/InputDate";
import InputTextArea from "@/Components/InputTextArea";

export default function Edit({ auth, errors, servidor, instituciones, departamentos  }) {
    // Estado de los inputs
    const [values, setValues] = useState({
        nombreCompleto: servidor.nombreCompleto,
        genero: servidor.genero,
        grado: servidor.grado,
        fechaIngreso: servidor.fechaIngreso,
        puesto: servidor.puesto,
        nivel: servidor.nivel,
        correo: servidor.correo,
        telefono: servidor.telefono,
        estatus: servidor.estatus,
        idInstitucion:servidor.idInstitucion,
        idDepartamento:servidor.idDepartamento,
        descripcion: servidor.descripcion
    });

    // Actualiza el estado al escribir
    function handleChange(e) {
        setValues({
        ...values,
        [e.target.id]: e.target.value,
        });
    }

    // Función que envía los datos al backend
    function update() {
        router.put(`/servidores/${servidor.idServidor}`, values);
    }

    const optionsInst = instituciones.map((inst) => ({
        value: inst.idInstitucion,
        label: inst.nombreCompleto 
    }));

    const optionsDept = departamentos
    .filter((dept) => dept.idInstitucion === values.idInstitucion)
    .map((dept) => ({
        value: dept.idDepartamento,
        label: dept.nombre,
    }));

    return (
        <MainLayout auth={auth} topHeader="Actualizar servidor" insideHeader={""} backURL="/servidores">
        <Head title="Actualizar información de Servidor/ra" />

        <div className="grid grid-cols-2 gap-4 flex-1">
            <InputText
                placeholder="Aa"
                description="Nombre completo del servidor"
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

            <InputDate 
                description="Fecha de ingreso"
                id="fechaIngreso"
                value={values.fechaIngreso}
                onChange={(date) => setValues({ ...values, fechaIngreso: date })}
                error={errors.fechaIngreso}
            />

            <InputText
                placeholder="Aa"
                description="Puesto"
                id="puesto"
                value={values.puesto}
                onChange={handleChange}
                error={errors.puesto}
            />

            <InputText
                placeholder="Aa"
                description="Nivel"
                id="nivel"
                value={values.nivel}
                onChange={handleChange}
                error={errors.nivel}
            />

            <InputText
                placeholder="correo@example.com"
                description="Correo electrónico"
                id="correo"
                value={values.correo}
                onChange={handleChange}
                error={errors.correo}
            />

            <InputText
                placeholder="123"
                description="Teléfono"
                id="telefono"
                value={values.telefono}
                onChange={handleChange}
                error={errors.telefono}
            />

            <SelectInput
                label="Estatus"
                id="estatus"
                options={[
                    { value: "Alta", label: "Alta" },
                    { value: "Baja", label: "Baja" }
                ]}
                value={values.estatus}
                onChange={(val) => setValues({ ...values, estatus: val })}
                error={errors.estatus}
            />

            <SelectInput
                label="Institución"
                id="idInstitucion"
                options={optionsInst}
                value={values.idInstitucion}
                onChange={(val) => setValues({ ...values, idInstitucion: val })}
                error={errors.idInstitucion}
            />

            <SelectInput
                label="Departamento"
                id="idDepartamento"
                options={optionsDept}
                value={values.idDepartamento}
                onChange={(val) => setValues({ ...values, idDepartamento: val })}
                error={errors.idDepartamento}
            />

            <InputTextArea 
                placeholder="Aa"
                description="Descripción de la alta del servidor"
                id="descripcion"
                value={values.descripcion}
                onChange={handleChange}
                error={errors.descripcion}
            />
        </div>

        <RegisterButton onClick={update}>Registrar</RegisterButton>
        </MainLayout>
    );
}