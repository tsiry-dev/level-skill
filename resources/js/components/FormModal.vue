<script setup>


const props = defineProps({
    title: String,
    isActive: Boolean,
});

const emit = defineEmits(['closeModalForm']);

const closeModal = () => {
    emit('closeModalForm');
}

</script>

<template>
    <div
     v-if="isActive"
     :class="`${isActive ? 'anime' : ''} bg-green-100 border-1 border-gray-300 rounded-md p-5 fixed top-[5rem] left-[50%] translate-x-[-50%] z-100 w-[40rem]`">
        <div class="flex justify-between">
            <h2>{{ title }}</h2>
            <button
            @click="closeModal"
            class="btn btn-error">
            <i class="pi pi-times-circle"></i>
        </button>
        </div>

        <slot />
    </div>
</template>

<style scoped>
</style>
