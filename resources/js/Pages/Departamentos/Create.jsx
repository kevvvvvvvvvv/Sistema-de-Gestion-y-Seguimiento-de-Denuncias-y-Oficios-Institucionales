import { useState } from "react";
import { Head, router } from "@inertiajs/react";
import MainLayout from "@/Layouts/MainLayout";
import InputText from "@/Components/InputText";
import RegisterButton from "@/Components/RegisterButton";
import SelectInput from "@/Components/SelectInput";

export default function Create({ auth, errors, instituciones  }) {
  // Estado de los inputs
  const [values, setValues] = useState({
    nombre: "",
    idInstitucion:""
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
    router.post("/departamentos", values);
  }

  const options = instituciones.map((inst) => ({
    value: inst.idInstitucion,
    label: inst.nombreCompleto, 
  }));

  return (
    <MainLayout auth={auth} topHeader="Registro de departamentos" insideHeader={""} backURL="/departamentos">
      <Head title="Registro de Departamentos" />

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

      <RegisterButton onClick={store}>Registrar</RegisterButton>
    </MainLayout>
  );
}