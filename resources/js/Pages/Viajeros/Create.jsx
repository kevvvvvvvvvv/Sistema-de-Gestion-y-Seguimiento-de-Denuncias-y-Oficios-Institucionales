import { useState } from "react";
import { Head, router } from "@inertiajs/react";
import MainLayout from "@/Layouts/MainLayout";
import InputText from "@/Components/InputText";
import RegisterButton from "@/Components/RegisterButton";
import SelectInput from "@/Components/SelectInput";
import InputDate from "@/Components/InputDate";

export default function Create({ auth, errors, servidor, departamento, institucion, user }) {
  // Estado de los inputs
  const [values, setValues] = useState({
    numOficio: "",
    fechaCreacion: "",
    fechaLlegada: "",
    asunto: "",
    resultado: "",
    instruccion: "",
    fechaEntrega: "",
    idDepartamentoD: null,
    idServidorD: null,
    idServidor: null,
    idUsuario: null,
    pdfFile: null,
  });

  // Actualiza el estado al escribir
  function handleChange(e) {
    setValues({
      ...values,
      [e.target.id]: e.target.value,
    });
  }

    // Maneja archivo PDF
  function handleFileChange(e) {
      setValues({ ...values, pdfFile: e.target.files[0] });
  }

  // Función que envía los datos al backend
  function store() {
    const formData = new FormData();

    // Agregamos todos los campos al formData
    Object.keys(values).forEach(key => {
      if(values[key] !== null) formData.append(key, values[key]);
    });

    router.post("/viajeros", formData, {
      headers: { 'Content-Type': 'multipart/form-data' }
    });
  }

  // Opciones de selects
  const optionsInstitucion = institucion.map((inst) => ({
    value: inst.idInstitucion,
    label: inst.nombreCompleto,
  }));

  const optionsDepartamento = departamento.map((dep) => ({
    value: dep.idDepartamento,
    label: dep.nombre,
  }));

  const optionsServidor = servidor.map((srv) => ({
    value: srv.idServidor,
    label: srv.nombreCompleto,
  }));

  const optionsServidorD = servidor.map((srvd) => ({
    value: srvd.idServidor,
    label: srvd.nombreCompleto,
  }));

  const optionsUser = user.map((user) => ({
    value: user.idUsuario,
    label: user.nombre + ' ' + user.apPaterno + ' ' + user.apMaterno,
  }));

  return (
    <MainLayout auth={auth} topHeader="Registro de viajeros" insideHeader={""} backURL="/viajeros">
      <Head title="Registro de Viajeros" />

      <div className="grid grid-cols-2 gap-4 flex-1">

        <InputText
          placeholder="Aa"
          description="Número de oficio"
          id="numOficio"
          value={values.numOficio}
          onChange={handleChange}
          error={errors.numOficio}
        />

        <InputDate
          description="Fecha de expedición"
          id="fechaCreacion"
          value={values.fechaCreacion}
          onChange={(date) => setValues({ ...values, fechaCreacion: date })}
          error={errors.fechaCreacion}
        />

        <InputDate
          description="Fecha de llegada"
          id="fechaLlegada"
          value={values.fechaLlegada}
          onChange={(date) => setValues({ ...values, fechaLlegada: date })}
          error={errors.fechaLlegada}
        />

        <SelectInput
          label="Remitente"
          id="idServidor"
          options={optionsServidor}
          value={values.idServidor}
          onChange={(val) => setValues({ ...values, idServidor: val })}
          error={errors.idServidor}
        />

        <SelectInput
          label="Destinataio"
          id="idDepartamentoD"
          options={optionsDepartamento}
          value={values.idDepartamentoD}
          onChange={(val) => setValues({ ...values, idDepartamentoD: val })}
          error={errors.idDepartamentoD}
        />

        <SelectInput
          label="Destinatario"
          id="idServidorD"
          options={optionsServidorD}
          value={values.idServidorD}
          onChange={(val) => setValues({ ...values, idServidorD: val })}
          error={errors.idServidorD}
        />

      </div>

      <InputText
        placeholder="Aa"
        description="Asunto"
        id="asunto"
        value={values.asunto}
        onChange={handleChange}
        error={errors.asunto}
        className="w-full"
      />

      <InputText
        placeholder="Aa"
        description="Instrucción"
        id="instruccion"
        value={values.instruccion}
        onChange={handleChange}
        error={errors.instruccion}
        className="w-full"
      />

      <InputText
        placeholder="Aa"
        description="Resultado"
        id="resultado"
        value={values.resultado}
        onChange={handleChange}
        error={errors.resultado}
        className="w-full"
      />

      <div className="grid grid-cols-2 gap-4 flex-1">
        <InputDate
          description="Fecha de entrega"
          id="fechaEntrega"
          value={values.fechaEntrega}
          onChange={(date) => setValues({ ...values, fechaEntrega: date })}
          error={errors.fechaEntrega}
        />

        <SelectInput
          label="Encargado"
          id="idEncargado"
          options={optionsUser}
          value={values.idUsuario}
          onChange={(val) => setValues({ ...values, idUsuario: val })}
          error={errors.idUsuario}
        />
      </div>

      <div className="my-4">
        <label className="block mb-2 font-semibold">Subir PDF</label>
        <input
          type="file"
          accept="application/pdf"
          onChange={handleFileChange}
          className="border p-2 rounded w-full"
        />
        {errors.pdfFile && <span className="text-red-500">{errors.pdfFile}</span>}
      </div>

      <RegisterButton onClick={store}>Registrar</RegisterButton>
    </MainLayout>
  );
}