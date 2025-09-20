import MainLayout from '@/Layouts/MainLayout';
import { Head, Link } from '@inertiajs/react';
import { useState } from 'react';

import DataTable from 'datatables.net-react';
import DT from 'datatables.net-dt'; 
import 'datatables.net-dt/css/dataTables.dataTables.css';

import Buttons from 'datatables.net-buttons-dt'; 
import 'datatables.net-buttons/js/buttons.html5.mjs';
import 'datatables.net-buttons-dt/css/buttons.dataTables.css';

import JSZip from 'jszip';
import Card from '@/Components/Card';

window.JSZip = JSZip;

DataTable.use(DT);
DataTable.use(Buttons);

export default function DocumentosFaltantes({ datosReporte, conteo, auth }) {
    const permissions = auth.permissions;
    const tableData = datosReporte.map(i => ({
        nombreCompleto: i.nombreCompleto,
        numero: i.numero,
        ofFaltantes: i.ofFaltantes,
        totalFaltantes: i.totalFaltantes,
    }));

    // Función para formatear los oficios faltantes
    const formatOficiosFaltantes = (oficios) => {
        if (!oficios || !oficios.length) return "No hay oficios faltantes";
        
        return `<ul style="padding-left:16px; list-style-type: disc;">
            ${oficios.map(d => `<li>${d}</li>`).join("")}
        </ul>`;
    };

    return (
        <>
            <MainLayout auth={auth} topHeader="Reporte de documentos faltantes por expediente" insideHeader={""}>
                <Head title="Reporte de documentos faltantes por expediente" />

                <Card title={"No. de expedientes con documentos faltantes"} data={conteo} />

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
                        exportOptions: {
                            columns: [1,2,3,4], 
                            format: {
                                body: function (data, row, column, node) {
                                    // Detecta la columna ofFaltantes (última)
                                    if (column === 4 && Array.isArray(tableData[row].ofFaltantes)) {
                                        return tableData[row].ofFaltantes.join("\n");
                                    }
                                    return data;
                                }
                            }
                        },
                        columns: [
                            { 
                                title: "",
                                data: null,
                                defaultContent: '',
                                className: "dt-control",
                                orderable: false,
                                width: "20px"
                            },
                            { title: "Nombre completo del servidor", data: "nombreCompleto" },
                            { title: "Número de expediente", data: "numero" },
                            { title: "Número de oficios y acuerdos faltantes", data: "totalFaltantes" },
                            { title: "Oficios faltantes", data: "ofFaltantes", visible: false },
                        ],
                        // Función para inicializar la tabla con child rows
                        initComplete: function () {
                            const api = this.api();
                            
                            // Agregar evento de clic para las flechas
                            api.on('click', 'td.dt-control', function (e) {
                                const tr = e.target.closest('tr');
                                const row = api.row(tr);
                                
                                if (row.child.isShown()) {
                                    // Esta fila ya está abierta - cerrarla
                                    row.child.hide();
                                    tr.classList.remove('shown');
                                } else {
                                    // Abrir esta fila
                                    const data = row.data();
                                    row.child(`
                                        <div class="p-4 bg-gray-50">
                                            <h4 class="font-bold mb-2">Oficios faltantes:</h4>
                                            ${formatOficiosFaltantes(data.ofFaltantes)}
                                        </div>
                                    `).show();
                                    tr.classList.add('shown');
                                }
                            });
                        }
                    }}
                >
                    <thead>
                        <tr>
                            <th></th>
                            <th>Nombre completo del servidor</th>
                            <th>Número de expediente</th>
                            <th>Número de oficios y acuerdos sin entregar</th>
                        </tr>
                    </thead>
                </DataTable>
            </MainLayout>
        </>
    );
}