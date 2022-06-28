<template>
    <div class="px-2">
      <span v-if="title" class="mt-4 mb-2 block text-xs text-gray-400">{{ title }}</span>
      <span v-else class="h-px my-2 block w-full background-300"></span>
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
