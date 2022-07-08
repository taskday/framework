<template>
  <div ref="dropdown" class="h-9">
    <Menu v-slot="{ open }" as="div" class="flex items-center h-full text-left w-full">
      <slot :open="open" />
    </Menu>
  </div>
</template>

<script setup lang="ts">
import { Menu } from '@headlessui/vue';
import { provide } from 'vue';
import { ref } from 'vue';
const dropdown = ref(null);
provide('dropdown', dropdown)
</script>
