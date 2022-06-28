<template>
  <div class="h-full">
    <VPageHeader>
      <VBreadcrumb>
        <VBreadcrumbItem v-for="breadcrumb in breadcrumbs" :href="breadcrumb.url">
          {{ breadcrumb.title }}
        </VBreadcrumbItem>
      </VBreadcrumb>
      <div class="flex items-end justify-between">
        <div>
          <VPageTitle>{{ title }}</VPageTitle>
          <VText>
            {{ project.description }}
          </VText>
        </div>
        <div>
          <VFormList
            :options="views"
            :selected="views.find(v => v.id == currentView.id)"
            @change="updateCurrentView"
          >
            <template #trigger="{ item }">
              <ViewBoardsIcon  class="h-5 w-5 mr-1"/>
              <span>{{ item.title ?? item.name }}</span>
            </template>
          </VFormList>
        </div>
      </div>
    </VPageHeader>
    <div :key="currentView">
      <component :is="currentView.component" :project="project"></component>
    </div>
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
