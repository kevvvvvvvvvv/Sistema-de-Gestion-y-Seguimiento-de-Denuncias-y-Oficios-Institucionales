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

export default function DocumentosFaltantes({ datosReporte, auth }) {
    const permissions = auth.permissions;

    //Filtros
    const[selectedInstitucion, setSelectedInstitucion] = useState("");
    const[selectedOficio, setSelectedOficio] = useState("");

    const institucionOptions = [
        { value: "", label: "Todos" },
        ...[...new Set(datosReporte.map(d => d.nomInstitucion))].map(i => ({ value: i, label: i }))
    ];

    const oficioOptions = [
        { value: "", label: "Todos" },
        ...[...new Set(datosReporte.flatMap(d => d.ofFaltantes))].sort().map(oficio => ({ value: oficio, label: oficio }))
    ];

    const tableData = useMemo(() => {
        const filteredData = datosReporte.filter(item => {
            const institucionMatch = selectedInstitucion ? item.nomInstitucion === selectedInstitucion : true;
            const oficioMatch = selectedOficio ? item.ofFaltantes.includes(selectedOficio) : true;
            
            return institucionMatch && oficioMatch;
        });

        return filteredData.map(i => ({
            nombreCompleto: i.nombreCompleto,
            numero: i.numero,
            nomInstitucion: i.nomInstitucion,
            departamento: i.departamento,
            ofFaltantes: i.ofFaltantes,
            totalFaltantes: i.totalFaltantes,
        }));
    }, [datosReporte, selectedInstitucion, selectedOficio]);

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

                <Card title={"No. de expedientes incompletos"} data={tableData.length} />

                <div className="mb-10">
                    <SelectInput
                        label="Filtrar por institución:"
                        options={institucionOptions}
                        value={selectedInstitucion}
                        onChange={setSelectedInstitucion}
                    />
                    <SelectInput
                        label="Filtrar por oficio faltante:"
                        options={oficioOptions}
                        value={selectedOficio}
                        onChange={setSelectedOficio}
                    />
                </div>

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
                            { title: "Institución del servidor", data: "nomInstitucion" },
                            { title: "Departamento del servidor", data: "departamento" },
                            { title: "Número de oficios y acuerdos faltantes", data: "totalFaltantes", className: "dt-left" },
                            { title: "Oficios faltantes", data: "ofFaltantes", visible: false },
                        ],
                        
                        initComplete: function () {
                            const api = this.api();
                            
                            // Función para inicializar la tabla con child rows
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
                            <th>Número de expediente</th>
                            <th>Nombre completo del servidor</th>
                            <th>Número de expediente</th>
                            <th>Institución del servidor</th>
                            <th>Departamento del servidor</th>
                            <th>Número de oficios y acuerdos sin entregar</th>
                        </tr>
                    </thead>
                </DataTable>

                {/* <PDFButton onClick={() => window.location.href = route('reportes.documentos.faltantes.pdf')}>
                    Descargar en PDF
                </PDFButton> */}
                <PDFButton
                    onClick={() => {
                        const filterParams = {};
                        if(selectedInstitucion) {
                            filterParams.institucion = selectedInstitucion;
                        }
                        if(selectedOficio) {
                            filterParams.oficio = selectedOficio;
                        }

                        const url = route('reportes.documentos.faltantes.pdf', filterParams)
                        window.open(url, '_blank');
                    }}
                >
                    Descargar en PDF
                </PDFButton>
            </MainLayout>
        </>
    );
}