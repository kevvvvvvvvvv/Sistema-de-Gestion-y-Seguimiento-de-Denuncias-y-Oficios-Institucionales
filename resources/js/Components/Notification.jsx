// resources/js/Components/Notification.js
import React, { useEffect } from 'react';
import { User } from 'lucide-react';

const Notification = ({ notification, onClose }) => {
   const { id, message, creator_name, timestamp } = notification;

  const typeClasses = {
    success: 'bg-green-500',
    error: 'bg-red-500',
    info: 'bg-sky-500',
  };

  return (
    // Contenedor principal de la notificación
    <div className="relative bg-white rounded-xl p-3 shadow-md w-full animate-slideIn border border-gray-200">
      
      {/* Encabezado: Ícono, Nombre y Timestamp */}
      <div className="flex items-center justify-between mb-2">
        <div className="flex items-center gap-2">
          <span className="bg-blue-500 rounded-full p-1 flex items-center justify-center">
            <User className="w-4 h-4 text-white" strokeWidth={2.5} />
          </span>
          <span className="font-bold text-sm text-gray-800">{creator_name}</span>
        </div>
        <span className="text-xs text-gray-500">{timestamp}</span>
      </div>
      
      {/* Cuerpo: Mensaje de la notificación */}
      <p className="text-sm text-gray-600 pl-8"> {/* pl-8 para alinear con el nombre */}
        {message}
      </p>

    </div>
  );
};

export default Notification;