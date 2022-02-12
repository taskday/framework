<template>
  <div>
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
      <div class="md:col-span-4">
        <div class="px-4 sm:px-0">
          <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-200">
            <slot name="title"></slot>
          </h3>
          <p v-if="$slots.description" class="mt-1 text-sm text-gray-600 dark:text-gray-300">
            <slot name="description"></slot>
          </p>
        </div>
      </div>
      <div class="md:col-span-8">
        <form @submit.prevent="$emit('submitted')" method="POST">
          <div class="shadow sm:rounded-md sm:overflow-hidden">
            <div class="px-4 py-5 bg-white dark:bg-gray-800 space-y-6 sm:p-6">
              <slot name="content"></slot>
            </div>
            <div
              v-if="$slots.actions"
              class="px-4 py-3 bg-gray-50 dark:bg-gray-700 text-right flex items-center"
            >
              <slot name="actions"></slot>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
defineEmits(['submitted'])
</script>
