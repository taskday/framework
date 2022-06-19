<template>
  <Tab as="div" v-slot="{ selected }" class="h-8 flex items-center px-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-blue-600 dark:hover:text-blue-200">
    <button
      :class="[
        'text-sm border-transparent border-b-2 leading-5 font-medium pb-px text-gray-700 inline-flex w-auto',
        'focus:outline-none ring-blue-500 ring-opacity-60',
        selected
          ? 'text-blue-600 dark:text-blue-300 border-blue-600'
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
