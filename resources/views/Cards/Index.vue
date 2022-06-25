
<script setup lang="ts">
import { PropType, computed } from "vue";
import ProjectView from "../Projects/Partials/ProjectView.vue";
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

const { data, isLoading, isFinished, execute, pagination, filters, toggleFilter } = useFilters('api.cards.index');

const fakeProject = computed(() => {
  if (! filters.value.hasOwnProperty('fields')) {
    filters.value['fields'] = [];
  }

  return {
    id: null,
    title: null,
    description: null,
    fields: props.fields.filter(f => filters.value.fields.includes(f.id)),
    cards: data.value?.data ?? []
  }
})
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
    <div class="flex items-center justify-start gap-2 px-6 mt-5" v-if="data?.current_page <= data?.last_page">
      <span class="text-sm block">{{ data.data.length }} of {{ data.total }}</span>
    </div>
    <div class="grid grid-cols-1 gap-8 py-8">
      <ProjectView :key="JSON.stringify(filters)" :project="fakeProject" />
    </div>
  </div>
</template>

