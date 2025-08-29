import { useState } from "react";
import MainLayout from "@/Layouts/MainLayout";
import TextInput from "@/Components/TextInput";

export default function Test({ auth }) {
  const [name, setName] = useState("");

  return (
    <div className="p-4 space-y-4">
      <h1 className="text-xl font-bold">Editar perfil</h1>

      <TextInput
        id="name"
        name="name"
        placeholder="Escribe tu nombre"
        value={name}
        onChange={(e) => setName(e.target.value)}
      />

      <p className="text-gray-600">Valor actual: {name}</p>
    </div>
  );
}

Test.layout = (page) => <MainLayout auth={page.props.auth}>{page}</MainLayout>;
