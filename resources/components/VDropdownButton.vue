<template>
  <MenuButton data-dropdown-button class="button button-secondary">
      <slot></slot>
  </MenuButton>
</template>

<script setup lang="ts">
import { MenuButton } from '@headlessui/vue';
</script>
