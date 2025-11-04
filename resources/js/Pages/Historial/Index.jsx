import React from 'react';
import { Head, Link, router } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'; 
import Pagination from '@/Components/Pagination'; 
import MainLayout from '@/Layouts/MainLayout';

export default function Index({ auth, logs, users, filters }) {


    const handleFilterChange = (e) => {
        const { name, value } = e.target;
        router.get(route('historial.index'), {
            ...filters, 
            [name]: value, 
        }, {
            preserveState: true,
            replace: true,
        });
    };

    const formatChanges = (properties) => {
        if (!properties || (!properties.old && !properties.attributes)) {
            return null;
        }
        const changes = properties.attributes || {};
        const old = properties.old || {};
        const relevantKeys = Object.keys(changes).filter(
            key => key !== 'updated_at'
        );

        if (relevantKeys.length === 0) {
            return <div className="mt-2 text-xs text-gray-500">(Solo se actualizó la fecha)</div>;
        }

        return (
            <ul className="mt-2 text-xs text-gray-600 list-disc list-inside">
                {relevantKeys.map(key => (
                    <li key={key}>
                        <strong>{key}:</strong> 
                        <span> cambió de </span>
                        <em className="text-red-600">'{old[key] || 'vacío'}'</em>
                        <span> a </span>
                        <strong className="text-green-700">'{changes[key]}'</strong>.
                    </li>
                ))}
            </ul>
        );
    };

    const formatSubjectType = (type) => {
        if (!type) return 'Sistema';
        return type.split('\\').pop(); 
    };

    return (
        
        <MainLayout auth={auth} topHeader="Consulta de instituciones" insideHeader={""}>
            <Head title='Historial' />
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 bg-white border-b border-gray-200 flex space-x-4">
                            <div className="w-1/2">
                                <label htmlFor="user_id" className="block text-sm font-medium text-gray-700">Filtrar por Usuario</label>
                                <select
                                    id="user_id"
                                    name="user_id"
                                    value={filters.user_id || ''}
                                    onChange={handleFilterChange}
                                    className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                >
                                    <option value="">Todos los usuarios</option>
                                    {users.map(user => (
                                        <option key={user.id} value={user.id}>{user.nombre + ' ' + user.apPaterno + ' ' + user.apMaterno}</option>
                                    ))}
                                </select>
                            </div>
                        </div>

                        <table className="min-w-full divide-y divide-gray-200">
                            <thead className="bg-gray-50">
                                <tr>
                                    <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                                    <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acción</th>
                                    <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recurso Afectado</th>
                                    <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                </tr>
                            </thead>
                            <tbody className="bg-white divide-y divide-gray-200">
                                {logs.data.map(log => (
                                    <tr key={log.id}>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {log.causer ? log.causer.nombre + ' ' + log.causer.apPaterno + ' ' + log.causer.apMaterno: 'Sistema'}
                                        </td>
                                        <td className="px-6 py-4 text-sm text-gray-500">
                                            <div className="font-medium text-gray-900">{log.description}</div>
                                            {log.event === 'updated' && (
                                                formatChanges(log.properties)
                                            )}
                                        </td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {log.subject ? (
                                                `${formatSubjectType(log.subject_type)} (ID: ${log.subject_id})`
                                            ) : (
                                                'N/A'
                                            )}
                                        </td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {new Date(log.created_at).toLocaleString('es-MX')}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                        <div className="p-6 bg-white border-t border-gray-200">
                            <Pagination links={logs.links} />
                        </div>

                    </div>
                </div>
            </div>
        </MainLayout>
    );
}
