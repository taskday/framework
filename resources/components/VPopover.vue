<template>
  <Popover v-slot="{ open }">
    <PopoverButton class="button button-secondary">
      <slot name="button"></slot>
    </PopoverButton>

    <VPopoverPanel>
      <slot name="content"></slot>
    </VPopoverPanel>
  </Popover>
</template>

<script setup lang="ts">
  import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue'


</script>
