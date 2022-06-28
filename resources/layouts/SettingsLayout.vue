<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue';
</script>

<template>
  <AppLayout>
    <VContainer class="max-w-7xl flex flex-col gap-8">
      <slot></slot>
    </VContainer>
  </AppLayout>
</template>
