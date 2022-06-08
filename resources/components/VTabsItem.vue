<template>
  <Tab as="template" v-slot="{ selected }">
    <button
      :class="[
        'h-8 text-sm leading-5 font-medium text-gray-700 rounded-sm',
        'focus:outline-none ring-blue-500 ring-opacity-60',
        selected
          ? 'text-blue-600 dark:text-blue-300 border-b-2 border-blue-600 rounded'
          : 'text-gray-900 dark:text-gray-300',
      ]"
    >
      <slot />
    </button>
  </Tab>
</template>

<script setup lang="ts">
import { Tab } from '@headlessui/vue'
</script>
