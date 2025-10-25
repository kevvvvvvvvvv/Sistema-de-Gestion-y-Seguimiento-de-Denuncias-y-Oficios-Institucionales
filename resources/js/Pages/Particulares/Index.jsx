import AddButton from '@/Components/AddButton';
import MainLayout from '@/Layouts/MainLayout';
import { Head, Link, usePage } from '@inertiajs/react';
import {Trash2, SquarePen, icons} from 'lucide-react';
import { useSweetDelete } from '@/Hooks/useSweetDelete';
import { router } from '@inertiajs/react';
import { useState, useEffect } from 'react';
import Swal from 'sweetalert2';

import DataTable from 'datatables.net-react';
import DT from 'datatables.net-dt'; 
import 'datatables.net-dt/css/dataTables.dataTables.css';

import Buttons from 'datatables.net-buttons-dt'; 
import 'datatables.net-buttons/js/buttons.html5.mjs';
import 'datatables.net-buttons-dt/css/buttons.dataTables.css';

import JSZip from 'jszip';
import SelectInput from '@/Components/SelectInput';

window.JSZip = JSZip;

DataTable.use(DT);
DataTable.use(Buttons);

const {confirm} = useSweetDelete();

export default function Index({ particulares, auth }) {
    const permissions = auth.permissions;
    const { flash } = usePage().props;
    
    const tableData = particulares.map(i => ({
        idParticular: i.idParticular,
        nombreCompleto: i.nombreCompleto,
        genero: i.genero,
        grado: i.grado,
        estado: i.deleted_at ? "Inactivos" : "Activos"
    }));

    const [selectedEstado, setSelectedEstado] = useState("Activos");
    const estadoOptions = [
        { value: "Activos", label: "Activos" },
        { value: "Inactivos", label: "Inactivos" }
    ];
    const filteredTableData = tableData.filter(d => 
        selectedEstado ? d.estado === selectedEstado : true
    );

    useEffect(() => {
        if (flash.success) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: flash.success, 
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
            });
        }
        if (flash.error) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: flash.error, 
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
            });
        }
    }, [flash]);

    useEffect(() => {
        const handleClick = (e) => {
            const editBtn = e.target.closest(".edit-btn");
            const deleteBtn = e.target.closest(".delete-btn");
            const restoreBtn = e.target.closest(".restore-btn");
            const forceDelBtn = e.target.closest(".force-del-btn");

            if (editBtn) {
            const id = editBtn.dataset.id;
                router.visit(route("particulares.edit", id));
            }

            if (deleteBtn) {
                const id = deleteBtn.dataset.id;
                confirm(
                    {
                    title: "¿Inactivar?",
                    text: "Podrás restaurar más adelante",
                    confirmText: "Sí, inactivar",
                    },
                    () => {
                        router.delete(route("particulares.destroy", id), {
                            onSuccess: () => {
                                router.reload({ only: ["particulares"] });

                                Swal.fire({
                                    toast: true,             
                                    position: 'top-end',     
                                    icon: 'success',         
                                    title: 'Inactivación realizada correctamente',
                                    showConfirmButton: false, 
                                    timer: 4000,             
                                    timerProgressBar: true,  
                                });
                            },
                        });
                    }
                );
            };
            
            if(restoreBtn) {
                const id = restoreBtn.dataset.id;
                confirm(
                    {
                        title: "¿Restaurar?",
                        text: "El registro será activado nuevamente",
                        confirmText: "Sí, restaurar",
                    },
                    () => {
                        router.delete(route("particulares.restore", id), {
                            onSuccess: () => {
                                router.reload({ only: ["particulares"] });

                                Swal.fire({
                                    toast: true,             
                                    position: 'top-end',     
                                    icon: 'success',         
                                    title: 'Restauración realizada correctamente',
                                    showConfirmButton: false, 
                                    timer: 4000,             
                                    timerProgressBar: true,  
                                });
                            },
                        });
                    }
                );
            };

            if(forceDelBtn) {
                const id = forceDelBtn.dataset.id;
                confirm(
                    {
                        title: "¿Eliminar?",
                        text: "No podrás deshacer esta acción",
                        confirmText: "Sí, eliminar",
                    },
                    () => {
                        router.delete(route("particulares.forceDelete", id), {
                            preserveScroll: true, 
                        });
                    }
                );
            };    
        };

        document.addEventListener("click", handleClick);
        return () => document.removeEventListener("click", handleClick);
    }, []);
    
  return (
    <>
      <MainLayout auth={auth} topHeader="Consulta de particulares" insideHeader={""}>
        <Head title="Particulares" />

        {auth.permissions.includes('crear servidores') && (
        <AddButton href={route('particulares.create')} />
        )}

        <div className="mb-8 w-1/3">
            <SelectInput
                label="Ver particulares"
                options={estadoOptions}
                value={selectedEstado}
                onChange={setSelectedEstado}
            />
        </div>

        <DataTable 
            data={filteredTableData} 
            className="display"
            options={{ 
                dom: '<"dt-toolbar flex justify-between items-center mb-4"fB>rt<"dt-footer flex justify-between items-center mt-4 text-xs"lip>', 
                buttons: [
                {
                    extend: 'excelHtml5',
                    text: 'Exportar a Excel',
                    titleAttr: 'Excel',
                    className: 'bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg shadow !important'
                }
                ],
                language: {
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ registros por página",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    infoEmpty: "No hay registros disponibles",
                    infoFiltered: "(filtrado de _MAX_ registros en total)",
                    zeroRecords: "No se encontraron resultados",
                },
                columns: [
                    { title: "ID", data: "idParticular" },
                    { title: "Nombre completo", data: "nombreCompleto" },
                    { title: "Género", data: "genero"},
                    { title: "Grado", data: "grado"},
                    {
                      title: "Operaciones",
                      orderable: false,
                      render: (data, type, row) => {
                        let buttons = `<div class="flex gap-6 justify-center">`;
                
                        if (permissions.includes("editar servidores")) {
                            if (row.estado === "Activos"){
                                buttons += `
                                    <button class="edit-btn" data-id="${row.idParticular}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 20h9"></path>
                                            <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4 12.5-12.5z"></path>
                                        </svg>
                                    </button>
                                `;
                            }
                        }
            
                        if (permissions.includes("eliminar servidores")) {
                            if (row.estado === "Activos") {
                                buttons += `
                                    <button class="delete-btn" data-id="${row.idParticular}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" 
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="red" 
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                            class="lucide lucide-circle-x-icon lucide-circle-x"><circle cx="12" 
                                            cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/>
                                        </svg>
                                    </button>
                                `;
                            }else{
                                buttons += `
                                    <button class="restore-btn" data-id="${row.idParticular}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" 
                                            stroke-linecap="round" stroke-linejoin="round" class="lucide 
                                            lucide-iteration-cw-icon lucide-iteration-cw">
                                            <path d="M4 10a8 8 0 1 1 8 8H4"/><path d="m8 22-4-4 4-4"/>
                                        </svg>
                                    </button>
                                    <button class="force-del-btn" data-id="${row.idParticular}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="red"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                                            <path d="M10 11v6"></path>
                                            <path d="M14 11v6"></path>
                                        </svg>
                                    </button>
                                `;
                            }
                        }
                        buttons += `</div>`;
                        return buttons;
                    }
                  }
                ]
            }}
        >
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre completo</th>
                <th>Género</th>
                <th>Grado</th>
                <th>Operaciones</th>
            </tr>
            </thead>

        </DataTable>

      </MainLayout>
    </>
  );
}