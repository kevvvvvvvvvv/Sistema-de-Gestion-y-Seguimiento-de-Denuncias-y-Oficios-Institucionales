import MainLayout from '@/Layouts/MainLayout';
import { Head, Link } from '@inertiajs/react';
import { useState, useMemo } from 'react';

import DataTable from 'datatables.net-react';
import DT from 'datatables.net-dt'; 
import 'datatables.net-dt/css/dataTables.dataTables.css';

import Buttons from 'datatables.net-buttons-dt'; 
import 'datatables.net-buttons/js/buttons.html5.mjs';
import 'datatables.net-buttons-dt/css/buttons.dataTables.css';

import JSZip from 'jszip';
import Card from '@/Components/Card';
import PDFButton from '@/Components/PDFButton';
import SelectInput from '@/Components/SelectInput';

window.JSZip = JSZip;

DataTable.use(DT);
DataTable.use(Buttons);

const documentoOptions = [
    { value: "", label: "Sin filtrar" },
    { value: "inicio", label: "Falta Acuerdo de Inicio" },
    { value: "modificacion", label: "Falta Acuerdo de Modificación" },
    { value: "conclusion", label: "Falta Acuerdo de Conclusión" },
];

export default function DocumentosFaltantes({ servidoresOmisos, auth }) {
    const permissions = auth.permissions;

    //Filtros
    const[selectedInstitucion, setSelectedInstitucion] = useState("");
    const [selectedDocumento, setSelectedDocumento] = useState("");

    const institucionOptions = useMemo(() => [
        { value: "", label: "Todos" },
        ...[...new Set(servidoresOmisos.map(d => d.institucion))]
            .sort()
            .map(i => ({ value: i, label: i }))
    ], [servidoresOmisos]);

    const tableData = useMemo(() => {
            const filteredByInstitucion = !selectedInstitucion
            ? servidoresOmisos
            : servidoresOmisos.filter(item => item.institucion === selectedInstitucion);

        const filteredData = filteredByInstitucion.filter(item => {
            switch (selectedDocumento) {
                case "inicio":
                    return item.acInicio === "No"; 
                case "modificacion":
                    return item.acModificacion === "No";
                case "conclusion":
                    return item.acConclusion === "No"; 
                case "":
                default:
                    return true; 
            }
        });

        return filteredData.map(i => ({
            nombreCompleto: i.nombreCompleto,
            numero: i.numero,
            fechaIngreso: i.fechaIngreso,
            institucion: i.institucion,
            departamento: i.departamento,
            acInicio: i.acInicio,
            acModificacion: i.acModificacion,
            acConclusion: i.acConclusion,
            fechaLimiteIni: i.fechaLimiteIni,
            fechaLimiteModi: i.fechaLimiteModi,
            fechaLimiteCon: i.fechaLimiteCon,
            difDiasIni: i.difDiasIni,
            difDiasModi: i.difDiasModi,
            difDiasCon: i.difDiasCon
        }));
    }, [servidoresOmisos, selectedInstitucion, selectedDocumento]);

    const formatDetalle = (data) => {
        return `
            <div class="p-4 bg-gray-50">
                <ul style="padding-left:16px; list-style-type: disc;">
                    <li><b>Fecha límite para entregar Acuerdo de Inicio:</b> ${data.fechaLimiteIni}</li>
                    <li><b>Días desde la omsión:</b> ${data.difDiasIni}</li>
                    <br>
                    <li><b>Fecha límite para entregar Acuerdo de Modificación:</b> ${data.fechaLimiteModi}</li>
                    <li><b>Días desde la omsión:</b> ${data.difDiasModi}</li>
                    <br>
                    <li><b>Fecha límite para entregar Acuerdo de Conclusión:</b> ${data.fechaLimiteCon}</li>
                    <li><b>Días desde la omsión:</b> ${data.difDiasCon}</li>
                </ul>
            </div>
        `;
    };

    return (
        <>
            <MainLayout auth={auth} topHeader="Reporte de servidores omisos" insideHeader={""} backURL={route('expedientes.dashboard')}>
                <Head title="Reporte de servidores omisos" />

                <div className="mb-10">
                    <SelectInput
                        label="Filtrar por institución:"
                        options={institucionOptions}
                        value={selectedInstitucion}
                        onChange={(value) => setSelectedInstitucion(value)}
                    />
                    <SelectInput
                        label="Filtrar por documento faltante:"
                        options={documentoOptions}
                        value={selectedDocumento}
                        onChange={(value) => setSelectedDocumento(value)}
                    />
                </div>

                <Card title={"No. de servidores omisos"} data={tableData.length} /> 

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
                            { 
                                title: "",
                                data: null,
                                defaultContent: '',
                                className: "dt-control",
                                width: "20px"
                            },
                            { title: "Número de expediente", data: "numero" },
                            { title: "Nombre completo del servidor", data: "nombreCompleto" },
                            { title: "Institución del servidor", data: "institucion" },
                            { title: "Departamento del servidor", data: "departamento" },
                            { title: "¿Cuenta con Acuerdo de Inicio?", data: "acInicio" },
                            { title: "¿Cuenta con Acuerdo de Modificación?", data: "acModificacion" },
                            { title: "¿Cuenta con Acuerdo de Conclusión?", data: "acConclusion" },
                            { title: "Fecha límite para entregar Acuerdo de Inicio", data: "fechaLimiteIni", visible: false },
                            { title: "Días desde la omsión", data: "difDiasIni", visible: false },
                            { title: "Fecha límite para entregar para entregar Acuerdo de Modificación", data: "fechaLimiteModi", visible: false },
                            { title: "Días desde la omsión", data: "difDiasModi", visible: false },
                            { title: "Fecha límite para entregar para entregar Acuerdo de Conclusión", data: "fechaLimiteCon", visible: false },
                            { title: "Días desde la omsión", data: "difDiasCon", visible: false }
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
                                    row.child(formatDetalle(data)).show();
                                    tr.classList.add('shown');
                                }
                            });
                        }
                    }}
                >
                    <thead>
                        <tr>
                            <th></th>
                            <th>Número de expediente</th>
                            <th>Nombre completo del servidor</th>
                            <th>Institución del servidor</th>
                            <th>Departamento del servidor</th>
                            <th>¿Cuenta con Acuerdo de Inicio?</th>
                            <th>¿Cuenta con Acuerdo de Modificación?</th>
                            <th>¿Cuenta con Acuerdo de Conclusión?</th>
                        </tr>
                    </thead>
                </DataTable>

                <PDFButton onClick={() => {
                    const params = {};
                    if (selectedInstitucion) {
                        params.institucion = selectedInstitucion;
                    }
                    if (selectedDocumento) {
                        params.filtroDoc = selectedDocumento;
                    }

                    const url = route('reportes.servidores.omisos.pdf', params);
                    window.open(url, '_blank');
                }}>
                    Descargar en PDF
                </PDFButton>
            </MainLayout>
        </>
    );
}