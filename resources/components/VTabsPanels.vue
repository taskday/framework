<template>
  <TabPanels class="h-full flex-grow">
    <slot/>
  </TabPanels>
</template>

<script setup lang="ts">
import { TabPanels } from '@headlessui/vue';
</script>
