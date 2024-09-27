<template>
    <div class="max-w-6xl mx-auto mt-8">
        <!-- Table Header: Title and Create Category Button -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Categories</h1>
            <button
                @click="openCreateCategoryForm"
                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
            >
                Create Category
            </button>
        </div>

        <!-- Category Table -->
        <table class="min-w-full bg-white rounded-lg shadow-md">
            <thead class="bg-gray-200 text-gray-600">
            <tr>
                <th class="py-3 px-6 text-left">Category Name</th>
                <th class="py-3 px-6 text-left">Assigned Task</th>
                <th class="py-3 px-6 text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr
                v-for="category in categories"
                :key="category.id"
                class="border-t hover:bg-gray-100"
            >
                <td class="py-3 px-6 text-left">{{ category.name }}</td>
                <td class="py-3 px-6 text-left">{{ category.tasks_count || 0 }}</td>
                <td class="py-3 px-6 text-center">

                    <button
                        @click="editCategory(category.id)"
                        class="text-red-500 hover:text-red-700 mx-2"
                    >
                        <i class="fa fa-pencil-square-o fa-lg text-blue-500"></i>
                    </button>

                    <button
                        @click="deleteCategory(category.id)"
                        class="text-red-500 hover:text-red-700 mx-2"
                    >
                        <i class="fa fa-trash-o fa-lg" aria-hidden="true"></i>
                    </button>
                </td>
            </tr>

            <!-- Show this if there are no categories -->
            <tr v-if="categories == null || Object.keys(categories).length === 0">
                <td colspan="3" class="py-4 px-6 text-center text-gray-500">
                    No categories found.
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import {useCategoryStore} from "../../store/categoryStore.js";
export default {
    data(){
        return {
            categories:{},
            categoryStore: useCategoryStore()
        }
    },
    methods: {
        openCreateCategoryForm() {
            this.$emit('open-create-category-form');
        },
        editCategory(categoryId) {
            this.$emit('edit-category', categoryId);
        },
        async deleteCategory(categoryId) {
            await this.categoryStore.removeCategory(categoryId);
            this.categories = this.categoryStore.categories;
        },
    },
    async created() {
        await this.categoryStore.fetchCategories();
        this.categories = this.categoryStore.categories;
    }
};
</script>

<style scoped>

</style>
