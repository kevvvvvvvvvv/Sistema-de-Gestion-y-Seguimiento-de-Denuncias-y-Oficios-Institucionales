import AddButton from '@/Components/AddButton';
import MainLayout from '@/Layouts/MainLayout';
import { Head, Link, usePage } from '@inertiajs/react';
import {Trash2, SquarePen, icons} from 'lucide-react';
import { useSweetDelete } from '@/Hooks/useSweetDelete';
import Swal from 'sweetalert2';
import { router } from '@inertiajs/react';
import { useState, useEffect } from 'react';

import { DOCXExporter, docxDefaultSchemaMappings } from "@blocknote/xl-docx-exporter";
import { BlockNoteSchema } from "@blocknote/core";
import { Packer } from "docx";
import { saveAs } from "file-saver";

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

/**
 * @param {Array} blocks 
 * @param {Object} replacements 
 * @returns {Array} 
 */

const replacePlaceholdersInBlocks = (blocks, replacements) => {
    const newBlocks = JSON.parse(JSON.stringify(blocks));

    for (const block of newBlocks) {
        if (block.content && Array.isArray(block.content)) {
            for (const inlineContent of block.content) {
                if (inlineContent.type === 'text' && inlineContent.text) {
                    let currentText = inlineContent.text;
                    for (const placeholder in replacements) {
                        currentText = currentText.replaceAll(placeholder, replacements[placeholder]);
                    }
                    inlineContent.text = currentText;
                }
            }
        }
    }

    return newBlocks;
};

export default function Index({ plantillas, auth, servidores, expedientes }) {

    const permissions = auth.permissions;

    const { flash } = usePage().props;

    const tableData = plantillas.map(i => ({
        idPlantilla: i.idPlantilla,
        titulo: i.titulo,
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

    const [selectedServidor, setSelectedServidor] = useState('');
    const [selectedExpediente, setSelectedExpediente] = useState('');

    const servidorOptions = servidores.map(s => ({
        value: s.idServidor,
        label: s.nombreCompleto
    }));

    const expedienteOptions = expedientes.map(e => ({
        value: e.numero,
        label: e.numero
    }));

    const handleServidorChange = (servidorId) => {
        setSelectedServidor(servidorId);
        const expedienteRelacionado = expedientes.find(e => e.idServidor === servidorId);
        setSelectedExpediente(expedienteRelacionado ? expedienteRelacionado.numero : '');
    };

    const handleExpedienteChange = (expedienteNumero) => {
        setSelectedExpediente(expedienteNumero);
        const expedienteSeleccionado = expedientes.find(e => e.numero === expedienteNumero);
        setSelectedServidor(expedienteSeleccionado ? expedienteSeleccionado.idServidor : '');
    };

    const handleDownload = async (plantillaId) => {
        if (!selectedServidor) {
            Swal.fire({
                icon: 'error',
                title: 'Acción requerida',
                text: 'Por favor, selecciona un servidor o expediente antes de descargar.',
                confirmButtonColor: "#9C8372",
            });
            return;
        }

        const plantilla = plantillas.find(p => p.idPlantilla === plantillaId);
        const servidor = servidores.find(s => s.idServidor === selectedServidor);
        const expediente = expedientes.find(e => e.idServidor === selectedServidor);

        if (!plantilla || !servidor) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se encontraron los datos de la plantilla o del servidor.',
                confirmButtonColor: "#9C8372",
            });
            return;
        }
        
        const replacements = {
            '{servidor}': servidor.nombreCompleto,
            '{grado}': servidor.grado || 'N/A',
            '{institucion}': servidor.institucion?.nombreCompleto || 'N/A', 
            '{departamento}': servidor.departamento?.nombre || 'N/A',
            '{expediente}': expediente?.numero || 'N/A',
        };

        const originalBlocks = JSON.parse(plantilla.contenido);
        const processedBlocks = replacePlaceholdersInBlocks(originalBlocks, replacements);

        try {
            const schema = BlockNoteSchema.create();
            const exporter = new DOCXExporter(schema, docxDefaultSchemaMappings);
            const docxDocument = await exporter.toDocxJsDocument(processedBlocks);
            const blob = await Packer.toBlob(docxDocument);
            const fileName = `${plantilla.titulo.replace(/\s+/g, '_') || 'documento'}.docx`;
            saveAs(blob, fileName);

        } catch (error) {
            console.error("Error al exportar a DOCX:", error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un problema al generar el documento.',
                confirmButtonColor: "#9C8372",
            });
        }
    };
    
    useEffect(() => {
        const handleClick = (e) => {
            const editBtn = e.target.closest(".edit-btn");
            const deleteBtn = e.target.closest(".delete-btn");
            const restoreBtn = e.target.closest(".restore-btn");
            const forceDelBtn = e.target.closest(".force-del-btn");
            const downloadBtn = e.target.closest(".download-btn");

            if (editBtn) {
                const id = editBtn.dataset.id; 
                router.visit(route('modulo.oficios.editar', id));
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
                        router.delete(route("modulo.oficios.destroy", id), {
                            onSuccess: () => {
                                router.reload({ only: ["plantillas"] });
                                Swal.fire({
                                    toast: true, position: 'top-end', icon: 'success',
                                    title: 'Inactivación realizada correctamente',
                                    showConfirmButton: false, timer: 4000, timerProgressBar: true,
                                });
                            },
                        });
                    }
                );
            }
            
            if (restoreBtn) {
                const id = restoreBtn.dataset.id;
                confirm(
                    {
                        title: "¿Restaurar?",
                        text: "El registro será activado nuevamente",
                        confirmText: "Sí, restaurar",
                    },
                    () => {
                        router.delete(route("modulo.oficios.restore", id), {
                            onSuccess: () => {
                                router.reload({ only: ["plantillas"] });
                                Swal.fire({
                                    toast: true, position: 'top-end', icon: 'success',
                                    title: 'Restauración realizada correctamente',
                                    showConfirmButton: false, timer: 4000, timerProgressBar: true,
                                });
                            },
                        });
                    }
                );
            }

            if (forceDelBtn) {
                const id = forceDelBtn.dataset.id;
                confirm(
                    {
                        title: "¿Eliminar?",
                        text: "No podrás deshacer esta acción",
                        confirmText: "Sí, eliminar",
                    },
                    () => {
                        router.delete(route("modulo.oficios.forceDelete", id), {
                            preserveScroll: true, 
                        });
                    }
                );
            }

            if (downloadBtn) {
                const id = parseInt(downloadBtn.dataset.id);
                handleDownload(id); 
            }
        };

        document.addEventListener("click", handleClick);

        return () => {
            document.removeEventListener("click", handleClick);
        };
    }, [plantillas, servidores, expedientes, selectedServidor, confirm, router]);

  return (
    <>
      <MainLayout auth={auth} topHeader="Plantillas de los oficios" insideHeader={""} backURL="/dashboard/expedientes">
        <Head title="Plantillas de oficios" />

        <AddButton href={route('modulo.oficios.crear')} />

        <div className='rounded-lg bg-white shadow p-4 mb-10'>
            <p className='font-bold'>
                Selecciona el servidor o expediente para reemplazar los datos antes de descargar un oficio.
            </p>
            <br />
            <div className="flex gap-4">
                <SelectInput
                    label="Servidor"
                    options={servidorOptions}
                    value={selectedServidor}
                    onChange={handleServidorChange}
                    placeholder="Seleccione un servidor"
                />
                <SelectInput
                    label="Expediente"
                    options={expedienteOptions}
                    value={selectedExpediente}
                    onChange={handleExpedienteChange}
                    placeholder="Seleccione un expediente"
                />
            </div>
        </div>

        <div className="mb-8 w-1/3">
            <SelectInput
                label="Ver plantillas"
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
                    { title: "ID", data: "idPlantilla" },
                    { title: "Título del oficio", data: "titulo" },
                    { title: "Operaciones",
                        orderable: false,
                        render: (data, type, row) => {
                            let buttons = `<div class="flex gap-6 justify-center">`;
                            if (row.estado === "Activos"){
                                buttons += `
                                    <div class="flex gap-8 justify-center">
                                        <button class="download-btn" data-id="${row.idPlantilla}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download-icon lucide-download"><path d="M12 15V3"/>
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="m7 10 5 5 5-5"/>
                                            </svg>
                                        </button>
                                        <button class="edit-btn" data-id="${row.idPlantilla}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-diagonal-icon lucide-move-diagonal">
                                                <path d="M11 19H5v-6"/><path d="M13 5h6v6"/><path d="M19 5 5 19"/>
                                            </svg>
                                        </button>
                                        <button class="delete-btn" data-id="${row.idPlantilla}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" 
                                                height="24" viewBox="0 0 24 24" fill="none" stroke="red" 
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                                class="lucide lucide-circle-x-icon lucide-circle-x"><circle cx="12" 
                                                cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/>
                                            </svg>
                                        </button>
                                    </div>
                                `;
                            }else{
                                buttons += `
                                    <button class="restore-btn" data-id="${row.idPlantilla}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" 
                                            stroke-linecap="round" stroke-linejoin="round" class="lucide 
                                            lucide-iteration-cw-icon lucide-iteration-cw">
                                            <path d="M4 10a8 8 0 1 1 8 8H4"/><path d="m8 22-4-4 4-4"/>
                                        </svg>
                                    </button>
                                    <button class="force-del-btn" data-id="${row.idPlantilla}">
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
                    <th>ID</th>
                    <th>Título del oficio</th>
                    <th>Operaciones</th>
                </tr>
            </thead>
        </DataTable>

      </MainLayout>
    </>
  );
}