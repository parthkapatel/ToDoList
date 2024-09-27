<template>
    <div>
        <TasksList :categories="categories" :tasks="tasks"></TasksList>
    </div>
</template>

<script>
import {useTaskStore} from '../store/tasksStore.js';
import {useCategoryStore} from '../store/categoryStore.js';
import App from './layout/app.vue';
import TasksList from "./Task/TasksList.vue";

export default {
    components: {TasksList, App},
    computed: {
        tasks() {
            return this.taskStore.tasks;
        },
        categories() {
            return this.categoryStore.categories;
        },
    },
    methods: {
        //
    },
    created() {
        this.taskStore = useTaskStore();
        this.categoryStore = useCategoryStore();
        this.taskStore.fetchTasks();
        this.categoryStore.fetchCategories();
    }
};
</script>
