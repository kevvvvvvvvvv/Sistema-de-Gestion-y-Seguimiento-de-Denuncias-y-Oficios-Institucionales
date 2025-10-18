import { useState } from "react";
import { Head, router } from "@inertiajs/react";
import MainLayout from "@/Layouts/MainLayout";
import InputText from "@/Components/InputText";
import RegisterButton from "@/Components/RegisterButton";
import SelectInput from "@/Components/SelectInput";
import InputDate from "@/Components/InputDate";
import { set } from "date-fns";

export default function Create({ auth, errors, servidor, departamento, particular, institucion ,user, remitente, destinatario }) {

  const [values, setValues] = useState({
    numOficio: "",
    fechaCreacion: "",
    fechaLlegada: "",
    asunto: "",
    resultado: "",
    instruccion: "",
    fechaEntrega: "",
    idDepartamentoDestinatario: null,
    idServidorDestinatario: null,
    idParticularDestinatario: null,
    idInstitucionDestinatario: null,

    idDepartamentoRemitente: null,
    idParticularRemitente: null,
    idServidorRemitente: null,
    idInstitucionRemitente: null,
    idUsuario: null,
    pdfFile: null,
  });

  const [valuesType, setValuesType] = useState({
    remitenteTipo:"",
    destinatarioTipo: ""
  }); 


  function handleChange(e) {
    setValues({
      ...values,
      [e.target.id]: e.target.value,
    });
  }


  function handleFileChange(e) {
      setValues({ ...values, pdfFile: e.target.files[0] });
  }


  function store() {
    const formData = new FormData();


    Object.keys(values).forEach(key => {
      if(values[key] !== null) formData.append(key, values[key]);
    });

    router.post("/viajeros", formData, {
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

  const optionsInstitucionD = institucion.map((instid) => ({
    value: instid.idInstitucion,
    label: instid.nombreCompleto,
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

  const optionsInstitucionR = institucion.map((instir) => ({
    value: instir.idInstitucion,
    label: instir.nombreCompleto,
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

      </div>

      <div className="grid grid-cols-2 gap-4 flex-1">
      <SelectInput
        label="Tipo de remitente"
        id="remitenteTipo"
        options={[
          { value: "servidor", label: "Servidor" },
          { value: "particular", label: "Particular" },
          { value: "departamento", label: "Departamento" },
          { value: "institucion", label: "Institucion" },
        ]}
        value={valuesType.remitenteTipo}
        onChange={(val) => {
          setValuesType({ ...valuesType, remitenteTipo: val });

          setValues({
            ...values,
            idServidorRemitente: "",
            idDepartamentoRemitente: "",
            idParticularRemitente: "",
            idInstitucionRemitente: "",
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

      {valuesType.remitenteTipo === "institucion" && (
        <SelectInput
          label="Remitente"
          id="idInstitucionRemitente"
          options={optionsInstitucionR}
          value={values.idInstitucionRemitente}
          onChange={(val) => setValues({ ...values, idInstitucionRemitente: val })}
          error={errors.idInstitucionRemitente}
        />
      )}

      <SelectInput
        label="Tipo de destinatario"
        id="destinatarioTipo"
        options={[
          { value: "servidor", label: "Servidor" },
          { value: "particular", label: "Particular" },
          { value: "departamento", label: "Departamento" },
          { value: "institucion", label: "Institucion" },
        ]}
        value={valuesType.destinatarioTipo}
        onChange={
          (val) => {setValuesType({ ...valuesType, destinatarioTipo: val });
          setValues({
            ...values,
            idServidorDestinatario: "",
            idDepartamentoDestinatario: "",
            idParticularDestinatario: "",
            idInstitucionDestinatario: "",
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

      {valuesType.destinatarioTipo === "institucion" && (
        <SelectInput
          label="Destinatario"
          id="idInstitucionDestinatario"
          options={optionsInstitucionD}
          value={values.idInstitucionDestinatario}
          onChange={(val) => setValues({ ...values, idInstitucionDestinatario: val })}
          error={errors.idInstitucionDestinatario}
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

      <RegisterButton onClick={store}>Registrar</RegisterButton>
    </MainLayout>
  );
}