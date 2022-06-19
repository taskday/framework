<template>
  <div>
    <VPageHeader>
      <VPageTitle>{{ title }}</VPageTitle>
    </VPageHeader>
    <div class="grid md:grid-cols-2 gap-8 py-4 px-6">
      <VWidget v-for="widget in widgetViews" class="space-y-2">
        <h2 class="font-bold text-xl text-gray-800 dark:text-gray-200 mb-1">{{ widget.title }}</h2>
        <component v-bind="widget.props" :is="widget.component"></component>
      </VWidget>
    </div>
  </div>
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


