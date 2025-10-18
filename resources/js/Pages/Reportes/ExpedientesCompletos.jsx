import MainLayout from '@/Layouts/MainLayout';
import { Head, router } from '@inertiajs/react';
import Card from '@/Components/Card';
import { useEffect, useState, useMemo } from 'react';
import Highcharts from 'highcharts';
import HighchartsReact from 'highcharts-react-official';
import RegisterButton from "@/Components/RegisterButton";
import ModalTable from '@/Components/ModalTable';
import SelectInput from '@/Components/SelectInput';

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

export default function DocumentosFaltantes({ ofCompletos, conteo, exIncompletos, incompletosPorInstitucion, auth }) {
    const permissions = auth.permissions;

    const [selectedInstitucion, setSelectedInstitucion] = useState("");

    const filteredCompletos = useMemo(() => {
        if (!selectedInstitucion) {
            return ofCompletos; 
        }
        return ofCompletos.filter(item => item.nomInstitucion === selectedInstitucion);
    }, [ofCompletos, selectedInstitucion]);

    const filteredIncompletos = useMemo(() => {
        if (!selectedInstitucion) {
            return exIncompletos;
        }
        return incompletosPorInstitucion[selectedInstitucion] || 0;
    }, [selectedInstitucion, exIncompletos, incompletosPorInstitucion]);

    const tableData = useMemo(() => filteredCompletos.map(i => ({
        nombreCompleto: i.nombreCompleto,
        numero: i.numero,
        nomInstitucion: i.nomInstitucion,
        departamento: i.departamento,
        ofRequerimiento: i.ofRequerimiento,
        fechaRequerimiento: i.fechaRequerimiento,
        ofRespuesta: i.ofRespuesta,
        fechaRespuesta: i.fechaRespuesta,
        fechaRecepcion: i.fechaRecepcion,
    })), [filteredCompletos]);

    const institucionOptions = useMemo(() => [
        { value: "", label: "Todos" },
        ...[...new Set(ofCompletos.map(d => d.nomInstitucion))].sort().map(i => ({ value: i, label: i }))
    ], [ofCompletos]);

    const dynamicChartOptions = useMemo(() => ({
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
                { y: filteredCompletos.length, color: "#90ed7d" },
                { y: filteredIncompletos, color: "#f45b5b" }
            ]
        }]
    }), [filteredCompletos, filteredIncompletos]);

    const [modalOpen, setModalOpen] = useState(false);
    const [modalData, setModalData] = useState(null);

    return (
        <>
            <MainLayout auth={auth} topHeader="Reporte de expedientes completos" insideHeader={""}>
                <Head title="Reporte de expedientes completos" />

                <SelectInput
                    label="Filtrar por institución:"
                    options={institucionOptions}
                    value={selectedInstitucion}
                    onChange={(value) => setSelectedInstitucion(value)}
                />

                <Card title={"No. de expedientes completos"} data={filteredCompletos.length} 
                    title2={"No. de expedientes incompletos"} data2={filteredIncompletos}
                />

                <HighchartsReact
                    highcharts={Highcharts}
                    options={dynamicChartOptions}
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

                <PDFButton 
                    onClick={() => {
                        const url = route('reportes.expedientes.completos.pdf', { institucion: selectedInstitucion });
                        window.open(url, '_blank');
                    }}
                >
                    Descargar en PDF
                </PDFButton>
            </MainLayout>
        </>
    );
}