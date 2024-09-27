<template>
    <div>
        <CreateCategory :is-open="isCategoryFormOpen" @close-model="closeCategoryForm"/>
        <EditCategory :is-edit-open="isEditOpen" :category="category" @close-model="closeEditCategoryForm" />
        <CategoryList @open-create-category-form="openCategoryForm" @edit-category="editCategory"/>
    </div>
</template>

<script>
import CreateCategory from "./CreateCategory.vue";
import CategoryList from "./CategoryList.vue";
import EditCategory from "./EditCategory.vue";
import {useCategoryStore} from "../../store/categoryStore.js";
export default {
    components: {
        EditCategory,
        CreateCategory,
        CategoryList,
    },
    data() {
        return {
            isCategoryFormOpen:false,
            isEditOpen:false,
            category_id:null,
            category:null,
            categoryStore: useCategoryStore()
        };
    },
    methods: {
        openCategoryForm(){
            this.isCategoryFormOpen = true;
        },
        closeEditCategoryForm(){
            this.isEditOpen = false;
        },
        closeCategoryForm(){
            this.isCategoryFormOpen = false;
        },
        async editCategory(id){
            this.category_id = id;
            if(id != null){
                await this.categoryStore.fetchCategory(id);
                if(this.categoryStore.category != null){
                    this.category = this.categoryStore.category;
                    this.isEditOpen = true;
                }
            }
        }
    }
};
</script>
