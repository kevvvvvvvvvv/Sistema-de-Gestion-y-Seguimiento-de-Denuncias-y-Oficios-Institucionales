import { useState } from "react";
import { Head, router } from "@inertiajs/react";
import MainLayout from "@/Layouts/MainLayout";
import InputText from "@/Components/InputText";
import RegisterButton from "@/Components/RegisterButton";
import SelectInput from "@/Components/SelectInput";

export default function Edit({ auth, errors, role, permissions }) {

    const [values, setValues] = useState({
        name: role.name,
        permissions: role.permissions.map(p => p.id), 
    });
    
    
    function handleChange(e) {
        setValues({
        ...values,
        [e.target.id]: e.target.value,
        });
    }  
        
    function update() {
        router.put(`/roles/${role.id}`, values);
    }
      

    /*const options = instituciones.map((inst) => ({
        value: inst.idInstitucion,
        label: inst.nombreCompleto
    }));*/

    
        
    return (
        <MainLayout auth={auth} topHeader="Actualizar roles" insideHeader={""} backURL="/roles">
            <Head title="Editar Roles" />

            <div className="grid grid-cols-2 gap-4 flex-1">
                <InputText
                    placeholder="Aa"
                    description="Nombre del rol"
                    id="name"
                    value={values.name}
                    onChange={handleChange}
                    error={errors.name}
                />
        
                <table className="w-full border">
                    <thead>
                        <tr>
                        <th className="border p-2">Permiso</th>
                        <th className="border p-2">Asignado</th>
                        </tr>
                    </thead>
                    <tbody>
                        {permissions.map((perm) => (
                        <tr key={perm.id}>
                            <td className="border p-2">{perm.name}</td>
                            <td className="border p-2 text-center">
                            <input
                                type="checkbox"
                                checked={values.permissions.includes(perm.id)}
                                onChange={(e) => {
                                if (e.target.checked) {
                                    setValues({
                                    ...values,
                                    permissions: [...values.permissions, perm.id],
                                    });
                                } else {
                                    setValues({
                                    ...values,
                                    permissions: values.permissions.filter((id) => id !== perm.id),
                                    });
                                }
                                }}
                            />
                            </td>
                        </tr>
                        ))}
                    </tbody>
                </table>

            </div>

            <RegisterButton onClick={update}>Actualizar</RegisterButton>
        </MainLayout>
    )
}