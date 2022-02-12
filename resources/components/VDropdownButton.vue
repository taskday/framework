<template>
  <MenuButton data-dropdown-button>
    <slot></slot>
  </MenuButton>
</template>

<script setup lang="ts">
import { MenuButton } from '@headlessui/vue';
</script>
