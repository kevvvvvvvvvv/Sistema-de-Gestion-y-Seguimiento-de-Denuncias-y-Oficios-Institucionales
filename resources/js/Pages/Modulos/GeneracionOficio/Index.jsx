import AddButton from '@/Components/AddButton';
import MainLayout from '@/Layouts/MainLayout';
import { Head, Link } from '@inertiajs/react';
import {Trash2, SquarePen, icons} from 'lucide-react';
import { useSweetDelete } from '@/Hooks/useSweetDelete';
import { router } from '@inertiajs/react';
import { useState, useEffect } from 'react';

import DataTable from 'datatables.net-react';
import DT from 'datatables.net-dt'; 
import 'datatables.net-dt/css/dataTables.dataTables.css';

import Buttons from 'datatables.net-buttons-dt'; 
import 'datatables.net-buttons/js/buttons.html5.mjs';
import 'datatables.net-buttons-dt/css/buttons.dataTables.css';

import JSZip from 'jszip';

window.JSZip = JSZip;

DataTable.use(DT);
DataTable.use(Buttons);

const {confirm} = useSweetDelete();

export default function Index({ plantillas, auth }) {

    const permissions = auth.permissions;
    const tableData = plantillas.map(i => ({
        idPlantilla: i.idPlantilla,
        titulo: i.titulo
    }));
    
    useEffect(() => {
        const editButtons = document.querySelectorAll('.edit-btn');
        const deleteButtons = document.querySelectorAll('.delete-btn');

        editButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute('data-id');
                router.visit(route('modulo.oficios.editar', id));
            });
        });

        deleteButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute('data-id');
                confirm(
                    {
                        title: "¿Eliminar plantilla de oficio?",
                        text: "No podrás deshacer esta acción",
                        confirmText: "Sí, eliminar",
                    },
                    () => {
                        router.delete(route("modulo.oficios.eliminar", id));
                    }
                );
            });
        });

        return () => {
            editButtons.forEach(btn => btn.replaceWith(btn.cloneNode(true)));
            deleteButtons.forEach(btn => btn.replaceWith(btn.cloneNode(true)));
        };
    }, [plantillas]);

  return (
    <>
      <MainLayout auth={auth} topHeader="Plantillas de los oficios" insideHeader={""}>
        <Head title="Plantillas de oficios" />

        <AddButton href={route('modulo.oficios.crear')} />

        <DataTable 
            data={tableData} 
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
                    { title: "ID", data: "idPlantilla" },
                    { title: "Título del oficio", data: "titulo" },
                    { title: "Operaciones",
                        orderable: false,
                        render: (data, type, row) => `
                            <div class="flex gap-8 justify-center">
                                <button class="delete-btn" data-id="${row.idPlantilla}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download-icon lucide-download"><path d="M12 15V3"/><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="m7 10 5 5 5-5"/></svg>
                                </button>
                                <button class="edit-btn" data-id="${row.idPlantilla}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-diagonal-icon lucide-move-diagonal"><path d="M11 19H5v-6"/><path d="M13 5h6v6"/><path d="M19 5 5 19"/></svg>
                                </button>
                                <button class="delete-btn" data-id="${row.idPlantilla}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path><path d="M10 11v6"></path><path d="M14 11v6"></path></svg>
                                </button>
                            </div>
                        `
                    }
                ]
            }}
        >
            
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título del oficio</th>
                </tr>
            </thead>
        </DataTable>

      </MainLayout>
    </>
  );
}