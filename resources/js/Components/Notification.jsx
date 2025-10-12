// resources/js/Components/Notification.js
import React, { useEffect } from 'react';

const Notification = ({ notification, onClose }) => {
  const { id, message, type } = notification;

  useEffect(() => {
    const timer = setTimeout(() => {
      onClose(id);
    }, 8000);

    return () => clearTimeout(timer);
  }, [id, onClose]);

  const typeClasses = {
    success: 'bg-green-500',
    error: 'bg-red-500',
    info: 'bg-sky-500',
  };

  return (
    <div
      className={`
        flex items-center justify-between w-full p-4 rounded-lg text-white shadow-lg flex-shrink-0
        animate-slideIn
        ${typeClasses[type] || typeClasses.info}
      `}
    >
      <span className="mr-4">{message}</span>
      <button 
        onClick={() => onClose(id)} 
        className="bg-transparent border-none text-lg cursor-pointer opacity-70 hover:opacity-100"
      >
        &times;
      </button>
    </div>
  );
};

export default Notification;