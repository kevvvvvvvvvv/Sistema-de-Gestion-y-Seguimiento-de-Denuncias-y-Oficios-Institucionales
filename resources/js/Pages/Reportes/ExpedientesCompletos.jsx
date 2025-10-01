import MainLayout from '@/Layouts/MainLayout';
import { Head, router } from '@inertiajs/react';
import Card from '@/Components/Card';
import { useEffect, useState } from 'react';
import Highcharts from 'highcharts';
import HighchartsReact from 'highcharts-react-official';
import RegisterButton from "@/Components/RegisterButton";
import ModalTable from '@/Components/ModalTable';

import DataTable from 'datatables.net-react';
import DT from 'datatables.net-dt'; 
import 'datatables.net-dt/css/dataTables.dataTables.css';

import Buttons from 'datatables.net-buttons-dt'; 
import 'datatables.net-buttons/js/buttons.html5.mjs';
import 'datatables.net-buttons-dt/css/buttons.dataTables.css';

import JSZip from 'jszip';
import PDFButton from '@/Components/PDFButton';

window.JSZip = JSZip;

DataTable.use(DT);
DataTable.use(Buttons);

export default function DocumentosFaltantes({ ofCompletos, conteo, exIncompletos, auth }) {
    const permissions = auth.permissions;
    const tableData = ofCompletos.map(i => ({
        nombreCompleto: i.nombreCompleto,
        numero: i.numero,
        nomInstitucion: i.nomInstitucion,
        departamento: i.departamento,
        ofRequerimiento: i.ofRequerimiento,
        fechaRequerimiento: i.fechaRequerimiento,
        ofRespuesta: i.ofRespuesta,
        fechaRespuesta: i.fechaRespuesta,
        fechaRecepcion: i.fechaRecepcion,
    }));

    const [chartOptions] = useState({
        chart: { type: 'column' },
        title: { text: 'Comparación entre los expedientes completos e incompletos' },
        xAxis: { title: { text: 'Tipo de expediente' }, categories: ['Completos', 'Incompletos'] },
        yAxis: { title: { text: 'Número de expedientes' } },
            legend: {
            enabled: false  
        },
        series: [{
            name: 'Expedientes',
            data: [
                    { y: conteo, color: "#90ed7d" },  
                    { y: exIncompletos, color: "#f45b5b" } 
                ]
        }]
    });

    const [modalOpen, setModalOpen] = useState(false);
    const [modalData, setModalData] = useState(null);

    return (
        <>
            <MainLayout auth={auth} topHeader="Reporte de expedientes completos" insideHeader={""}>
                <Head title="Reporte de expedientes completos" />

                <Card title={"No. de expedientes completos"} data={conteo} 
                    title2={"No. de expedientes incompletos"} data2={exIncompletos}
                />

                <HighchartsReact
                    highcharts={Highcharts}
                    options={chartOptions}
                />

                <br/>
                <br/>

                <hr/>

                <h2 className="w-full text-center font-bold my-10">Expedientes completos</h2>

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
                            { title: "Número de expediente", data: "numero" },
                            { title: "Nombre completo del servidor", data: "nombreCompleto" },
                            { title: "Institución del servidor", data: "nomInstitucion" },
                            { title: "Departamento del servidor", data: "departamento" },
                            { title: "Oficio de requerimiento", data: "ofRequerimiento", visible: false },
                            { title: "Fecha del oficio de requerimiento", data: "fechaRequerimiento", visible: false },
                            { title: "Oficio de respuesta", data: "ofRespuesta", visible: false },
                            { title: "Fecha del oficio de respuesta", data: "fechaRespuesta", visible: false },
                            { title: "Fecha de recepción del oficio de respuesta", data: "fechaRecepcion", visible: false },
                            { 
                                title: "Acciones",
                                data: null, 
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                    return `<button class="btn-ver-detalles px-3 py-1 bg-azulIMTA text-white text-sm rounded">Ver detalles</button>`;
                                }
                            }
                        ],

                        initComplete: function () {
                            const api = this.api();
                            
                            // FILTRADO DE COLUMNA
                            api.columns(2).every(function () {
                                const column = this;
                                const select = document.createElement("select");
                                select.classList.add("border", "px-2", "py-1", "text-sm");
                                select.innerHTML = `<option value="">-- Todas --</option>`;

                                // Insertar input en el header
                                column.header().appendChild(select);

                                // Llenar el select con valores únicos de la columna
                                column
                                    .data()
                                    .unique()
                                    .sort()
                                    .each(function (d) {
                                        if (d) {
                                            const option = document.createElement("option");
                                            option.value = d;
                                            option.textContent = d;
                                            select.appendChild(option);
                                        }
                                    });

                                // Evento para filtrar cuando cambia el select
                                select.addEventListener("change", function () {
                                    const val = this.value;
                                    column.search(val ? '^' + val + '$' : '', true, false).draw();
                                });
                            });

                            // ABRIR EL MODAL
                            api.on('click', '.btn-ver-detalles', function(){
                                const tr = this.closest('tr');
                                const row = api.row(tr);
                                setModalData(row.data());
                                setModalOpen(true);
                            });
                        }
                    }}
                >
                    <thead>
                        <tr>
                            <th>Número de expediente</th>
                            <th>Nombre completo del servidor</th>
                            <th>Institución del servidor</th>
                            <th>Departamento del servidor</th>
                        </tr>
                    </thead>
                </DataTable>

                <ModalTable
                    open={modalOpen} 
                    onClose={() => setModalOpen(false)} 
                    data={modalData} 
                />

                <PDFButton onClick={() => window.location.href = route('reportes.expedientes.completos.pdf')}>
                    Descargar en PDF
                </PDFButton>
            </MainLayout>
        </>
    );
}