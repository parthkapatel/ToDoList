<template>
    <div class="max-w-6xl mx-auto mt-8">
        <div class="flex-column justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Tasks Progress</h1>
            <div class="py-2">
                <div class="relative w-full bg-gray-200 rounded-full h-6 dark:bg-gray-700">
                    <div
                        class="bg-blue-600 h-6 rounded-full"
                        :style="{ width: completedPercentage + '%' }"
                    ></div>

                    <div class="absolute inset-0 flex items-center justify-center">
                <span
                    :class="completedPercentage > 0 ? 'text-white' : 'text-gray-700'"
                    class="text-sm font-semibold"
                >
                    {{ completedPercentage }}%
                </span>
                    </div>
                </div>
            </div>
        </div>


        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Tasks</h1>
            <div class="">
                <select v-model="selectedCategory" class="border mx-2 p-2 rounded-lg text-gray-700">
                    <option value="">All Categories</option>
                    <option v-for="category in categories" :key="category.id" :value="category.name">{{
                            category.name
                        }}
                    </option>
                </select>
                <button @click="createTask" class="bg-blue-500 mx-2 text-white p-2 rounded">Create Task</button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" v-if="filteredTasks.length">
            <div
                v-for="task in filteredTasks"
                :key="task.id"
                class="bg-white shadow-md rounded-lg overflow-hidden"
            >
                <div class="p-4">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">{{ task.title }}</h2>

                    <p class="text-sm text-gray-600">
                        <span class="font-semibold">Due Date:</span> {{ formatDate(task.due_date) }}
                    </p>

                    <p class="text-sm text-gray-600">
                        <span class="font-semibold">Category:</span>
                        {{ (task.category != null) ? task.category.name : '-' }}
                    </p>

                    <p class="text-sm text-gray-600 mb-2">
                        <span class="font-semibold">Description:</span>
                        <span v-if="task.showFullDescription">{{ task.description }}</span>
                        <span v-else>{{ truncateDescription(task.description) }}</span>
                    </p>

                    <div class="flex items-center mt-4">
                        <span class="mr-2 font-semibold">Status: {{
                                task.status === 'Completed' ? 'Completed' : 'Pending'
                            }}</span>
                        <label class="inline-flex items-center cursor-pointer">
                            <input
                                type="checkbox"
                                class="sr-only peer"
                                :checked="task.status === 'Completed'"
                                @change="toggleTaskCompletion(task)"
                            />
                            <div
                                :class="['w-12 h-6 rounded-full shadow-inner transition-colors duration-300',task.status === 'Completed' ? 'bg-blue-600' : 'bg-gray-200']"
                            >
                                <div
                                    class="w-6 h-6 bg-white rounded-full shadow-md transform transition-transform duration-300 ease-in-out"
                                    :class="{ 'translate-x-6': task.status === 'Completed' }"
                                ></div>
                            </div>
                        </label>
                    </div>


                    <div :class="task.description.length < 50 ? 'mt-8' : 'mt-4'"
                         class="flex justify-between items-center">
                        <div class="flex-1">
                            <button
                                v-if="task.description.length > 50"
                                @click="toggleDescription(task)"
                                class="text-blue-500 hover:text-blue-700 flex items-center space-x-1"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                     fill="currentColor">
                                    <path
                                        d="M10 2a8 8 0 100 16 8 8 0 000-16zM7 9a2 2 0 114 0 2 2 0 01-4 0zm2 4a6 6 0 004.472-2.388A4.992 4.992 0 0110 15a4.992 4.992 0 01-4.472-2.388A6 6 0 009 13z"/>
                                </svg>
                                <span v-if="task.showFullDescription">Hide</span>
                                <span v-else>View</span>
                            </button>
                        </div>

                        <div class="flex space-x-4">
                            <button
                                @click="editTask(task.id)"
                                class="text-red-500 hover:text-red-700 mx-2"
                            >
                                <i class="fa fa-pencil-square-o fa-lg text-blue-500"></i>
                            </button>

                            <button
                                @click="deleteTask(task.id)"
                                class="text-red-500 hover:text-red-700 mx-2"
                            >
                                <i class="fa fa-trash-o fa-lg" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center" v-else>
            No Tasks Found
        </div>
    </div>
</template>

<script>
import {useTaskStore} from "../../store/tasksStore.js";

export default {
    props: {
        tasks: {
            type: Array,
            required: true,
        },
        categories: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            selectedCategory: '',
            taskStore: useTaskStore()
        };
    },
    computed: {
        filteredTasks() {
            if (this.selectedCategory) {
                return this.tasks.filter(
                    (task) => task.category != null && task.category.name === this.selectedCategory
                );
            }
            return this.tasks;
        },
        completedPercentage() {
            if (this.filteredTasks.length === 0) return 0;

            const completedTasks = this.filteredTasks.filter(task => task.status == 'Completed');
            return Math.round((completedTasks.length / this.filteredTasks.length) * 100);
        },
    },
    methods: {
        async toggleTaskCompletion(task) {
            const newStatus = task.status === 'Completed' ? 'Pending' : 'Completed';
            await this.taskStore.updateTaskStatus(newStatus, task.id);
        },
        formatDate(dueDate) {
            if (!dueDate) return '';

            const date = new Date(dueDate);
            return date.toLocaleDateString('en-GB');
        },
        truncateDescription(description) {
            if (description.length > 50) {
                return description.substring(0, 50) + '...';
            }
            return description;
        },
        toggleDescription(task) {
            task.showFullDescription = !task.showFullDescription;
        },
        createTask() {
            this.$emit('create-task');
        },
        editTask(id) {
            this.$emit('edit-task', id);
        },
        async deleteTask(taskId) {
            await this.taskStore.removeTask(taskId);
            this.tasks = this.taskStore.tasks;
        },
    }
};
</script>

<style scoped>

</style>
