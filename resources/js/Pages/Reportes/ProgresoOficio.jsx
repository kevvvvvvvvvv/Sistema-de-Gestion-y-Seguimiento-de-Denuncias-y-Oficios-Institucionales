import { useState, useEffect } from 'react';
import MainLayout from "@/Layouts/MainLayout";
import Highcharts from 'highcharts';
import HighchartsReact from 'highcharts-react-official';
import RegisterButton from "@/Components/RegisterButton";
import InputDate from "@/Components/InputDate";
import { Head, router } from '@inertiajs/react';


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
        <MainLayout auth={auth} topHeader="Reporte de progreso de oficios" insideHeader={""}>
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
        </MainLayout>
    );
}