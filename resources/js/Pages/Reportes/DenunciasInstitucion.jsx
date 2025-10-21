import MainLayout from '@/Layouts/MainLayout';
import { Head, useForm } from '@inertiajs/react'; 
import { useEffect, useState } from 'react';
import Highcharts from 'highcharts';
import HighchartsReact from 'highcharts-react-official';
import RegisterButton from "@/Components/RegisterButton";
import PDFButton from '@/Components/PDFButton';
import InputDate from '@/Components/InputDate';

export default function DenunciasInstitucion({ auth, denuncias, filtros ={} }) {

    const [chartOptions, setChartOptions] = useState({
        chart: { type: 'column' },
        title: { text: 'Total de expedientes por institución' },
        xAxis: { categories: [] },
        yAxis: { title: { text: 'Cantidad de expedientes' } },
        series: [{ name: 'Expedientes', data: [] }]
    });

    const { data, setData, get, errors } = useForm({
        fecha_inicio: filtros.fecha_inicio || '',
        fecha_fin: filtros.fecha_fin || '',
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


    const handleSubmit = (e) => {
        e.preventDefault();
        get(route('reportes.denuncias-institucion'), {
            preserveState: true, 
            preserveScroll: true, 
        });
    }

    return (
        <MainLayout auth={auth} topHeader="Reporte de denuncias por institución" insideHeader={""} backURL={"/dashboard/expedientes"}>
            <Head title="Reporte de denuncias por institución" />

                <form onSubmit={handleSubmit} className="mb-4 flex gap-2">
 
                    <InputDate 
                        description="Fecha de inicio"
                        value={data.fecha_inicio} 
                        onChange={(date) => setData('fecha_inicio', date)} 
                        error={errors.fecha_inicio} 
                        className="border px-2 py-1"
                    />
    
                    <InputDate 
                        description="Fecha de fin"
                        value={data.fecha_fin} 
                        onChange={(date) => setData('fecha_fin', date)} 
                        error={errors.fecha_fin} 
                        className="border px-2 py-1"
                    />
    
                    <RegisterButton
                        type="submit">
                        Filtrar
                    </RegisterButton>
                </form>    

            <HighchartsReact
                highcharts={Highcharts}
                options={chartOptions}
            />

            <h2 className="w-full text-center font-bold">Total de expedientes por institución</h2>
            <div className="mt-8 overflow-x-auto">
                <table className="min-w-full border border-gray-300">
                    <thead className="bg-gray-100">
                        <tr>
                            <th className="px-4 py-2 border">Institución</th>
                            <th className="px-4 py-2 border">Total de expedientes</th>
                            <th className="px-4 py-2 border">Fecha de requerimiento</th>
                        </tr>
                    </thead>
                    <tbody>
                        {denuncias.map((d, index) => (
                            <tr key={index} className={index % 2 === 0 ? "bg-white" : "bg-gray-50"}>
                                <td className="px-4 py-2 border">{d.nombre}</td>
                                <td className="px-4 py-2 border text-center">{d.total}</td>
                                <td className="px-4 py-2 border text-center">{d.fechaRequerimiento}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>

            <PDFButton 
                onClick={() => {
                    const url = route('reportes.denuncias.pdf', {
                        fecha_inicio: data.fecha_inicio,
                        fecha_fin: data.fecha_fin
                    });
                    window.location.href = url;
                }}
            >
                Descargar en PDF
            </PDFButton>
        </MainLayout>
    );
}