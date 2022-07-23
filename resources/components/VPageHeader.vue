<script setup lang="ts">
import { PropType } from 'vue';

defineProps({
  title: [String],
  features: {
    type: Array as PropType<{ title: string, icon: string }[]>,
    default: []
  }
})
</script>

<template>
  <header>
    <VContainer class="grid grid-cols-1 lg:grid-cols-2 gap-4">
      <div class="flex-1 min-w-0 order-1 lg:order-none">
        <h1 v-if="!$slots.title" class="text-2xl font-bold leading-7 sm:truncate">{{ $page.props.title ?? title }}</h1>
        <slot name="title"></slot>
        <div v-if="features.length > 0" class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-8">
          <div v-for="feature in features" class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-300">
            <VIcon :name="feature.icon"></VIcon>
            <span>{{ feature.title }}</span>
          </div>
        </div>
      </div>
      <div class="flex flex-wrap lg:justify-end gap-2 xl:mt-0 xl:ml-4">
        <slot></slot>
      </div>
    </VContainer>
  </header>
</template>
