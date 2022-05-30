<template>
  <div class="px-6 bg-white dark:bg-gray-800 shadow z-10">
    <TabList class="flex gap-4">
      <slot />
    </TabList>
  </div>
</template>

<script setup lang="ts">
import { TabList } from '@headlessui/vue'
</script>
