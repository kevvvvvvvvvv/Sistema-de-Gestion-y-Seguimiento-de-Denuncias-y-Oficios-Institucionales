import { useState } from "react";
import { Head, router } from "@inertiajs/react";
import MainLayout from "@/Layouts/MainLayout";
import InputText from "@/Components/InputText";
import RegisterButton from "@/Components/RegisterButton";
import SelectInput from "@/Components/SelectInput";
import InputTextArea from "@/Components/InputTextArea";

export default function Edit({ auth, errors, control, expedientes }) {

    const [values, setValues] = useState({
        consecutivo: control.consecutivo,
        acProrroga: control.acProrroga,
        acAuxilio: control.acAuxilio,
        acRegularizacion: control.acRegularizacion,
        acRequerimiento: control.acRequerimiento,
        acOficioReque: control.acOficioReque,
        acConclusion: control.acConclusion,
        comentarios: control.comentarios,
        numero: control.numero,
    });
    
    function handleChange(e) {
        setValues({
        ...values,
        [e.target.id]: e.target.value,
        });
    }  
        
    function update() {
        router.put(`/controles/${control.consecutivo}`, values);
    }

    const options = expedientes.map((inst) => ({
        value: inst.numero,
        label: inst.numero
    }));
        
    return (
        <MainLayout auth={auth} topHeader="Actualizar control" insideHeader={""} backURL="/controles">
            <Head title="Editar Control" />

            <div className="grid grid-cols-2 gap-4 flex-1">
                <SelectInput
                    label="Número de oficio"
                    id="numero"
                    options={options}
                    value={values.numero}
                    onChange={(val) => setValues({ ...values, numero: val })}
                    error={errors.numero}
                />
        
                <SelectInput
                    label="¿Cuenta con Acuerdo de Prórroga?"
                    id="acProrroga"
                    options={[
                        { value: "Si", label: "Si" },
                        { value: "No", label: "No" }
                    ]}
                    value={values.acProrroga}
                    onChange={(val) => setValues({ ...values, acProrroga: val })}
                    error={errors.acProrroga}
                />
        
                <SelectInput
                    label="¿Cuenta con Acuerdo de Auxilio Personal OR?"
                    id="acAuxilio"
                    options={[
                        { value: "Si", label: "Si" },
                        { value: "No", label: "No" }
                    ]}
                    value={values.acAuxilio}
                    onChange={(val) => setValues({ ...values, acAuxilio: val })}
                    error={errors.acAuxilio}
                />
        
                <SelectInput
                    label="¿Cuenta con Acuerdo de Regularización?"
                    id="acRegularizacion"
                    options={[
                        { value: "Si", label: "Si" },
                        { value: "No", label: "No" }
                    ]}
                    value={values.acRegularizacion}
                    onChange={(val) => setValues({ ...values, acRegularizacion: val })}
                    error={errors.acRegularizacion}
                />
        
                <SelectInput
                    label="¿Cuenta con Acuerdo de Requerimiento de Declaración Patrimonial?"
                    id="acRequerimiento"
                    options={[
                        { value: "Si", label: "Si" },
                        { value: "No", label: "No" }
                    ]}
                    value={values.acRequerimiento}
                    onChange={(val) => setValues({ ...values, acRequerimiento: val })}
                    error={errors.acRequerimiento}
                />
        
                <SelectInput
                    label="¿Cuenta con Oficio de Requerimiento de Declaración Patrimonial?"
                    id="acOficioReque"
                    options={[
                        { value: "Si", label: "Si" },
                        { value: "No", label: "No" }
                    ]}
                    value={values.acOficioReque}
                    onChange={(val) => setValues({ ...values, acOficioReque: val })}
                    error={errors.acOficioReque}
                />
        
                <SelectInput
                    label="¿Cuenta con Acuerdo de Conclusión y Archivo?"
                    id="acConclusion"
                    options={[
                        { value: "Si", label: "Si" },
                        { value: "No", label: "No" }
                    ]}
                    value={values.acConclusion}
                    onChange={(val) => setValues({ ...values, acConclusion: val })}
                    error={errors.acConclusion}
                />
        
                <InputTextArea 
                    placeholder="Aa"
                    description="Comentarios"
                    id="comentarios"
                    value={values.comentarios}
                    onChange={handleChange}
                    error={errors.comentarios}
                />
            </div>

            <RegisterButton onClick={update}>Actualizar</RegisterButton>
        </MainLayout>
    )
}