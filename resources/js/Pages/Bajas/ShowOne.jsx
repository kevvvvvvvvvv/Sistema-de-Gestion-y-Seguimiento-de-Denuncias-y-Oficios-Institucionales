import { useState } from "react";
import { Head, router } from "@inertiajs/react";
import MainLayout from "@/Layouts/MainLayout";
import InputText from "@/Components/InputText";
import RegisterButton from "@/Components/RegisterButton";
import SelectInput from "@/Components/SelectInput";
import InputTextArea from "@/Components/InputTextArea";
import InputDate from "@/Components/InputDate";
import TextInput from "@/Components/TextInput";

export default function ShowOne({ auth, baja }) {
    const permissions = auth.permissions;
    return (
        <MainLayout auth={auth} topHeader="Consultar una baja" insideHeader={""} backURL="/bajas">
            <Head title="Consultar Baja" />

            <div className="grid grid-cols-2 gap-4 flex-1">
                <InputText
                    description="Servidor/a público/a"
                    value={baja.servidor?.nombreCompleto}
                    readOnly={true}
                />
                <InputText
                    description="Institución"
                    value={baja.servidor?.departamento?.institucion?.nombreCompleto}
                    readOnly={true}
                /> 
            </div>

            <div className="flex items-center gap-4 my-6">
                <p className="whitespace-nowrap">Puesto anterior</p>
                <hr className="w-full border-gray-300" />
            </div>
            <div className="grid grid-cols-2 gap-4 flex-1">
                <InputText
                    description="Adscripción"
                    value={baja.adscripcionAnt}
                    readOnly={true}
                />
                <InputText
                    description="Puesto"
                    value={baja.puestoAnt}
                    readOnly={true}
                />
                <InputText
                    description="Fecha de ingreso anterior"
                    value={baja.fechaIngresoAnt}
                    readOnly={true}
                />
                <InputText
                    description="Fecha de la baja"
                    value={baja.fechaBaja}
                    readOnly={true}
                />
                <InputText
                    description="Nivel"
                    value={baja.nivelAnt}
                    readOnly={true}
                />
                <InputTextArea
                    description="Descripción de la baja"
                    value={baja.descripcion}
                    readOnly={true}
                />
            </div>

            <div className="flex items-center gap-4 my-6">
                    <p className="whitespace-nowrap">Reingreso</p>
                    <hr className="w-full border-gray-300" />
            </div> 
            {baja.servidor.estatus === 'Alta' ? (
            
                    <div className="grid grid-cols-2 gap-4 flex-1">
                        <InputText
                            description="Adscripción"
                            value={baja.servidor?.departamento?.nombre}
                            readOnly={true}
                        />
                        <InputText
                            description="Puesto"
                            value={baja.servidor?.puesto}
                            readOnly={true}
                        />
                        <InputText
                            description="Fecha de la alta (reingreso)"
                            value={baja.servidor?.fechaIngreso}
                            readOnly={true}
                        />
                        <InputText
                            description="Nivel"
                            value={baja.servidor?.nivel}
                            readOnly={true}
                        />
                        <InputTextArea
                            description="Descripción de la alta (reingreso)"
                            value={baja.servidor?.descripcion}
                            readOnly={true}
                        />
                    </div>
                
            ) : (
                <>
                    <h5 className="text-center mt-20 text-grisIMTA font-semibold">
                        Este servidor no tiene un reingreso y sigue dado de baja
                    </h5>
                </>
            )}
        </MainLayout>
    )
}