<template>
  <VContainer class="bg-white dark:bg-gray-800 shadow z-10">
    <TabList class="flex">
      <slot />
    </TabList>
  </VContainer>
</template>

<script setup lang="ts">
import { TabList } from '@headlessui/vue'
</script>
