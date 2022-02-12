<template>
  <TabPanel class="mt-2 h-full flex-grow">
    <slot/>
  </TabPanel>
</template>

<script setup lang="ts">
import { TabPanel } from '@headlessui/vue';
</script>
