<template>
  <div class="">
    <VPageHeader class="shadow-none">
      <VContainer>
        <VBreadcrumb>
          <VBreadcrumbItem v-for="breadcrumb in breadcrumbs" :href="breadcrumb.href">
            {{ breadcrumb.name }}
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
      </VContainer>
    </VPageHeader>
    <div class="">
      <VTabs>
        <VTabsList>
          <VTabsItem v-for="view in taskday().views" :key="view.name">{{ view.name }}</VTabsItem>
        </VTabsList>
        <VTabsPanels>
          <VTabsPanel class="pt-6 pb-10" v-for="view in taskday().views" :key="view.name">
            <component :is="view.component" :project="project"></component>
          </VTabsPanel>
        </VTabsPanels>
      </VTabs>
    </div>
  </div>
</template>

<script setup lang="ts">
import { CogIcon } from "@heroicons/vue/outline";
import VLink from "@/components/VLink.vue";

const props = defineProps<{
  title: String;
  breadcrumbs: {
    name: String;
    href: String;
  }[];
  project: Project;
}>();
</script>
