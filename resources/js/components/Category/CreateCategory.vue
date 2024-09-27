<template>
    <div
        v-if="isOpen"
        class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50"
    >
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md mx-4">
            <h2 class="text-lg font-semibold mb-4">Create Category</h2>
            <form @submit.prevent="addCategory">
                <div class="form-group mb-2">
                    <input
                        v-model="newCategoryName"
                        type="text"
                        placeholder="Category Name"
                        class="border border-gray-300 rounded-lg p-2 w-full mb-2"
                    />
                    <span v-if="errors != null && errors.name" class="text-red-500">{{ errors.name[0] }}</span>
                </div>

                <button
                    type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
                >
                    Add Category
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
import {useCategoryStore} from "../../store/categoryStore.js";
export default {
    props: {
        isOpen:false
    },
    computed:{
        errors(){
            return this.categoryStore.error;
        }
    },
    data() {
        return {
            newCategoryName: '',
            categoryStore: useCategoryStore()
        };
    },
    methods: {
        async addCategory() {
            await this.categoryStore.addCategory(this.newCategoryName);
            this.newCategoryName = '';
            if (this.errors == null){
                this.closeModel();
            }
        },
        resetForm() {
            Object.assign(this.$data, this.$options.data.call(this));
        },
        closeModel(){
            this.categoryStore.error = null;
            this.resetForm();
            this.$emit('close-model');
        }
    },
};
</script>

<style scoped>
</style>
