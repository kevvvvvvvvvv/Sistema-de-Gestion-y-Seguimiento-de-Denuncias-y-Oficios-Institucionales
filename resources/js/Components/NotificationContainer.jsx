// resources/js/Components/NotificationContainer.js
import React, { useState, useEffect } from 'react';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import Notification from '@/Components/Notification';

const NotificationContainer = () => {

    console.log('🔌 Conectando a Echo y escuchando en el canal PÚBLICO "notifications"...');
  const [notifications, setNotifications] = useState([]);

  useEffect(() => {
    window.Pusher = Pusher;

    const echo = new Echo({
      broadcaster: 'reverb',
      key: import.meta.env.VITE_REVERB_APP_KEY,
      wsHost: import.meta.env.VITE_REVERB_HOST,
      wsPort: import.meta.env.VITE_REVERB_PORT,
      wssPort: import.meta.env.VITE_REVERB_PORT,
      forceTLS: (import.meta.env.VITE_REVERB_SCHEME || 'http') === 'https',
      enabledTransports: ['ws', 'wss'],
    });

    echo.channel('notifications')
      .listen('NewNotificationEvent', (event) => {
        const newNotification = {
          id: Date.now(),
          message: event.message,
          type: event.type
        };
        setNotifications(prevNotifications => [newNotification, ...prevNotifications]); 
      });

    return () => {
      echo.disconnect();
    };
  }, []);

  const removeNotification = (id) => {
    setNotifications(prevNotifications =>
      prevNotifications.filter(notification => notification.id !== id)
    );
  };

  return (
    <div className="relative w-full h-full flex flex-col gap-3 overflow-y-auto pr-2">
      {notifications.map((notification) => (
        <Notification
          key={notification.id}
          notification={notification}
          onClose={removeNotification}
        />
      ))}
    </div>
  );
};

export default NotificationContainer;