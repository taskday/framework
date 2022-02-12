<template>
  <div
    class="flex flex-col items-center min-h-screen px-4 pt-40 bg-gray-50 dark:bg-gray-900 sm:px-6 lg:px-8"
  >
    <div class="mb-6">
      <div class="text-lg font-bold text-center text-blue-600 dark:text-blue-300">Task Day</div>
      <h2 class="text-xl font-extrabold text-center text-gray-900">{{ title }}</h2>
    </div>
    <div class="w-full max-w-md p-8 space-y-8 bg-white rounded shadow dark:bg-gray-800">
      <p class="text-sm text-red-600" v-if="message">{{ message }}</p>
      <div class="space-y-6">
        <slot></slot>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  props: ["message", 'title']
});
</script>

<style></style>
