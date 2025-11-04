import React from 'react';
import { Link } from '@inertiajs/react';

export default function Pagination({ links = [] }) {
  
    if (links.length <= 3) {
        return null;
    }

    return (
        <div className="flex items-center justify-between">

        <div className="flex flex-wrap -mb-1">
            {links.map((link, index) => {
            if (link.url === null) {
                return (
                <div
                    key={index}
                    className="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                    dangerouslySetInnerHTML={{ __html: link.label }}
                />
                );
            }

            return (
                <Link
                key={index}
                href={link.url}
                className={`mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500
                    ${link.active ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700'}
                `}
                dangerouslySetInnerHTML={{ __html: link.label }}
                preserveState
                replace
                >
                </Link>
            );
            })}
        </div>
        </div>
    );
}