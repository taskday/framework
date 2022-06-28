<template>
  <VCard>
    <div class="mb-6">
      <div class="px-4 sm:px-0">
        <h3 class="text-lg leading-6 font-medium">
          <slot name="title"></slot>
        </h3>
        <p v-if="$slots.description" class="opacity-80 mt-1">
          <slot name="description"></slot>
        </p>
      </div>
    </div>
    <form @submit.prevent="$emit('submitted')" method="POST" class="space-y-4">
      <slot name="content"></slot>
    </form>
    <template #footer>
      <form @submit.prevent="$emit('submitted')" method="POST" class="flex items-center gap-4">
        <slot name="actions"></slot>
      </form>
    </template>
  </VCard>
</template>

<script setup lang="ts">
defineEmits(['submitted'])
</script>
