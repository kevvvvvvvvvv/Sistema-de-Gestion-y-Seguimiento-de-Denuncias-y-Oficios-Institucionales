import { useState } from "react";
import { Head, router } from "@inertiajs/react";
import MainLayout from "@/Layouts/MainLayout";
import InputText from "@/Components/InputText";
import RegisterButton from "@/Components/RegisterButton";

export default function Create({ auth, errors, permissions }) {

    const [values, setValues] = useState({
        name: "",
        permissions: [], 
    });

    function handleChange(e) {
        setValues({
            ...values,
            [e.target.id]: e.target.value,
        });
    }

    function store() {
        router.post("/roles", values);
    }

    return (
        <MainLayout auth={auth} topHeader="Crear rol" insideHeader={""} backURL="/roles">
            <Head title="Crear Rol" />

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
                            <th className="border p-2">Asignar</th>
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

            <RegisterButton onClick={store}>Crear</RegisterButton>
        </MainLayout>
    );
}
