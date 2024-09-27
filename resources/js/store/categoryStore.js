import { defineStore } from 'pinia';
import axios from 'axios';
import { useAuthStore } from './auth';
import {useLoaderStore} from "./loader.js";
export const useCategoryStore = defineStore('categories', {
    state: () => ({
        categories: {},
        category: null,
        loading: false,
        error: null,
        loaderStore: useLoaderStore()
    }),
    actions: {
        async fetchCategories() {
            const authStore = useAuthStore();
            if (authStore.isAuthenticated) {
                this.loaderStore.showLoader();
                try {
                    const response = await axios.get('/api/categories');
                    this.categories = response.data.data;
                } catch (error) {
                    this.error = error.response?.data.message || 'Error fetching categories';
                    errorToast(this.error);
                } finally {
                    this.loaderStore.hideLoader();
                }
            }else{
                errorToast("Error fetching categories")
            }
        },
        async fetchCategory(id) {
            const authStore = useAuthStore();
            if (authStore.isAuthenticated) {
                this.loaderStore.showLoader();
                try {
                    const response = await axios.get(`/api/categories/${id}`);
                    this.category = response.data.data;
                } catch (error) {
                    this.error = error.response?.data.message || 'Error fetching category';
                    errorToast(this.error);
                } finally {
                    this.loaderStore.hideLoader();
                }
            }else{
                errorToast("Error fetching category")
            }
        },
        async addCategory(category_name) {
            const authStore = useAuthStore();
            if (authStore.isAuthenticated) {
                this.loaderStore.showLoader();
                try {
                    const newCategory = {
                        name: category_name,
                    };
                    const response = await axios.post('/api/categories', newCategory);
                    this.loaderStore.hideLoader();
                    if(response.data.success){
                        this.categories.push(response.data.data);
                        this.error = null;
                        successToast(response.data.message || "Category created successfully");
                    }
                } catch (error) {
                    this.loaderStore.hideLoader();
                    if (error.response && error.response.status === 422) {
                        this.error = error.response.data.errors;
                    } else {
                        this.error = error.response?.data.message || 'Error adding categories';
                        errorToast(this.error);
                    }
                }
            }else{
                errorToast("Error adding categories")
            }
        },
        async updateCategory(category_name,category_id) {
            const authStore = useAuthStore();
            if (authStore.isAuthenticated) {
                this.loaderStore.showLoader();
                try {
                    const newCategory = {
                        name: category_name,
                    };
                    const response = await axios.put(`/api/categories/${category_id}`, newCategory);
                    this.loaderStore.hideLoader();
                    if(response.data.success){
                        this.error = null;
                        const categoryIndex = this.categories.findIndex(category => category.id === category_id);
                        if (categoryIndex !== -1) {
                            this.categories[categoryIndex].name = response.data.data.name; // Update other fields as needed
                        }else{
                            await this.fetchCategories();
                        }
                        successToast(response.data.message || "Category updated successfully");
                    }else{
                        errorToast(response.data.message);
                    }
                } catch (error) {
                    this.loaderStore.hideLoader();
                    if (error.response && error.response.status === 422) {
                        this.error = error.response.data.errors;
                    } else {
                        this.error = error.response?.data.message || 'Error updating categories';
                        errorToast(this.error);
                    }
                }
            }else{
                errorToast("Error updating categories")
            }
        },
        async removeCategory(id) {
            const authStore = useAuthStore();
            if (authStore.isAuthenticated) {
                this.loaderStore.showLoader();
                try {
                    const response = await axios.delete(`/api/categories/${id}`);
                    this.loaderStore.hideLoader();
                    if (response.data.success) {
                        this.categories = this.categories.filter(categories => categories.id !== id);
                        successToast(response.data.message || "Category deleted successfully");
                    }else{
                        errorToast(response.data.message);
                    }

                } catch (error) {
                    this.loaderStore.hideLoader();
                    this.error = error.response?.data.message || 'Error removing categories';
                    errorToast(this.error);
                }
            }else{
                errorToast("Error removing categories")
            }
        }
    }
});
