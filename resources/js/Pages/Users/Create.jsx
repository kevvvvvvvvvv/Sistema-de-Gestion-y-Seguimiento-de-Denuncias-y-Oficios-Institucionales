import { useState } from "react";
import { Head, router } from "@inertiajs/react";
import MainLayout from "@/Layouts/MainLayout";
import InputText from "@/Components/InputText";
import RegisterButton from "@/Components/RegisterButton";

export default function Create({ auth }) {
  // Estado de los inputs
  const [values, setValues] = useState({
    nombre: "",
    apPaterno: "",
    apMaterno: "",
    email: "",
    password: "",
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
    router.post("/users", values);
  }

  return (
    <MainLayout auth={auth} topHeader="Registro de usuarios" insideHeader={""}>
      <Head title="Registro de Usuarios" />

      <div className="grid grid-cols-2 gap-4 flex-1">
        <InputText
          placeholder="Aa"
          description="Nombre(s)"
          id="nombre"
          value={values.nombre}
          onChange={handleChange}
        />
        <InputText
          placeholder="Aa"
          description="Apellido paterno"
          id="apPaterno"
          value={values.apPaterno}
          onChange={handleChange}
        />
        <InputText
          placeholder="Aa"
          description="Apellido materno"
          id="apMaterno"
          value={values.apMaterno}
          onChange={handleChange}
        />
        <InputText
          placeholder="Aa"
          description="Correo electrónico"
          id="email"
          value={values.email}
          onChange={handleChange}
        />
        <InputText
          placeholder="Aa"
          description="Contraseña"
          id="password"
          type="password"
          value={values.password}
          onChange={handleChange}
        />
      </div>

      <RegisterButton onClick={store}>Registrar</RegisterButton>
    </MainLayout>
  );
}
