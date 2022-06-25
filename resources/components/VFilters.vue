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
    <div class="px-6 flex items-center gap-2 mt-4">
      <VDropdown >
        <VDropdownButton>
          <VButton variant="secondary" class="text-sm">
            {{ "Filter Project" }}
          </VButton>
        </VDropdownButton>
        <VDropdownItems align="left">
          <VDropdownItem
            v-for="project in projects"
            @click="toggleFilter(project, 'projects')"
            :key="project.id"
            :class="{ 'bg-gray-100 dark:bg-gray-800': filters.projects.includes(project.id) }">
            <span>{{ project.title }}</span>
          </VDropdownItem>
        </VDropdownItems>
      </VDropdown>
      <VDropdown >
        <VDropdownButton>
          <VButton variant="secondary" class="text-sm">{{ "Filter Workspace" }}</VButton>
        </VDropdownButton>
        <VDropdownItems align="left">
          <VDropdownItem
            v-for="workspace in workspaces"
            @click="toggleFilter(workspace, 'workspaces')"
            :key="workspace.id"
            :class="{
              'bg-gray-100 dark:bg-gray-800': filters.workspaces.includes(workspace.id),
            }">
            <span>{{ workspace.title }}</span>
          </VDropdownItem>
        </VDropdownItems>
      </VDropdown>
      <VDropdown >
        <VDropdownButton>
          <VButton variant="secondary" class="text-sm">{{ "With field" }}</VButton>
        </VDropdownButton>
        <VDropdownItems align="left">
          <VDropdownItem
            v-for="field in fields"
            @click="toggleFilter(field, 'fields')"
            :key="field.id"
            :class="{
              'bg-gray-100 dark:bg-gray-800': filters.fields.includes(field.id),
            }">
            <span>{{ field.title }}</span>
          </VDropdownItem>
        </VDropdownItems>
      </VDropdown>
      <VFormInput v-model="filters.search" type="search" placeholder="Search..." />
    </div>
    <div class="px-6 flex items-center gap-2 mt-4">
      <VButton variant="secondary" v-for="workspace in filters.workspaces" @click="toggleFilter(workspaces.find(w => w.id === workspace), 'workspaces')">
        {{ workspaces.find(w => w.id === workspace)?.title }}
        &times;
      </VButton>
      <VButton variant="secondary" v-for="project in filters.projects" @click="toggleFilter(projects.find(w => w.id === project), 'projects')">
        {{ projects.find(w => w.id === project)?.title }}
        &times;
      </VButton>
      <div class="flex items-center gap-8">
        <div v-for="field in filters.fields" class="flex items-center gap-2">
          <VButton variant="secondary" @click="toggleFilter(fields.find(w => w.id === field), 'fields')">
            {{ fields.find(w => w.id === field)?.title }}
            &times;
          </VButton>
        </div>
      </div>
    </div>
  </div>
</template>
