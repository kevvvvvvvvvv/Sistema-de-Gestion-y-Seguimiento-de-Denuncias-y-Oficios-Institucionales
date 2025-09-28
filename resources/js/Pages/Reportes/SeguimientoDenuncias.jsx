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

export default function DocumentosFaltantes({ datosReporte,auth }) {

    const tableData = datosReporte.map(i => ({
        numero : i.numero,
        nombreCompletoSer: i.nombreCompletoSer,
        nombreCompletoIns: i.nombreCompletoIns,
        fechaRequerimiento: i.fechaRequerimiento,
        Estado : i.Estado
    }));

    return (
        <>
            <MainLayout auth={auth} topHeader="Reporte de Seguimiento de Denuncias" insideHeader={""}>
                <Head title="Reporte de seguimiento de denuncias" />

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
                            { title: "Número", data: "numero" },
                            { title: "Nombre del servidor", data: "nombreCompletoSer" },
                            { title: "Nombre de la institución", data: "nombreCompletoIns" },
                            { title: "Fecha de requerimiento", data: "fechaRequerimiento" },
                            { title: "Estado actual", data:"Estado" }
                        ]
                    }}
                >
                    <thead>
                        <tr>
                            <th>Número</th>
                            <th>Nombre del servidor</th>
                            <th>Número de la institucion</th>
                            <th>Fecha de requerimiento</th>
                            <th>Estado actual</th>
                        </tr>
                    </thead>
                </DataTable>
            </MainLayout>
        </>
    );
}