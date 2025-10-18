import { useState, useEffect } from "react";
import { Head, router } from "@inertiajs/react";
import MainLayout from "@/Layouts/MainLayout";
import InputText from "@/Components/InputText";
import RegisterButton from "@/Components/RegisterButton";
import SelectInput from "@/Components/SelectInput";
import InputDate from "@/Components/InputDate";
import { set } from "date-fns";





export default function Create({ auth, errors, servidor, departamento, particular, user, viajero, oficio, remitente, destinatario }) {
  // Estado de los inputs
  const [values, setValues] = useState({
    numOficio: oficio.numOficio,
    fechaCreacion: oficio.fechaCreacion ? new Date(oficio.fechaCreacion + 'T00:00:00') : '',
    fechaLlegada: oficio.fechaLlegada ? new Date(oficio.fechaLlegada + 'T00:00:00') : '',
    asunto: viajero.asunto,
    resultado: viajero.resultado || "",
    instruccion: viajero.instruccion || "",
    fechaEntrega: viajero.fechaEntrega || "" ? new Date(viajero.fechaEntrega + 'T00:00:00') : '',
    
    idDepartamentoDestinatario: null,
    idServidorDestinatario: null,
    idParticularDestinatario: null,

    idDepartamentoRemitente: null,
    idParticularRemitente: null,
    idServidorRemitente: null,

    idUsuario: viajero.idUsuario || null,
    pdfFile: null,
  });

  const [valuesType, setValuesType] = useState({
    remitenteTipo:"",
    destinatarioTipo: ""
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

  function update() {
    const formData = new FormData();

    // Agregamos todos los campos, aunque sean vacíos
    Object.keys(values).forEach(key => {
      formData.append(key, values[key] ?? '');
    });

    // Necesario para que Laravel interprete como PUT
    formData.append('_method', 'PUT');

    router.post(`/viajeros/${oficio.numOficio}`, formData, {
      headers: { 'Content-Type': 'multipart/form-data' }
    });
  }



  const optionsDepartamentoD = departamento.map((depd) => ({
    value: depd.idDepartamento,
    label: depd.nombre,
  }));

  const optionsServidorD = servidor.map((srvd) => ({
    value: srvd.idServidor,
    label: srvd.nombreCompleto,
  }));

  const optionsParticularD = particular.map((instd) => ({
    value: instd.idParticular,
    label: instd.nombreCompleto,
  }));

  const optionsServidorR = servidor.map((srvr) => ({
    value: srvr.idServidor,
    label: srvr.nombreCompleto,
  }));

  const optionsDepartamentoR = departamento.map((depr) => ({
    value: depr.idDepartamento,
    label: depr.nombre,
  }));

  const optionsParticularR = particular.map((instr) => ({
    value: instr.idParticular,
    label: instr.nombreCompleto,
  }));

  const optionsUser = user.map((user) => ({
    value: user.idUsuario,
    label: user.nombre + ' ' + user.apPaterno + ' ' + user.apMaterno,
  }));

  function capitalize(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
  }


  useEffect(() => {
    if (remitente && remitente.type && remitente.id) {
      setValuesType((prev) => ({
        ...prev,
        remitenteTipo: remitente.type,
      }));

      setValues((prev) => ({
        ...prev,
        [`id${capitalize(remitente.type)}Remitente`]: remitente.id,
      }));
    }

    if (destinatario && destinatario.type && destinatario.id) {
      setValuesType((prev) => ({
        ...prev,
        destinatarioTipo: destinatario.type,
      }));

      setValues((prev) => ({
        ...prev,
        [`id${capitalize(destinatario.type)}Destinatario`]: destinatario.id,
      }));
    }
  }, [remitente, destinatario]);




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

      </div>

      <div className="grid grid-cols-2 gap-4 flex-1">
      <SelectInput
        label="Tipo de remitente"
        id="remitenteTipo"
        options={[
          { value: "servidor", label: "Servidor" },
          { value: "particular", label: "Particular" },
          { value: "departamento", label: "Departamento" },
        ]}
        value={valuesType.remitenteTipo}
        onChange={(val) => {
          setValuesType({ ...valuesType, remitenteTipo: val });

          setValues({
            ...values,
            idServidorRemitente: "",
            idDepartamentoRemitente: "",
            idParticularRemitente: ""
          });
        }}
        error={errors.remitente}
      />

      {valuesType.remitenteTipo === "servidor" && (
       <SelectInput
          label="Remitente"
          id="idServidorRemitente"
          options={optionsServidorR}
          value={values.idServidorRemitente}
          onChange={(val) => setValues({ ...values, idServidorRemitente: val })}
          error={errors.idServidorRemitente}
        />
      )}

      {valuesType.remitenteTipo === "departamento" && (
        <SelectInput
          label="Remitente"
          id="idDepartamentoRemitente"
          options={optionsDepartamentoR}
          value={values.idDepartamentoRemitente}
          onChange={(val) => setValues({ ...values, idDepartamentoRemitente: val })}
          error={errors.idDepartamentoRemitente}
        />
      )}

      {valuesType.remitenteTipo === "particular" && (
        <SelectInput
          label="Remitente"
          id="idParticularRemitente"
          options={optionsParticularR}
          value={values.idParticularRemitente}
          onChange={(val) => setValues({ ...values, idParticularRemitente: val })}
          error={errors.idParticularRemitente}
        />
      )}

      <SelectInput
        label="Tipo de destinatario"
        id="destinatarioTipo"
        options={[
          { value: "servidor", label: "Servidor" },
          { value: "particular", label: "Particular" },
          { value: "departamento", label: "Departamento" },
        ]}
        value={valuesType.destinatarioTipo}
        onChange={
          (val) => {setValuesType({ ...valuesType, destinatarioTipo: val });
          setValues({
            ...values,
            idServidorDestinatario: "",
            idDepartamentoDestinatario: "",
            idParticularDestinatario: ""
          });
        }}
        error={errors.destinatario}
      />

      {valuesType.destinatarioTipo === "servidor" && (
       <SelectInput
          label="Destinatario"
          id="idServidorDestinatario"
          options={optionsServidorD}
          value={values.idServidorDestinatario}
          onChange={(val) => setValues({ ...values, idServidorDestinatario: val })}
          error={errors.idServidorDestinatario}
        />
      )}

      {valuesType.destinatarioTipo === "departamento" && (
        <SelectInput
          label="Destinatario"
          id="idDepartamentoDestinatario"
          options={optionsDepartamentoD}
          value={values.idDepartamentoDestinatario}
          onChange={(val) => setValues({ ...values, idDepartamentoDestinatario: val })}
          error={errors.idDepartamentoDestinatario}
        />
      )}

      {valuesType.destinatarioTipo === "particular" && (
        <SelectInput
          label="Destinatario"
          id="idParticularDestinatario"
          options={optionsParticularD}
          value={values.idParticularDestinatario}
          onChange={(val) => setValues({ ...values, idParticularDestinatario: val })}
          error={errors.idParticularDestinatario}
        />
      )}

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

      <RegisterButton onClick={update}>Registrar</RegisterButton>
    </MainLayout>
  );
}