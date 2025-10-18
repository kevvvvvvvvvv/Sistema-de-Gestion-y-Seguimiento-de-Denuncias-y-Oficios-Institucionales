import { useState } from "react";
import { Head, router } from '@inertiajs/react';
import MainLayout from '@/Layouts/MainLayout';
import InputText from '@/Components/InputText';
import RegisterButton from '@/Components/RegisterButton';
import SelectInput from "@/Components/SelectInput";

export default function Edit({auth, user, errors, roles }) {
    const [values, setValues] = useState({
        nombre: user.nombre,
        apPaterno: user.apPaterno,
        apMaterno: user.apMaterno,
        email: user.email,
        password: "",
        role: user.roles?.[0]?.id || null,
    });

    function handleChange(e) {
        setValues({
        ...values,
        [e.target.id]: e.target.value,
        });
    }  

    const options = roles.map((r) => ({
        value: r.id,
        label: r.name,
    }));
    
    function update() {
        router.put(`/users/${user.idUsuario}`, values);
    }

    return (
        <MainLayout auth={auth} topHeader="Actualizar usuario" insideHeader={""} backURL="/users">
            <Head title="Editar Usuario" />

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
                    description="Contraseña (dejar en blanco si no desea cambiar la conraseña)"
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
            ></SelectInput>
            </div>

            <RegisterButton onClick={update}>Actualizar</RegisterButton>
        </MainLayout>

        
    )
}