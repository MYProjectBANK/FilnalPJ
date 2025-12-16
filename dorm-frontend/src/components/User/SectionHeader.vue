<template>
  <div class="flex justify-between items-center my-6">
    <h2 class="text-xl font-bold">{{ title }}</h2>

    <button
      v-if="showMore"
      @click="goTo"
      class="text-blue-600 hover:underline text-sm font-medium"
    >
      ดูทั้งหมด →
    </button>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router';

const props = defineProps({
  title: String,
  showMore: {
    type: Boolean,
    default: false,
  },
  to: {
    type: String,
    default: "",
  },
});

const router = useRouter();

const goTo = () => {
  if (props.to) {
    router.push(props.to);
  }
};
</script>
