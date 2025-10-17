import { useState, useEffect } from 'react';
import MainLayout from "@/Layouts/MainLayout";
import Highcharts from 'highcharts';
import HighchartsReact from 'highcharts-react-official';
import RegisterButton from "@/Components/RegisterButton";
import InputDate from "@/Components/InputDate";
import { Head, router } from '@inertiajs/react';
import PDFButton from '@/Components/PDFButton';


export default function DenunciasInstitucion({ auth, resultados, filtro}) {

    const [fechaInicio, setFechaInicio] = useState(filtro || '');

    const [chartOptions, setChartOptions] = useState({
        chart: { type: "column" },
        title: { text: "Viajeros por Fecha de Finalización" },
        xAxis: {
            type: "category",
            title: { text: "Fecha o Estatus" },
        },
        yAxis: {
            min: 0,
            title: { text: "Total de Oficios" },
        },
        series: [{ name: "Total", data: [] }],
    });

    useEffect(() => {
        if (resultados && resultados.length > 0) {
            const chartData = resultados.map((item) => [item.Categoria, item.Total]);

            setChartOptions((prev) => ({
                ...prev,
                series: [{ ...prev.series[0], data: chartData }],
            }));
        }
    }, [resultados]);

    const handleSubmit = (e) => {
        e.preventDefault();
        router.get(
            route('reportes.progreso-oficio'), { 
                fecha_inicio: fechaInicio
            }
        );
    };


    return (
        <MainLayout auth={auth} topHeader="Reporte de progreso de oficios" insideHeader={""} backURL="/dashboard/viajeros">
            <Head title="Reporte de Progreso de Oficios" />

            <form onSubmit={handleSubmit} className="mb-4 flex items-center gap-2">
                <InputDate 
                    description="Fecha"
                    value={fechaInicio}
                    onChange={(date) => setFechaInicio(date)}
                    className="border px-2 py-1"
                />
                <RegisterButton type="submit">
                    Filtrar
                </RegisterButton>
            </form> 
            
            <div className="p-4 bg-white rounded-lg shadow-md">
                <HighchartsReact
                    highcharts={Highcharts}
                    options={chartOptions}
                />
            </div>

            <h2 className="w-full text-center font-bold mt-8">Detalle de progreso de oficios</h2>
            <div className="mt-4 overflow-x-auto">
                <table className="min-w-full border border-gray-300">
                    <thead className="bg-gray-100">
                        <tr>
                            <th className="px-4 py-2 border">Categoría (Fecha o Estatus)</th>
                            <th className="px-4 py-2 border">Total de Oficios</th>
                        </tr>
                    </thead>
                    <tbody>
                        {Array.isArray(resultados) && resultados.map((item, index) => (
                            <tr key={index} className={index % 2 === 0 ? "bg-white" : "bg-gray-50"}>
                                <td className="px-4 py-2 border">{item.Categoria}</td>
                                <td className="px-4 py-2 border text-center">{item.Total}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>

            <PDFButton onClick={() => window.location.href = route('reporte.progreso-oficio.pdf',{fecha_inicio: fechaInicio})}>
                Descargar en PDF
            </PDFButton>
            
        </MainLayout>
    );
}