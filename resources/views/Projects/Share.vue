<template>
  <div class="h-full">
    <VPageHeader class="shadow-none px-6">
      <VBreadcrumb>
        <VBreadcrumbItem v-for="breadcrumb in breadcrumbs" :href="breadcrumb.url">
          {{ breadcrumb.title }}
        </VBreadcrumbItem>
      </VBreadcrumb>
      <VPageTitle>{{ title }}</VPageTitle>
    </VPageHeader>
    <div class="h-full">
      <VTabs>
        <VTabsList>
          <VTabsItem v-for="view in taskday().views" :key="view.name">{{ view.name }}</VTabsItem>
        </VTabsList>
        <VTabsPanels class="h-full">
          <VTabsPanel class="h-full pt-6" v-for="view in taskday().views" :key="view.name">
            <component :is="view.component" :project="project" :readonly="true"></component>
          </VTabsPanel>
        </VTabsPanels>
      </VTabs>
    </div>
  </div>
</template>

<script lang="ts">
import GuestLayout from '@/layouts/GuestLayout.vue';

export default {
  layout: GuestLayout
}
</script>

<script setup lang="ts">
defineProps<{
  title: String;
  breadcrumbs: Breadcrumb[];
  project: Project;
}>();
</script>
