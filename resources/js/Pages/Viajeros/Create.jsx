import { useState } from "react";
import { Head, router } from "@inertiajs/react";
import MainLayout from "@/Layouts/MainLayout";
import InputText from "@/Components/InputText";
import RegisterButton from "@/Components/RegisterButton";
import SelectInput from "@/Components/SelectInput";
import InputDate from "@/Components/InputDate";

export default function Create({ auth, errors, oficio, usuario}) {
  // Estado de los inputs
  const [values, setValues] = useState({
    fechaCreacion: "",
    asunto:""
  });

  // Actualiza el estado al escribir
  /*function handleChange(e) {
    setValues({
      ...values,
      [e.target.id]: e.target.value,
    });
  }*/

  // Función que envía los datos al backend
  function store() {
    router.post("/viajeros", values);
  }

  /*const optionsOficio = oficio.map((inst) => ({
  }));

  const optionsUsuario = usuario.map((inst) => ({
}));*/

  return (
    <MainLayout auth={auth} topHeader="Registro de viajeros" insideHeader={""} backURL="/viajeros">
      <Head title="Registro de Expedientes" />

      <div className="grid grid-cols-2 gap-4 flex-1">

        <InputDate 
            description="Fecha de expedición"
            id="fechaCreacion"
            value={values.fechaCreacion }
            onChange={(date) => setValues({ ...values, fechaCreacion: date })}
            error={errors.fechaCreacion}
        />

        <InputText
            placeholder="Aa"
            description="Asunto"
            id="asunto"
            value={values.asunto}
            onChange={handleChange}
            error={errors.asunto}
        />

        {/*<SelectInput
            label="Servidor público"
            id="idServidor"
            options={options}
            value={values.idServidor}
            onChange={(val) => setValues({ ...values, idServidor: val })}
            error={errors.idServidor}
        />*/}
      </div>

      <RegisterButton onClick={store}>Registrar</RegisterButton>
    </MainLayout>
  );
}