<template>
    <transition name="fade">
        <div v-if="show" class="fixed top-6 right-6 z-50 px-4 py-3 rounded-lg shadow-lg text-white"
            :class="type === 'success' ? 'bg-green-600' : 'bg-red-600'">
            {{ message }}
        </div>
    </transition>
</template>

<script setup>
defineProps({
    show: Boolean,
    message: String,
    type: {
        type: String,
        default: "success",
    },
});
</script>

<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
