import { defineStore } from 'pinia';
import axios from 'axios';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        token: null,
        user: null,
    }),
    actions: {
        setToken(token) {
            this.token = token;
            localStorage.setItem('token', token);  // Store the token in localStorage
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`; // Set token in axios headers
        },
    },
    getters: {
        isAuthenticated: (state) => !!state.token,
    },
});
