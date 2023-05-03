import 'bootstrap';

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
import axios from 'axios';


window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;

axios.interceptors.response.use(
    response => {
        // Обробка успішної відповіді
        return response
    },
    error => {
        // Обробка помилок відповіді
        if (error.response) {
            switch (error.response.status) {
                case 401:
                    // Помилка авторизації
                    error.message = 'Неправильний логін або пароль'
                    break
                case 422:
                    // Помилка невірних даних
                    error.message = 'Помилка валідації даних'
                    break
                case 500:
                    // Помилка сервера
                    error.message = 'Помилка сервера'
                    break
                default:
                    error.message = 'Помилка ' + error.response.status
            }
        } else {
            // Помилка відсутності відповіді
            error.message = 'Немає відповіді з сервера'
        }
        return Promise.reject(error)
    }
)

axios.interceptors.request.use(
    config => {
        const userToken = localStorage.getItem('x_xsrf_token'); // отримуємо токен з локального сховища
        // const adminToken = localStorage.getItem('admin_token'); // отримуємо токен з локального сховища
        if (userToken) {
            config.headers.authorization = `Bearer ${userToken}`; // додаємо токен в заголовок запиту
        }
        // else if (adminToken) {
        //     config.headers.authorization = `Bearer ${adminToken}`; // додаємо токен в заголовок запиту
        // }
        return config;
    },
    error => {
        return Promise.reject(error);
    }
);
// window.axios.interceptors.response.use({}, error => {
//     if (error.response.status === 401 || error.response.status === 419) {
//         const token = localStorage.getItem('x_xsrf_token')
//         if (token) {
//             localStorage.removeItem('x_xsrf_token')
//         }
//         router.push({name: 'sign-in'})
//     }
// })

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });
