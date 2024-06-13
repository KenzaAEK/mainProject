import axios from 'axios';

export default {
    namespaced: true,
    state: {
        token: null,
    },
    mutations: {
        setToken(state, token) {
            state.token = token;
        },
        clearAuthData(state) {
            state.token = null;
        }
    },
    getters: {
        authenticated(state) {
            return state.token;
        },
    },
    actions: {
        async login({ commit }, credentials) {
            try {
                const response = await axios.post('/login', credentials);
                const { token } = response.data;
                commit('setToken', token);
                console.log(response.data)
            } catch (error) {
                console.error('Login failed:', error);
                throw error;
            }
        },
        async register({ commit }, userData) {
            try {
                const response = await axios.post('/register', userData);
                const { token } = response.data;
                commit('setToken', token);
                console.log(response.data)

            } catch (error) {
                console.error('Registration failed:', error);
                throw error;
            }
        }
    }
};
