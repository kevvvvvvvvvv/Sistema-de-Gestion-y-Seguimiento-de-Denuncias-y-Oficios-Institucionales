// resources/js/Components/NotificationContainer.jsx

import React, { useState, useEffect } from 'react';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import Notification from '@/Components/Notification';
import axios from 'axios';

const NotificationContainer = ({ auth }) => {
    const [notifications, setNotifications] = useState([]);

    useEffect(() => {
        if (!auth || !auth.user) return;
        
        axios.get(route('notifications.index')).then(response => {
            const historicalNotifications = response.data.map(notification => ({
                id: notification.id,
                message: notification.data.message,
                creator_name: notification.data.creator_name,
                timestamp: notification.data.timestamp,
            }));
            setNotifications(historicalNotifications);
        });
    }, [auth.user]);


    useEffect(() => {
        if (!auth || !auth.user) return;

        const echo = new Echo({
        broadcaster: 'reverb',
        key: import.meta.env.VITE_REVERB_APP_KEY,
        wsHost: import.meta.env.VITE_REVERB_HOST,
        wsPort: import.meta.env.VITE_REVERB_PORT,
        wssPort: import.meta.env.VITE_REVERB_PORT,
        forceTLS: (import.meta.env.VITE_REVERB_SCHEME || 'http') === 'https',
        enabledTransports: ['ws', 'wss'],
        });
        
        echo.private(`App.Models.User.${auth.user.idUsuario}`)
        .notification((notification) => {
            const newNotification = {
            id: notification.id || Date.now(),
            message: notification.message,
            creator_name: notification.creator_name,
            timestamp: notification.timestamp,
            };
            
            setNotifications(prevNotifications => 
                [newNotification, ...prevNotifications].slice(0, 20)
            );
        });

        return () => echo.disconnect();
    }, [auth.user]);

    const removeNotification = (id) => {
        setNotifications(prevNotifications =>
        prevNotifications.filter(notification => notification.id !== id)
        );
    };

    return (
        <div className="relative w-full h-full flex flex-col gap-3 overflow-y-scroll pr-2">
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