import store from '@/store'
import axios from 'axios';

store.subscribe((mutation) => {

    if(mutation.type === 'auth/setToken') {
        if(mutation.payload) {
            axios.defaults.headers.common['Authorization'] = `Bearer ${mutation.payload}`
            localStorage.setItem('token', mutation.payload);
        }
        else {
            axios.defaults.headers.common['Authorization'] = null
            localStorage.removeItem('token');
        }
    }

})