<template>
    <div>
        <Loader :isLoading="isLoading" class="z-50" />
        <router-view></router-view>
    </div>
</template>

<script>
import { useLoaderStore } from '../../store/loader.js';
import Loader from './Loader.vue';
import { computed } from 'vue';
export default {
    components: {
        Loader,
    },
    setup() {
        const loaderStore = useLoaderStore();
        const isLoading = computed(() => loaderStore.loading);
        return { isLoading };
    },
};
</script>

<style scoped>

</style>
