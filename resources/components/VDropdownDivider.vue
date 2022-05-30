<template>
    <div class="px-2">
      <span v-if="title" class="mt-4 mb-2 block text-xs text-gray-400">{{ title }}</span>
      <span v-else class="my-2 border-b-2 block w-full border-gray-100 dark:border-gray-700"></span>
    </div>
</template>

<script lang="ts" setup>
defineProps({
  title: {
    type: String,
    default: null,
  }
})
</script>
