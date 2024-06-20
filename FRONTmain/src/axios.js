import axios from 'axios';
import router from './router'; // Assurez-vous d'importer votre router Vue

const excludedRoutes = ['/login', '/register', '/users'];

axios.interceptors.request.use(function (config) {
    if (!excludedRoutes.includes(router.currentRoute.path)) {
        const token = localStorage.getItem('token');
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
    }
    return config;
}, function (error) {
    return Promise.reject(error);
});

export default axios;
