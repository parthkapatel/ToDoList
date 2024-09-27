<template>
    <div
        v-if="isOpen"
        class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 z-40"
    >
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md mx-4">
            <h2 class="text-lg font-semibold mb-4">Edit Task</h2>
            <form @submit.prevent="updateTask">
                <div class="form-group mb-2">
                    <input
                        v-model="task.title"
                        type="text"
                        placeholder="Title"
                        class="border border-gray-300 rounded-lg p-2 w-full mb-2"
                    />
                    <span v-if="errors != null && errors.title" class="text-red-500">{{ errors.title[0] }}</span>
                </div>

                <div class="form-group mb-2">
                    <textarea
                        v-model="task.description"
                        placeholder="Description"
                        class="border border-gray-300 rounded-lg p-2 w-full mb-2"
                        rows="8"
                    ></textarea>
                    <span v-if="errors != null && errors.description" class="text-red-500">{{ errors.description[0] }}</span>
                </div>

                <div class="form-group mb-2">
                    <input
                        v-model="task.due_date"
                        type="date"
                        placeholder="Due Date"
                        :min="minDate"
                        class="border border-gray-300 rounded-lg p-2 w-full mb-2"
                    />
                    <span v-if="errors != null && errors.due_date" class="text-red-500">{{ errors.due_date[0] }}</span>
                </div>

                <div class="form-group mb-2">
                    <select
                        v-model="task.category_id"
                        class="border border-gray-300 rounded-lg p-2 w-full mb-2"
                    >
                        <option value="">Select Category</option>
                        <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                    </select>
                    <span v-if="errors != null && errors.category_id" class="text-red-500">{{ errors.category_id[0] }}</span>
                </div>

                <button
                    type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
                >
                    Update Task
                </button>
                <button
                    type="button"
                    class="text-gray-500 hover:underline mt-2 ml-2"
                    @click="closeModel"
                >
                    Cancel
                </button>
            </form>
        </div>
    </div>
</template>

<script>
import {useTaskStore} from "../../store/tasksStore.js";
export default {
    name: "EditTask",
    props: {
        isOpen: false,
        task:{
            type: Object,
            required: true,
        },
        categories: {
            type: Object,
            required: true,
        },
    },
    data(){
        return {
            taskStore: useTaskStore(),
            id: null,
            title: '',
            description: '',
            due_date: null,
            category_id:""
        }
    },
    computed:{
        errors(){
            return this.taskStore.error;
        },
        minDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0'); // Add leading zero
            const day = String(today.getDate()).padStart(2, '0'); // Add leading zero
            return `${year}-${month}-${day}`;
        },
    },
    methods: {
        async updateTask() {
            await this.taskStore.updateTask(this.task,this.task.id);
            if (this.errors == null){
                this.resetForm();
                this.closeModel();
            }
        },
        resetForm() {
            Object.assign(this.$data, this.$options.data.call(this));
        },
        closeModel(){
            this.taskStore.error = null;
            this.$emit('close-model');
        }
    }
}
</script>

<style scoped>

</style>
