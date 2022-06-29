<template>
  <VContainer class="mb-8">
    <div class="hidden sm:block">
      <ol role="list" class="flex items-center space-x-4">
        <li>
          <div>
            <Link href="/" class="text-gray-400 hover:text-gray-500">
              <!-- Heroicon name: solid/home -->
              <svg class="flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
              </svg>
              <span class="sr-only">Home</span>
            </Link>
          </div>
        </li>
        <li v-for="item in $page.props.breadcrumbs">
          <div class="flex items-center">
            <svg class="flex-shrink-0 h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
              <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
            </svg>
            <Link :href="item.url" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-200">{{ item.title }}</Link>
          </div>
        </li>
      </ol>
    </div>
  </VContainer>

  <VPageHeader>
    <VFormList :options="views" v-slot="{ item }" @change="updateCurrentView">
      <ViewBoardsIcon class="h-6 w-6 mr-2" />
      <span>{{ item.title }}</span>
    </VFormList>
  </VPageHeader>

  <div class="mt-8" :key="currentView">
    <component :is="currentView.component" :project="project"></component>
  </div>
</template>

<script lang="ts">
import GuestLayout from '@/layouts/GuestLayout.vue';
import useViews from './useViews';
import { ViewBoardsIcon } from '@heroicons/vue/outline';

export default {
  layout: GuestLayout
}
</script>

<script setup lang="ts">
let props = defineProps<{
  title: String;
  breadcrumbs: Breadcrumb[];
  project: Project;
}>();

const { currentView, views, updateCurrentView } = useViews(props.project);
</script>
