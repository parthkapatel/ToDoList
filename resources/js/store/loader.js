import { defineStore } from 'pinia';
export const useLoaderStore = defineStore('loader', {
    state: () => ({
        loading: false,
    }),
    actions: {
        showLoader() {
            this.loading = true;
        },
        hideLoader() {
            this.loading = false;
        },
    }
});
