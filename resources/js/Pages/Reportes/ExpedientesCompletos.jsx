import MainLayout from '@/Layouts/MainLayout';
import { Head } from '@inertiajs/react';

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

export default function DocumentosFaltantes({ ofCompletos, conteo, auth }) {
    const permissions = auth.permissions;
    const tableData = ofCompletos.map(i => ({
        nombreCompleto: i.nombreCompleto,
        numero: i.numero,
        nomInstitucion: i.nomInstitucion,
        departamento: i.departamento,
    }));

    return (
        <>
            <MainLayout auth={auth} topHeader="Reporte de expedientes completos" insideHeader={""}>
                <Head title="Reporte de expedientes completos" />

                <Card title={"No. de expedientes completos"} data={conteo} />

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
                        ],
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
            </MainLayout>
        </>
    );
}