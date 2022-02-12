<template>
  <TabPanels class="mt-2 h-full flex-grow">
    <slot/>
  </TabPanels>
</template>

<script setup lang="ts">
import { TabPanels } from '@headlessui/vue';
</script>
