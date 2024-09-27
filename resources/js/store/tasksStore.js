import { defineStore } from 'pinia';
import axios from 'axios';
import { useAuthStore } from './auth';
import {useLoaderStore} from "./loader.js";
export const useTaskStore = defineStore('task', {
    state: () => ({
        tasks: [],
        task: null,
        loading: false,
        error: null,
        loaderStore: useLoaderStore(),
        authStore: useAuthStore()
    }),
    actions: {
        async fetchTasks() {
            if (this.authStore.isAuthenticated) {
                this.loaderStore.showLoader();
                try {
                    const response = await axios.get('/api/tasks');
                    this.tasks = response.data;
                } catch (error) {
                    this.error = error.response?.data.message || 'Error fetching tasks';
                    errorToast(this.error);
                } finally {
                    this.loaderStore.hideLoader();
                }
            }else{
                errorToast("Error fetching tasks")
            }
        },
        async fetchTask(id) {
            if (this.authStore.isAuthenticated) {
                this.loaderStore.showLoader();
                try {
                    const response = await axios.get(`/api/tasks/${id}`);
                    this.task = response.data.data;
                } catch (error) {
                    this.error = error.response?.data.message || 'Error fetching task';
                    errorToast(this.error);
                } finally {
                    this.loaderStore.hideLoader();
                }
            }else{
                errorToast("Error fetching task")
            }
        },
        async addTask(newTask) {
            if (this.authStore.isAuthenticated) {
                try {
                    const response = await axios.post('/api/tasks', newTask);
                    if (response.data.success) {
                        this.tasks.push(response.data.data);
                        this.error = null;
                        successToast(response.data.message || "Task created successfully");
                    }else{
                        errorToast(response.data.message);
                    }
                } catch (error) {
                    this.loaderStore.hideLoader();
                    if (error.response && error.response.status === 422) {
                        this.error = error.response.data.errors;
                    } else {
                        this.error = error.response?.data.message || 'Error adding task';
                        errorToast(this.error);
                    }
                }
            }else{
                errorToast("Error adding task");
            }
        },
        async updateTask(task,id) {
            if (this.authStore.isAuthenticated) {
                this.loaderStore.showLoader();
                try {
                    const response = await axios.put(`/api/tasks/${id}`, task);
                    this.loaderStore.hideLoader();
                    if(response.data.success){
                        this.error = null;
                        const taskIndex = this.tasks.findIndex(task => task.id === id);
                        if (taskIndex !== -1) {
                            this.tasks[taskIndex] = response.data.data;
                        }else{
                            await this.fetchTasks();
                        }
                        successToast(response.data.message || "Task updated successfully");
                    }else{
                        errorToast(response.data.message);
                    }
                } catch (error) {
                    this.loaderStore.hideLoader();
                    if (error.response && error.response.status === 422) {
                        this.error = error.response.data.errors;
                    } else {
                        this.error = error.response?.data.message || 'Error updating task';
                        errorToast(this.error);
                    }
                }
            }else{
                errorToast("Error updating task")
            }
        },
        async updateTaskStatus(status,id) {
            if (this.authStore.isAuthenticated) {
                this.loaderStore.showLoader();
                try {
                    let data = {
                        status : status
                    }
                    const response = await axios.post(`/api/tasks/${id}/updateTaskStatus`, data);
                    this.loaderStore.hideLoader();
                    if(response.data.success){
                        this.error = null;
                        const taskIndex = this.tasks.findIndex(task => task.id === id);
                        if (taskIndex !== -1) {
                            this.tasks[taskIndex] = response.data.data;
                        }else{
                            await this.fetchTasks();
                        }
                        successToast(response.data.message || "Task status updated successfully");
                    }else{
                        errorToast(response.data.message);
                    }
                } catch (error) {
                    this.loaderStore.hideLoader();
                    if (error.response && error.response.status === 422) {
                        this.error = error.response.data.errors;
                    } else {
                        this.error = error.response?.data.message || 'Error updating task';
                        errorToast(this.error);
                    }
                }
            }else{
                errorToast("Error updating task")
            }
        },
        async removeTask(id) {
            if (this.authStore.isAuthenticated) {
                this.loaderStore.showLoader();
                try {
                    const response = await axios.delete(`/api/tasks/${id}`);
                    this.loaderStore.hideLoader();
                    if (response.data.success) {
                        this.tasks = this.tasks.filter(task => task.id !== id);
                        successToast(response.data.message || "Task deleted successfully");
                    }else{
                        errorToast(response.data.message);
                    }
                } catch (error) {
                    this.loaderStore.hideLoader();
                    this.error = error.response?.data.message || 'Error removing task';
                    errorToast(this.error);
                }
            }else{
                errorToast("Error removing task")
            }
        }
    }
});
