// resources/js/router/index.js
import { createRouter, createWebHistory } from 'vue-router';
import TodoApp from "../components/TodoApp.vue";
import CreateTask from "../components/Task/CreateTask.vue";
import CreateCategory from "../components/Category/CreateCategory.vue";
import CategoryList from "../components/Category/Categories.vue";
import Categories from "../components/Category/Categories.vue";
import Tasks from "../components/Task/Tasks.vue";

const routes = [
    {
        path: '/',
        name: 'Tasks',
        component: Tasks,
    },
    {
        path: '/categories',
        name: 'Categories',
        component: Categories,
    },
    {
        path: '/create-category',
        name: 'CreateTask',
        component: CreateCategory,
    },
    {
        path: '/edit-category/{}',
        name: 'CreateTask',
        component: CreateCategory,
    },
    {
        path: '/create-task',
        name: 'CreateTask',
        component: CreateTask,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
