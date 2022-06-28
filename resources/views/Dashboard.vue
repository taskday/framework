<template>
  <div></div>
</template>

<script setup lang="ts">
import { computed } from 'vue';

let props = defineProps<{ title: string, widgets: Object }>()

const widgetViews = computed(() => {
  return Object.keys(taskday.widgets).map(key => ({
    ...props.widgets[key],
    component: taskday.widgets[key]
  }))
})
</script>


