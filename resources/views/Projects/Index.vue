<script setup lang="ts">
import _ from "lodash";
import { PropType } from "vue";
import ProjectView from "./Partials/ProjectView.vue";
import useFilters from '@/composables/useFilters';

const props = defineProps({
  title: String,
  breadcrumbs: {
    type: Object as PropType<Breadcrumb[]>,
  },
  fields: {
    type: Array as PropType<Field[]>,
    required: true,
  },
  projects: {
    type: Object as PropType<Project[]>,
    required: true,
  },
  workspaces: {
    type: Array as PropType<Workspace[]>,
    required: true,
  }
});

const { data, isLoading, isFinished, execute, pagination, filters, toggleFilter } = useFilters('api.projects.index');
</script>

<template>
  <VPageHeader class="shadow-none px-6">
    <VBreadcrumbs :items="breadcrumbs" />
    <div class="flex items-center justify-between">
      <VPageTitle>{{ title }}</VPageTitle>
    </div>
  </VPageHeader>
  <div class="h-full">
    <VFilters
      :toggleFilter="toggleFilter"
      :projects="projects"
      :workspaces="workspaces"
      :fields="fields"
      :filters="filters"
    />
    <div class="grid grid-cols-1 gap-8 py-8">
      <div class="" v-for="project in data?.data">
        <VBreadcrumbs :items="project.breadcrumbs" class="px-6 mb-2" />
        <ProjectView :project="project" :key="project.id" />
      </div>
    </div>
    <div class="flex items-center justify-center" v-if="data?.current_page < data?.last_page">
      <VButton :loading="isLoading" @click="() => pagination.per_page = pagination.per_page + 5">
        Load more
      </VButton>
    </div>
  </div>
</template>

