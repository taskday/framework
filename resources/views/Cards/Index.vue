
<script setup lang="ts">
import { PropType, computed } from "vue";
import ProjectView from "../Projects/Partials/ProjectView.vue";
import { useModels } from "@/composables/useModels";
import { useChannel } from "@/composables/useChannel";

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

interface Filter {
  search: string;
  workspaces: number[],
  projects: number[],
  fields: number[],
}

const { models, status, filters, pagination, actions } = useModels<Card, Filter>(route('api.cards.index'));

useChannel('cards.any', {
  '.CardUpdatedEvent': (e) => actions.syncModels(e.cards)
});

const fakeProject = computed(() => {
  return {
    id: null,
    title: null,
    description: null,
    fields: props.fields.filter(f => filters.data.value?.fields?.includes(f.id)),
    cards: status.isLoading || status.isError ? []  : (models?.value?.data ?? [])
  }
})
</script>

<template>
  <VPageHeader>
    <VPopover class="relative">
      <VPopoverButton>Projects</VPopoverButton>
      <VPopoverPanel>
        <div
          class="px-4 py-1.5 background-200"
          v-for="project in projects"
          @click="filters.toggle(project, 'projects')"
        >
          <VFormCheckbox label="" :modelValue="filters.data.value?.projects.includes(project.id)">
            {{ project.title }}
          </VFormCheckbox>
        </div>
      </VPopoverPanel>
    </VPopover>
    <VPopover class="relative">
      <VPopoverButton>Workspaces</VPopoverButton>
      <VPopoverPanel>
        <div
          class="px-4 py-1.5 background-200"
          v-for="workspace in workspaces"
          @click="filters.toggle(workspace, 'workspaces')"
        >
          <VFormCheckbox label="" :modelValue="filters.data.value?.workspaces.includes(workspace.id)">
            {{ workspace.title }}
          </VFormCheckbox>
        </div>
      </VPopoverPanel>
    </VPopover>
    <VPopover class="relative">
      <VPopoverButton>Fields</VPopoverButton>
      <VPopoverPanel>
        <div
          class="px-4 py-1.5 background-200"
          v-for="field in fields"
          @click="filters.toggle(field, 'fields')"
        >
          <VFormCheckbox label="" :modelValue="filters.data.value.fields?.includes(field.id)">
            {{ field.title }}
          </VFormCheckbox>
        </div>
      </VPopoverPanel>
    </VPopover>
  </VPageHeader>

  <div class="px-6 flex flex-wrap items-center mt-8 gap-3">
    <div >
      <VFormInput v-model="filters.data.value.search" type="search" placeholder="Search..."></VFormInput>
    </div>
    <VButton variant="secondary" v-for="workspace in filters.data.value.workspaces" @click="filters.toggle(workspaces.find(w => w.id === workspace), 'workspaces')">
      <span>&times;</span>
      <span>{{ workspaces.find(w => w.id === workspace)?.title }}</span>
    </VButton>
    <VButton variant="secondary" v-for="project in filters.data.value.projects" @click="filters.toggle(projects.find(w => w.id === project), 'projects')">
      <span>&times;</span>
      <span>{{ projects.find(w => w.id === project)?.title }}</span>
    </VButton>
    <VButton v-for="field in filters.data.value.fields" variant="secondary" @click="filters.toggle(fields.find(w => w.id === field), 'fields')">
      <span>&times;</span>
      <span>{{ fields.find(w => w.id === field)?.title }}</span>
    </VButton>
  </div>

  <VFetchStatus
    :status="status"
    :models="models"
    :pagination="pagination"
  />

  <div class="h-full" v-if="!status.isError">
    <div class="grid grid-cols-1 gap-8 py-8">
      <ProjectView :key="status.isLoading" :project="fakeProject" />
    </div>
  </div>
</template>

