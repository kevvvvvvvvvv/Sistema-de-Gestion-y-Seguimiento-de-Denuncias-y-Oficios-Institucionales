import { useState } from "react";
import { Head, router } from "@inertiajs/react";
import MainLayout from "@/Layouts/MainLayout";
import InputText from "@/Components/InputText";
import RegisterButton from "@/Components/RegisterButton";
import SelectInput from "@/Components/SelectInput";
import InputDate from "@/Components/InputDate";

export default function Edit({ auth, errors, expediente, servidores }) {

    const [values, setValues] = useState({
        numero: expediente.numero,
        ofRequerimiento: expediente.ofRequerimiento,
        fechaRequerimiento: expediente.fechaRequerimiento ? new Date(expediente.fechaRequerimiento + 'T00:00:00') : '',
        ofRespuesta: expediente.ofRespuesta,
        fechaRespuesta: expediente.fechaRespuesta ? new Date(expediente.fechaRespuesta + 'T00:00:00') : '',
        fechaRecepcion: expediente.fechaRecepcion ? new Date(expediente.fechaRecepcion + 'T00:00:00') : '',
        idServidor: expediente.idServidor
    });
    
    function handleChange(e) {
        setValues({
        ...values,
        [e.target.id]: e.target.value,
        });
    }  
        
    function update() {
        router.put(`/expedientes/${expediente.numero}`, values);
    }

    const options = servidores.map((inst) => ({
        value: inst.idServidor,
        label: inst.nombreCompleto
    }));
        
    return (
        <MainLayout auth={auth} topHeader="Actualizar expediente" insideHeader={""} backURL="/expedientes">
            <Head title="Editar Expediente" />

            <div className="grid grid-cols-2 gap-4 flex-1">
                <InputText
                    placeholder="Aa"
                    description="Número de expediente"
                    id="numero"
                    value={values.numero}
                    onChange={handleChange}
                    error={errors.numero}
                />
        
                <SelectInput
                    label="Servidor público"
                    id="idServidor"
                    options={options}
                    value={values.idServidor}
                    onChange={(val) => setValues({ ...values, idServidor: val })}
                    error={errors.idServidor}
                />
        
                <InputText
                    placeholder="Aa"
                    description="Oficio de requerimiento"
                    id="ofRequerimiento"
                    value={values.ofRequerimiento}
                    onChange={handleChange}
                    error={errors.ofRequerimiento}
                />
        
                <InputDate 
                    description="Fecha de oficio de requerimiento"
                    id="fechaRequerimiento"
                    value={values.fechaRequerimiento}
                    onChange={(date) => setValues({ ...values, fechaRequerimiento: date })}
                    error={errors.fechaRequerimiento}
                />
        
                <InputText
                    placeholder="Aa"
                    description="Oficio de respuesta"
                    id="ofRespuesta"
                    value={values.ofRespuesta}
                    onChange={handleChange}
                    error={errors.ofRespuesta}
                />
        
                <InputDate 
                    description="Fecha de oficio de respuesta"
                    id="fechaRespuesta"
                    value={values.fechaRespuesta}
                    onChange={(date) => setValues({ ...values, fechaRespuesta: date })}
                    error={errors.fechaRespuesta}
                />
        
                <InputDate 
                    description="Fecha de recepción"
                    id="fechaRecepcion"
                    value={values.fechaRecepcion}
                    onChange={(date) => setValues({ ...values, fechaRecepcion: date })}
                    error={errors.fechaRecepcion}
                />
            </div>

            <RegisterButton onClick={update}>Actualizar</RegisterButton>
        </MainLayout>
    )
}