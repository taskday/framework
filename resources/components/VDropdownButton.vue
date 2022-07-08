<template>
  <MenuButton data-dropdown-button class="button button-secondary w-full">
      <slot></slot>
  </MenuButton>
</template>

<script setup lang="ts">
import { MenuButton } from '@headlessui/vue';
</script>
