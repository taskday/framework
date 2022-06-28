<template>
  <PopoverButton class="button button-secondary">
    <slot></slot>
  </PopoverButton>
</template>

<script setup lang="ts">
  import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue'
</script>
