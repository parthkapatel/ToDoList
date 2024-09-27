<!-- resources/js/components/Loader.vue -->
<template>
    <div id="loader" class="z-50 fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50" v-if="isLoading">
        <div class="loader border-t-4 border-b-4 border-blue-500 rounded-full w-16 h-16 animate-spin"></div>
    </div>
</template>

<script>
export default {
    props: {
        isLoading: {
            type: Boolean,
            default: false,
        },
    },
};
</script>

<style scoped>
.loader {
    border-left-color: transparent;
    border-right-color: transparent;
}
</style>
