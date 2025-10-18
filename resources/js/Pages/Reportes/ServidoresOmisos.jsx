import MainLayout from '@/Layouts/MainLayout';
import { Head, Link } from '@inertiajs/react';
import { useState, useMemo } from 'react';
import SelectInput from '@/Components/SelectInput';

import DataTable from 'datatables.net-react';
import DT from 'datatables.net-dt'; 
import 'datatables.net-dt/css/dataTables.dataTables.css';

import Buttons from 'datatables.net-buttons-dt'; 
import 'datatables.net-buttons/js/buttons.html5.mjs';
import 'datatables.net-buttons-dt/css/buttons.dataTables.css';

import JSZip from 'jszip';
import Card from '@/Components/Card';
import PDFButton from '@/Components/PDFButton';

window.JSZip = JSZip;

DataTable.use(DT);
DataTable.use(Buttons);

export default function DocumentosFaltantes({ servidoresOmisosBaja, servidoresOmisosAlta, numOmisosBaja, numOmisosAlta, auth }) {
    const permissions = auth.permissions;

    const [selectedInstitucion, setSelectedInstitucion] = useState("");

    const filteredOmisosBaja = useMemo(() => {
        if (!selectedInstitucion) return servidoresOmisosBaja;
        return servidoresOmisosBaja.filter(item => item.institucion === selectedInstitucion);
    }, [servidoresOmisosBaja, selectedInstitucion]);

    const filteredOmisosAlta = useMemo(() => {
        if (!selectedInstitucion) return servidoresOmisosAlta;
        return servidoresOmisosAlta.filter(item => item.institucion === selectedInstitucion);
    }, [servidoresOmisosAlta, selectedInstitucion]);

    const institucionOptions = useMemo(() => {
        const set = new Set([
            ...servidoresOmisosBaja.map(d => d.institucion),
            ...servidoresOmisosAlta.map(d => d.institucion)
        ]);
        return [
            { value: "", label: "Todos" },
            ...Array.from(set).sort().map(i => ({ value: i, label: i }))
        ];
    }, [servidoresOmisosBaja, servidoresOmisosAlta]);

    const tableDataOmisosBaja = servidoresOmisosBaja.map(i => ({
        nombreCompleto: i.nombreCompleto,
        numero: i.numero,
        institucion: i.institucion,
        departamento: i.departamento,
        fechaBaja: i.fechaBaja,
        descrBaja: i.descrBaja,
        fechaLimite: i.fechaLimite,
        difDias: i.difDias,
    }));

    const tableDataOmisosAlta = servidoresOmisosAlta.map(i => ({
        nombreCompleto: i.nombreCompleto,
        numero: i.numero,
        fechaIngreso: i.fechaIngreso,
        institucion: i.institucion,
        departamento: i.departamento,
        descrAlta: i.descrAlta,
        acInicio: i.acInicio,
        fechaLimite: i.fechaLimite,
        difDias: i.difDias,
    }));

    // Función para formatear los datos del desplegable
    const formatDetalle = (data) => {
        return `
            <div class="p-4 bg-gray-50">
                <ul style="padding-left:16px; list-style-type: disc;">
                    <li><b>Fecha límite para entregar el acuerdo:</b> ${data.fechaLimite}</li>
                    <li><b>Días desde la omsión:</b> ${data.difDias}</li>
                </ul>
            </div>
        `;
    };

    return (
        <>
            <MainLayout auth={auth} topHeader="Reporte de servidores omisos" insideHeader={""}>
                <Head title="Reporte de servidores omisos" />

                <SelectInput
                    label="Filtrar por institución:"
                    options={institucionOptions}
                    value={selectedInstitucion}
                    onChange={(value) => setSelectedInstitucion(value)}
                />

                {/* Conteo de servidores */}
                <Card 
                    title={"No. de servidores omisos sin Acuerdo de Conclusión"} data={filteredOmisosBaja.length} 
                    title2={"No. de servidores omisos sin Acuerdo de Inicio"} data2={filteredOmisosAlta.length} 
                /> 

                {/* Servidores sin archivo de conclusión */}
                <h1 className='text-xl font-bold my-8'>Servidores omisos por falta del Acuerdo de Conclusión</h1>
                <DataTable 
                    data={filteredOmisosBaja} 
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
                            { title: "Institución anterior del servidor", data: "institucion" },
                            { title: "Departamento anterior del servidor", data: "departamento" },
                            { title: "Fecha de la baja", data: "fechaBaja" },
                            { title: "Descripción de la baja", data: "descrBaja" },
                            { title: "Fecha límite para entregar el acuerdo", data: "fechaLimite", visible: false },
                            { title: "Días desde la omsión", data: "difDias", visible: false }
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
                            <th>Institución anterior del servidor</th>
                            <th>Departamento anterior del servidor</th>
                            <th>Fecha de la baja</th>
                            <th>Descripción de la baja</th>
                        </tr>
                    </thead>
                </DataTable>

                <hr className='mt-10' />

                {/* Servidores sin archivo de inicio */}
                <h1 className='text-xl font-bold my-8'>Servidores omisos por falta del Acuerdo de Inicio</h1>
                <DataTable 
                    data={filteredOmisosAlta} 
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
                            { title: "Institución actual del servidor", data: "institucion" },
                            { title: "Departamento actual del servidor", data: "departamento" },
                            { title: "Fecha la alta (reingreso)", data: "fechaIngreso" },
                            { title: "Descripción de la alta", data: "descrAlta" },
                            { title: "Fecha límite para entregar el acuerdo", data: "fechaLimite", visible: false },
                            { title: "Días desde la omsión", data: "difDias", visible: false }
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
                            <th>Institución actual del servidor</th>
                            <th>Departamento actual del servidor</th>
                            <th>Fecha la alta (reingreso)</th>
                            <th>Descripción de la alta</th>
                        </tr>
                    </thead>
                </DataTable>

                <PDFButton 
                    onClick={() => {
                        const url = route('reportes.servidores.omisos.pdf', { institucion: selectedInstitucion });
                        window.open(url, '_blank');
                    }}
                >
                    Descargar en PDF
                </PDFButton>
            </MainLayout>
        </>
    );
}