<script lang="ts" setup>
import { PropType } from 'vue';

defineProps({
  toggleFilter: {
    type: Function,
    required: true,
  },
  projects: {
    type: Array as PropType<Project[]>,
    required: true,
  },
  workspaces: {
    type: Array as PropType<Workspace[]>,
    required: true,
  },
  fields: {
    type: Array as PropType<Field[]>,
    required: true,
  },
  filters: {
    type: Object as PropType<{ projects: number[], workspaces: number[], fields: number[], search: string, }>,
    required: true
  }
})

</script>

<template>
  <div>
    <div class="px-6 flex flex-wrap items-center gap-2 mt-4">
      <VDropdown >
        <VDropdownButton>
          {{ "Filter Project" }}
        </VDropdownButton>
        <VDropdownItems align="left">
          <VDropdownItem
            v-for="project in projects"
            @click="toggleFilter(project, 'projects')"
            :key="project.id"
            :selected="filters.projects.includes(project.id)">
            <span>{{ project.title }}</span>
          </VDropdownItem>
        </VDropdownItems>
      </VDropdown>
      <VDropdown >
        <VDropdownButton>
          {{ "Filter Workspace" }}
        </VDropdownButton>
        <VDropdownItems align="left">
          <VDropdownItem
            v-for="workspace in workspaces"
            @click="toggleFilter(workspace, 'workspaces')"
            :key="workspace.id"
            :selected="filters.workspaces.includes(workspace.id)">
            <span>{{ workspace.title }}</span>
          </VDropdownItem>
        </VDropdownItems>
      </VDropdown>
      <VDropdown>
        <VDropdownButton>
          {{ "With field" }}
        </VDropdownButton>
        <VDropdownItems align="left">
          <VDropdownCheckboxItem
            v-for="field in fields"
            :key="field.id"
            @click="toggleFilter(field, 'fields')"
            :active="filters.fields.includes(field.id)"
            :checked="filters.fields.includes(field.id)"
          >
            {{ field.title }}
          </VDropdownCheckboxItem>
        </VDropdownItems>
      </VDropdown>
    </div>
  </div>
</template>
