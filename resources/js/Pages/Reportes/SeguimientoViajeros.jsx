import MainLayout from '@/Layouts/MainLayout';
import {Head} from '@inertiajs/react';
import Highcharts from "highcharts";
import HighchartsReact from "highcharts-react-official";
import { useEffect, useState } from "react";
import { router } from '@inertiajs/react';
import InputDate from "@/Components/InputDate";
import RegisterButton from "@/Components/RegisterButton";

export default function DenunciasInstitucion({ onClick, auth, errors, datos, datosTabla, filtros}) {

    const [fechaInicio, setFechaInicio] = useState(filtros.fecha_inicio || '');
    const [fechaFin, setFechaFin] = useState(filtros.fecha_fin || '');

    const handleSubmit = (e) => {
        e.preventDefault();
        router.get(route('reportes.seguimiento-viajeros'), { 
            fecha_inicio: fechaInicio, 
            fecha_fin: fechaFin 
        });
    };

    const [chartOptions, setChartOptions] = useState({
        chart: {
            type: "column", 
        },
        title: {
            text: "Estatus de Viajeros",
        },
        xAxis: {
            type: "category",
            title: {
                text: "Estatus",
            },
        },
        yAxis: {
            title: {
                text: "Total",
            },
        },
        series: [
            {
                name: "Total",
                data: [],
            },
        ],
    });

    useEffect(() => {
        if (datos && datos.length > 0) {
            const chartData = datos.map((item) => [item.status, item.total]);

            setChartOptions((prev) => ({
                ...prev,
                series: [
                    {
                        ...prev.series[0],
                        data: chartData,
                    },
                ],
            }));
        }
    }, [datos])

    return (
        <MainLayout auth={auth} topHeader="Reporte de seguimiento de viajeros" insideHeader={""}>
            <Head title="Reporte de seguimiento de viajeros" />
            
            <form onSubmit={handleSubmit} className="mb-4 flex gap-2">

                <InputDate 
                    description="Fecha de inicio"
                    value={fechaInicio}
                    onChange={(date) => setFechaInicio(date)}
                    error={errors.fechaInico}
                    className="border px-2 py-1"
                />

                <InputDate 
                    description="Fecha de fin"
                    value={fechaFin}
                    onChange={(date) => setFechaFin(date)}
                    error={errors.fechaFin}
                    className="border px-2 py-1"
                />

                <RegisterButton
                    type="submit">
                    Filtrar
                </RegisterButton>
            </form>           
            
            
            <div className="p-4 bg-white rounded-lg shadow">
                <HighchartsReact highcharts={Highcharts} options={chartOptions} />
            </div>


            <div className="bg-white p-4 rounded-lg shadow">
                <h2 className="text-lg font-bold mb-4">Detalle de oficios y viajeros</h2>
                <table className="min-w-full border border-gray-300">
                    <thead className="bg-gray-100">
                        <tr>
                            <th className="border px-4 py-2"># Oficio</th>
                            <th className="border px-4 py-2">Fecha llegada</th>
                            <th className="border px-4 py-2">Status</th>
                            <th className="border px-4 py-2">Asunto</th>
                            <th className="border px-4 py-2">Instrucción</th>
                            <th className="border px-4 py-2">Resultado</th>
                        </tr>
                    </thead>
                    <tbody>
                        {datosTabla && datosTabla.length > 0 ? (
                            datosTabla.map((item, index) => (
                                <tr key={index} className="text-center">
                                    <td className="border px-4 py-2">{item.numOficio}</td>
                                    <td className="border px-4 py-2">{item.fechaLlegada}</td>
                                    <td className="border px-4 py-2">{item.status}</td>
                                    <td className="border px-4 py-2">{item.asunto}</td>
                                    <td className="border px-4 py-2">{item.instruccion}</td>
                                    <td className="border px-4 py-2">{item.resultado}</td>
                                </tr>
                            ))
                        ) : (
                            <tr>
                                <td colSpan="6" className="border px-4 py-2 text-center text-gray-500">
                                    No hay registros
                                </td>
                            </tr>
                        )}
                    </tbody>
                </table>
            </div>

        </MainLayout>
    );
}
