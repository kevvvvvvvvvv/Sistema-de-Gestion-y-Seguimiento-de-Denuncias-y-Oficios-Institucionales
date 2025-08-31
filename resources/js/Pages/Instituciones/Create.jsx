import { useState } from "react";
import { Head, router } from "@inertiajs/react";
import MainLayout from "@/Layouts/MainLayout";
import InputText from "@/Components/InputText";
import RegisterButton from "@/Components/RegisterButton";

export default function Create({ auth, errors }) {
  // Estado de los inputs
  const [values, setValues] = useState({
    nombreCompleto: "",
    siglas: "",
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
    router.post("/instituciones", values);
  }

  return (
    <MainLayout auth={auth} topHeader="Registro de instituciones" insideHeader={""} backURL="/instituciones">
      <Head title="Registro de Instituciones" />

      <div className="grid grid-cols-2 gap-4 flex-1">
        <InputText
          placeholder="Aa"
          description="Nombre completo de la institución"
          id="nombreCompleto"
          value={values.nombreCompleto}
          onChange={handleChange}
          error={errors.nombreCompleto}
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

      <RegisterButton onClick={store}>Registrar</RegisterButton>
    </MainLayout>
  );
}
