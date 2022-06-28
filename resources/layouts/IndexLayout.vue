<script setup lang="ts">
import useFilters from "@/composables/useFilters";
import ProjectPreview from "@/views/Projects/Partials/ProjectPreview.vue";

const props = defineProps<{
  title: string;
  breadcrumbs: Breadcrumb[];
  workspaces: Workspace[];
  projects: Project[];
  fields: Field[];
}>();

const { data, isLoading, isFinished, execute, pagination, filters, toggleFilter } = useFilters("api.workspaces.index");
</script>

<template>
  <VPageHeader>
    <VPopover class="relative">
      <template #button>Projects</template>
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
      <template #button>Workspaces</template>
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
      <template #button>Fields</template>
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

  <div class="px-6 flex items-center gap-3">
    <div>
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

  <slot></slot>
</template>
