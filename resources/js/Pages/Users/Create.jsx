import { useState } from "react";
import { Head, router } from "@inertiajs/react";
import MainLayout from "@/Layouts/MainLayout";
import InputText from "@/Components/InputText";
import RegisterButton from "@/Components/RegisterButton";
import SelectInput from "@/Components/SelectInput";

export default function Create({ auth, errors, roles }) {
  // Estado de los inputs
  const [values, setValues] = useState({
    nombre: "",
    apPaterno: "",
    apMaterno: "",
    email: "",
    password: "",
    role: null,
  });

  const options = roles.map((r)=>({
    value: r.id,
    label: r.name,
  }));

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
    <MainLayout auth={auth} topHeader="Registro de usuarios" insideHeader={""} backURL="/users">
      <Head title="Registro de Usuarios" />

      <div className="grid grid-cols-2 gap-4 flex-1">
        <InputText
          placeholder="Aa"
          description="Nombre(s)"
          id="nombre"
          value={values.nombre}
          onChange={handleChange}
          error={errors.nombre}
        />
        <InputText
          placeholder="Aa"
          description="Apellido paterno"
          id="apPaterno"
          value={values.apPaterno}
          onChange={handleChange}
          error={errors.apPaterno}
        />
        <InputText
          placeholder="Aa"
          description="Apellido materno"
          id="apMaterno"
          value={values.apMaterno}
          onChange={handleChange}
          error={errors.apMaterno}
        />
        <InputText
          placeholder="Aa"
          description="Correo electrónico"
          id="email"
          value={values.email}
          onChange={handleChange}
          error={errors.email}
        />
        <InputText
          placeholder="Aa"
          description="Contraseña"
          id="password"
          type="password"
          value={values.password}
          onChange={handleChange}
          error={errors.password}
        />

        <SelectInput
          label="Rol del usuario"
          id="role" 
          options={options}
          value={values.role} 
          onChange={(val) => setValues({ ...values, role: val })}
          error={errors.role} 
        >

        </SelectInput>
      </div>

      <RegisterButton onClick={store}>Registrar</RegisterButton>
    </MainLayout>
  );
}
