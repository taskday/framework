
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
  <VPageHeader>
    <VPopover class="relative">
      <VPopoverButton>Projects</VPopoverButton>
      <template #content>
        <div
          class="px-4 py-1.5 background-200"
          v-for="project in projects"
          @click="toggleFilter(project, 'projects')"
        >
          <VFormCheckbox label="" :modelValue="filters.projects.includes(project.id)">
            {{ project.title }}
          </VFormCheckbox>
        </div>
      </template>
    </VPopover>
    <VPopover class="relative">
      <VPopoverButton>Workspaces</VPopoverButton>
      <template #content>
        <div
          class="px-4 py-1.5 background-200"
          v-for="workspace in workspaces"
          @click="toggleFilter(workspace, 'workspaces')"
        >
          <VFormCheckbox label="" :modelValue="filters.workspaces.includes(workspace.id)">
            {{ workspace.title }}
          </VFormCheckbox>
        </div>
      </template>
    </VPopover>
    <VPopover class="relative">
      <VPopoverButton>Fields</VPopoverButton>
      <template #content>
        <div
          class="px-4 py-1.5 background-200"
          v-for="field in fields"
          @click="toggleFilter(field, 'fields')"
        >
          <VFormCheckbox label="" :modelValue="filters.fields.includes(field.id)">
            {{ field.title }}
          </VFormCheckbox>
        </div>
      </template>
    </VPopover>
  </VPageHeader>

  <div class="px-6 flex flex-wrap items-center mt-8 gap-3">
    <div >
      <VFormInput v-model="filters.search" type="search" placeholder="Search..."></VFormInput>
    </div>
    <VButton variant="secondary" v-for="workspace in filters.workspaces" @click="toggleFilter(workspaces.find(w => w.id === workspace), 'workspaces')">
      <span>&times;</span>
      <span>{{ workspaces.find(w => w.id === workspace)?.title }}</span>
    </VButton>
    <VButton variant="secondary" v-for="project in filters.projects" @click="toggleFilter(projects.find(w => w.id === project), 'projects')">
      <span>&times;</span>
      <span>{{ projects.find(w => w.id === project)?.title }}</span>
    </VButton>
    <VButton v-for="field in filters.fields" variant="secondary" @click="toggleFilter(fields.find(w => w.id === field), 'fields')">
      <span>&times;</span>
      <span>{{ fields.find(w => w.id === field)?.title }}</span>
    </VButton>
  </div>

  <span class="text-sm block px-6 mt-2 text-gray-600 dark:text-gray-400">
    <span v-if="isLoading">Loading...</span>
    <span v-else>Showing {{ data?.data?.length }} results of {{ data?.total }}</span>
  </span>

  <div class="h-full">
    <div class="grid grid-cols-1 gap-8 py-8">
      <ProjectView :key="JSON.stringify(filters)" :project="fakeProject" />
    </div>
  </div>
</template>

