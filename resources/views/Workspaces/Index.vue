<script setup lang="ts">
import moment from "moment";
import useFilters from "@/composables/useFilters";
import ProjectPreview from "@/views/Projects/Partials/ProjectPreview.vue";
import { useChannel } from "@/composables/useChannel";
import { onMounted } from "vue";
import { useModels } from "@/composables/useModels";

const props = defineProps<{
  title: string;
  breadcrumbs: Breadcrumb[];
  workspaces: Workspace[];
  projects: Project[];
  fields: Field[];
}>();

interface Filters {
  search: string
  workspaces: number[]
  projects: number[]
  fields: number[]
}

const { models, actions, status, pagination, filters } = useModels<Project, Filters>(route('api.workspaces.index'))

onMounted(() => actions.fetch());
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
          <VFormCheckbox label="" :modelValue="filters.data.value.projects.includes(project.id)">
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
          <VFormCheckbox label="" :modelValue="filters.data.value.workspaces.includes(workspace.id)">
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
          <VFormCheckbox label="" :modelValue="filters.data.value.fields.includes(field.id)">
            {{ field.title }}
          </VFormCheckbox>
        </div>
      </VPopoverPanel>
    </VPopover>
  </VPageHeader>

  <div class="px-6 flex items-center mt-8 gap-3">
    <div>
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

  <div class="grid grid-cols-1 gap-10 mt-8">
    <VCarousel v-for="workspace in models?.data">
      <template #title>
        <VPageTitle>
          <Link :href="route('workspaces.show', workspace)" class="px-6">
            {{ workspace.title }}
          </Link>
        </VPageTitle>
      </template>
      <div class="flex shrink-0 h-full gap-6 px-6" v-for="project in workspace.projects">
        <ProjectPreview
          class="my-1 w-96 flex shrink-0"
          :project="project"
        />
      </div>
    </VCarousel>
  </div>
</template>
