import MainLayout from '@/Layouts/MainLayout';
import { Head, Link } from '@inertiajs/react';
import { useState } from 'react';
import SelectInput from "@/Components/SelectInput";
import ProgresoExpediente from '@/Components/ProgresoExpediente';
import PDFButton from '@/Components/PDFButton';

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

    //Filtros
    const [selectedStatus, setSelectedStatus] = useState("")
    const [selectedInstitucion, setSelectedInstitucion] = useState("");

    const estadoOptions = [
        { value: "", label: "Todos" },
        ...[...new Set(datosReporte.map(d => d.Estado))].map(estado => ({
            value: estado,
            label: estado
        }))
    ];

    const institucionOptions = [
        { value: "", label: "Todos" },
        ...[...new Set(datosReporte.map(d => d.nombreCompletoIns))].map(i => ({ value: i, label: i }))
    ];

    const filteredTableData = tableData.filter(d => {
        const statusMatch = selectedStatus ? d.Estado === selectedStatus : true;
        const institucionMatch = selectedInstitucion ? d.nombreCompletoIns === selectedInstitucion : true;
        return statusMatch && institucionMatch;
    });

    //Línea de seguimiento
    const [servidorSeleccionado, setServidorSeleccionado] = useState("");

    const servidorOptions = [...new Set(filteredTableData.map(d => d.nombreCompletoSer))].map(servidor => ({
        value: servidor,
        label: servidor
    }));

    const expedienteSeleccionado = filteredTableData.find(
        d => d.nombreCompletoSer === servidorSeleccionado
    );

    return (
        <>
            <MainLayout auth={auth} topHeader="Reporte de Seguimiento de Denuncias" insideHeader={""}>
                <Head title="Reporte de seguimiento de denuncias" />

                <div className="mb-10">
                    <SelectInput
                        label="Filtrar por estado:"
                        options={estadoOptions}
                        value={selectedStatus}
                        onChange={setSelectedStatus}
                    />
                    <SelectInput
                        label="Filtrar por institución:"
                        options={institucionOptions}
                        value={selectedInstitucion}
                        onChange={setSelectedInstitucion}
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

                <div className="mt-12 relative z-50">
                    <h1 className="mb-4 font-bold text-lg">Línea de seguimiento</h1>
                    <SelectInput
                        label="Seleccionar servidor:"
                        options={servidorOptions}
                        value={servidorSeleccionado}
                        onChange={setServidorSeleccionado}
                    />
                </div>

                <div className="mt-14 mb-20">
                    {expedienteSeleccionado ? (
                        <ProgresoExpediente estado={expedienteSeleccionado.Estado} />
                    ) : (
                        <p className="text-gray-500 text-sm">Selecciona un servidor para ver el progreso.</p>
                    )}
                </div>

                <PDFButton onClick={() => window.location.href = route('reportes.seguimiento.deununcias.pdf')}>
                    Descargar en PDF
                </PDFButton>
            </MainLayout>
        </>
    );
}