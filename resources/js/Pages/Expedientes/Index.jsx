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

export default function Index({ expedientes, auth }) {
    const permissions = auth.permissions;
    const tableData = expedientes.map(i => ({
        numero: i.numero,
        ofRequerimiento: i.ofRequerimiento,
        fechaRequerimiento: i.fechaRequerimiento,
        ofRespuesta: i.ofRespuesta,
        fechaRespuesta: i.fechaRespuesta,
        fechaRecepcion: i.fechaRecepcion,
        nombreCompleto: i.servidor.nombreCompleto
    }));

    useEffect(() => {
        const handleClick = (e) => {
            const editBtn = e.target.closest(".edit-btn");
            const deleteBtn = e.target.closest(".delete-btn");

            if (editBtn) {
              const id = editBtn.dataset.id;
              router.visit(route("expedientes.edit", id));
            }

            if (deleteBtn) {
                const id = deleteBtn.dataset.id;
                confirm(
                    {
                      title: "¿Eliminar expediente?",
                      text: "No podrás deshacer esta acción",
                      confirmText: "Sí, eliminar",
                    },
                    () => {
                      router.delete(route("expedientes.destroy", id), {
                        onSuccess: () => {
                          router.reload({ only: ["expedientes"] });
                        },
                      });
                    }
                  );
                  
              }
              
        };

        document.addEventListener("click", handleClick);
        return () => document.removeEventListener("click", handleClick);
    }, []);
    
  return (
    <>
      <MainLayout auth={auth} topHeader="Consulta de expedientes" insideHeader={""}>
        <Head title="Expedientes" />

        {auth.permissions.includes('crear expedientes') && (
        <AddButton href={route('expedientes.create')} />
        )}

        <DataTable 
            data={tableData} 
            className="display"
            options={{ 
                scrollX:true,
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
                    { title: "Número de expediente", data: "numero" },
                    { title: "Servidor", data: "nombreCompleto" },
                    { title: "Oficio de requerimiento", data: "ofRequerimiento" },
                    { title: "Fecha de requerimiento", data: "fechaRequerimiento" },
                    { title: "Oficio de respuesta", data: "ofRespuesta" },
                    { title: "Fecha de respuesta", data: "fechaRespuesta" },
                    { title: "Fecha de recepción", data: "fechaRecepcion" },
                    {
                      title: "Operaciones",
                      orderable: false,
                      render: (data, type, row) => {
                          let buttons = `<div class="flex gap-2 justify-center">`;
          
                          if (permissions.includes("editar expedientes")) {
                              buttons += `
                                  <button class="edit-btn" data-id="${row.numero}">
                                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                           viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                           stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                          <path d="M12 20h9"></path>
                                          <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4 12.5-12.5z"></path>
                                      </svg>
                                  </button>
                              `;
                          }
          
                          if (permissions.includes("eliminar expedientes")) {
                              buttons += `
                                  <button class="delete-btn" data-id="${row.numero}">
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
          
                          buttons += `</div>`;
                          return buttons;
                      }
                  }
                ]
            }}
        >
            <thead>
                <tr>
                <th>Número de expediente</th>
                <th>Servidor</th>
                <th>Oficio de requerimiento</th>
                <th>Fecha de requerimiento</th>
                <th>Oficio de respuesta</th>
                <th>Fecha de respuesta</th>
                <th>Fecha de recepción</th>
                <th>Operaciones</th>
                </tr>
            </thead>
        </DataTable>

      </MainLayout>
    </>
  );
}