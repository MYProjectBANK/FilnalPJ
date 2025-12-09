<template>
    <div :class="['p-6 rounded-lg shadow text-white', bgColor]">
        <h2 class="text-lg opacity-90">{{ title }}</h2>
        <p class="text-3xl font-bold mt-2">{{ value }}</p>
    </div>
</template>

<script setup>
const props = defineProps({
    title: String,
    value: Number,
    color: String
});

const bgColor = {
    blue: "bg-blue-600",
    green: "bg-green-600",
    yellow: "bg-yellow-500",
    purple: "bg-purple-600",
    teal: "bg-teal-600",
    pink: "bg-pink-600",
    red: "bg-red-600",
    indigo: "bg-indigo-600"
}[props.color];
</script>
