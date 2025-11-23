import axios from 'axios';
import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

const API_HOST = import.meta.env.VITE_API_HOST;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
    authorizer: (channel) => {
        return {
            authorize: (socketId, callback) => {
                //const token = sessionStorage.getItem('api_token');
                const token = '2|WItwCkHKTzKpkr2LWRSQsKpqQKGEdGmluYpoVyEU14e4486e';

                if (!token) {
                    callback(new Error('No autenticado'));
                    return;
                }

                axios.post(`${API_HOST}/broadcasting/auth`, {
                    socket_id: socketId,
                    channel_name: channel.name
                }, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                })
                    .then(response => callback(null, response.data))
                    .catch(error => callback(error));
            }
        };
    }
});
