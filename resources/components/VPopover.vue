<template>
  <Popover v-slot="{ open }">
    <slot></slot>
  </Popover>
</template>

<script setup lang="ts">
  import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue'
</script>
