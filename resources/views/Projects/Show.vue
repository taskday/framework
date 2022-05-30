<template>
  <div class="h-full">
    <VPageHeader class="shadow-none px-6">
      <VBreadcrumb>
        <VBreadcrumbItem v-for="breadcrumb in breadcrumbs" :href="breadcrumb.url">
          {{ breadcrumb.title }}
        </VBreadcrumbItem>
      </VBreadcrumb>
      <div class="flex items-end justify-between">
        <div>
          <VPageTitle>{{ title }}</VPageTitle>
          <div class="prose text-sm text-gray-700 dark:text-gray-400">
            {{ project.description }}
          </div>
        </div>
        <div>
          <VButton variant="secondary" :href="route('projects.edit', project)">
            <CogIcon class="h-5 w-5" />
          </VButton>
        </div>
      </div>
    </VPageHeader>
    <div class="h-full">
      <VTabs>
        <VTabsList>
          <VTabsItem v-for="view in taskday().views" :key="view.name">{{ view.name }}</VTabsItem>
        </VTabsList>
        <VTabsPanels class="h-full">
          <VTabsPanel class="h-full pt-6" v-for="view in taskday().views" :key="view.name">
            <component :is="view.component" :project="project"></component>
          </VTabsPanel>
        </VTabsPanels>
      </VTabs>
    </div>
  </div>
</template>

<script setup lang="ts">
import { CogIcon } from "@heroicons/vue/outline";

const props = defineProps<{
  title: String;
  breadcrumbs: Breadcrumb[];
  project: Project;
}>();
</script>
