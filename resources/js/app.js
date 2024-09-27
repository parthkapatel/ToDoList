import { createApp } from 'vue';
import { createPinia } from 'pinia';
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
import router from "./router/index.js";
import { useAuthStore } from '../js/store/auth';
import App from "./components/layout/app.vue";

toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": true,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};
window.toastr = toastr;

const pinia = createPinia();
const app = createApp(App);
app.use(router);
app.use(pinia);

const authStore = useAuthStore();
window.authStore = authStore;
const storedToken = localStorage.getItem('token');
if (storedToken) {
    authStore.setToken(storedToken);
}
document.addEventListener('DOMContentLoaded', () => {
    const todoElement = document.getElementById('app');
    if (todoElement) {
        app.mount('#app');
    }
});
