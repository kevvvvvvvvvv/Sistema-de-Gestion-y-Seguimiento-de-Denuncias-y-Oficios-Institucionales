import MainLayout from '@/Layouts/MainLayout';
import { Head } from '@inertiajs/react';
import { useEffect, useState } from 'react';
import Highcharts from 'highcharts';
import HighchartsReact from 'highcharts-react-official';

export default function DenunciasInstitucion({ auth, denuncias }) {

    const [chartOptions, setChartOptions] = useState({
        chart: { type: 'column' },
        title: { text: 'Total de expedientes por institución' },
        xAxis: { categories: [] },
        yAxis: { title: { text: 'Cantidad de expedientes' } },
        series: [{ name: 'Expedientes', data: [] }]
    });

    useEffect(() => {
        if (denuncias) {
            const categorias = denuncias.map(d => d.nombre);
            const datos = denuncias.map(d => Number(d.total));

            setChartOptions(prev => ({
                ...prev,
                xAxis: { categories: categorias },
                series: [{ name: 'Expedientes', data: datos }]
            }));
        }
    }, [denuncias]);

    return (
        <MainLayout auth={auth} topHeader="Reporte de denuncias por institución" insideHeader={""}>
            <Head title="Reporte de denuncias por institución" />
            <HighchartsReact
                highcharts={Highcharts}
                options={chartOptions}
            />


            <h2 class="w-full text-center font-bold">Total de expedientes por institución</h2>
            <div className="mt-8 overflow-x-auto">
                <table className="min-w-full border border-gray-300">
                    <thead className="bg-gray-100">
                        <tr>
                            <th className="px-4 py-2 border">Institución</th>
                            <th className="px-4 py-2 border">Total de expedientes</th>
                        </tr>
                    </thead>
                    <tbody>
                        {denuncias.map((d, index) => (
                            <tr key={index} className={index % 2 === 0 ? "bg-white" : "bg-gray-50"}>
                                <td className="px-4 py-2 border">{d.nombre}</td>
                                <td className="px-4 py-2 border text-center">{d.total}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>


        </MainLayout>
    );
}

