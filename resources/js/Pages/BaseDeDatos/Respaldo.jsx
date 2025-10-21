
import MainLayout from "@/Layouts/MainLayout";
import { Head, Link } from "@inertiajs/react"; 

export default function Respaldo({ auth, backups, success, error }) {
    const permissions = auth.permissions;
    
    return (
        <>
            <MainLayout auth={auth} topHeader="Respaldo de la base de datos" insideHeader={""}>
                <Head title="Respaldo de la base de datos" />
                
                <img className="h-64 place-self-center mt-10" src="/images/BD.png" alt="Imagen de base de datos" />

                <div className="flex justify-center mt-4">
 
                    <Link
                        href={route('bd.respaldo.store')}
                        method="post"
                        as="button"
                        preserveScroll
                        className="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                    >
                        Hacer respaldo
                    </Link>
                </div>
                

                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
                    {success && (
                        <div className="mb-4 p-4 font-medium text-sm text-green-600 bg-green-100 rounded-lg">
                            {success}
                        </div>
                    )}
                    {error && (
                        <div className="mb-4 p-4 font-medium text-sm text-red-600 bg-red-100 rounded-lg">
                            {error}
                        </div>
                    )}
                </div>


                <div className="py-12">
                    <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div className="p-6 bg-white border-b border-gray-200">
                                <h3 className="text-lg font-semibold mb-4">Mis Respaldos Generados</h3>
                                <table className="min-w-full divide-y divide-gray-200">
                                    <thead className="bg-gray-50">
                                        <tr>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody className="bg-white divide-y divide-gray-200">
                                        {backups.length > 0 ? backups.map((backup) => (
                                            <tr key={backup.id}>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {new Date(backup.created_at).toLocaleString()}
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm">
                                                    {backup.status === 'completed' && (
                                                        <span className="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            Completado
                                                        </span>
                                                    )}
                                                    {backup.status === 'pending' && (
                                                        <span className="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                            Pendiente...
                                                        </span>
                                                    )}
                                                    {backup.status === 'failed' && (
                                                        <span className="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                            Fallido
                                                        </span>
                                                    )}
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    {backup.status === 'completed' ? (

                                                        <a 
                                                            href={route('bd.respaldo.download', { backup: backup.id })}
                                                            className="text-indigo-600 hover:text-indigo-900"
                                                        >
                                                            Descargar
                                                        </a>
                                                    ) : (
                                                        <span>-</span>
                                                    )}
                                                </td>
                                            </tr>
                                        )) : (
                                            <tr>
                                                <td colSpan="3" className="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                    No se han generado respaldos.
                                                </td>
                                            </tr>
                                        )}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </MainLayout>
        </> 
    );
}