<script setup lang="ts">
import { PropType } from "vue";

defineProps({
  items: {
    type: Array as PropType<
      {
        title: String;
        url: String;
      }[]
    >,
    required: true,
  },
});
</script>

<template>
  <VBreadcrumb>
    <VBreadcrumbItem v-for="breadcrumb in items" :href="breadcrumb.url">
      {{ breadcrumb.title }}
    </VBreadcrumbItem>
  </VBreadcrumb>
</template>
