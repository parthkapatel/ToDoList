<template>
    <CreateTask :is-open="isTaskFormOpen" :categories="categories" @close-model="closeTaskForm"/>
    <EditTask :is-open="isEditOpen" :task="task" :categories="categories" @close-model="closeEditTaskForm" />
    <TasksList :tasks="tasks" :categories="categories" @create-task="openTaskForm" @edit-task="editTask" />
</template>

<script>

import CreateTask from "./CreateTask.vue";
import TasksList from "./TasksList.vue";
import EditTask from "./EditTask.vue";
import {useTaskStore} from "../../store/tasksStore.js";
import {useCategoryStore} from "../../store/categoryStore.js";

export default {
    components: {
        TasksList,
        CreateTask,
        EditTask,
    },
    data() {
        return {
            isTaskFormOpen:false,
            isEditOpen:false,
            task_id:null,
            task: {},
            taskStore: useTaskStore(),
            categoryStore: useCategoryStore()
        };
    },
    computed: {
        tasks() {
            return this.taskStore.tasks;
        },
        categories() {
            return this.categoryStore.categories;
        },
    },
    methods: {
        openTaskForm(){
            this.isTaskFormOpen = true;
        },
        closeEditTaskForm(){
            this.isEditOpen = false;
        },
        closeTaskForm(){
            this.isTaskFormOpen = false;
        },
        async editTask(id){
            this.task_id = id;
            if(id != null){
                await this.taskStore.fetchTask(id);
                if(this.taskStore.task != null){
                    this.task = this.taskStore.task;
                    this.isEditOpen = true;
                }
            }
        },
    },
    async created() {
        await this.taskStore.fetchTasks();
        await this.categoryStore.fetchCategories();
    }
};
</script>


<style scoped>

</style>
