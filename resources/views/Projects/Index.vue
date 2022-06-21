
<script setup lang="ts">
import _ from "lodash";
import { PropType, onMounted, watch } from "vue";
import ProjectView from "./Partials/ProjectView.vue";
import { useStorage } from "@vueuse/core";
import { useAxios } from "@vueuse/integrations/useAxios";

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

const filters = useStorage<{
  workspaces: number[],
  projects: number[],
  search: string;
}>('filters', {
  workspaces: [],
  projects: [],
  search: '',
});

const { data, isLoading, isFinished, execute  } = useAxios();

onMounted(() => {
    execute(route('api.projects.index', { filters: filters.value }));
})

watch(filters, _.throttle(function (value) {
  execute(route('api.projects.index', { filters: value }));
}), { deep: true })

function toggleFilter(model: any, key: string) {
  if ( filters.value[key].includes(model.id) ) {
    filters.value[key] = filters.value[key].filter(id => id !== model.id);
  } else {
    filters.value[key] = [...filters.value[key], model.id];
  }
}

// const fieldsFilter = computed<TaskdayInterface>(() => {
//   return _.pickBy(props.filters, (p) => p.type != "builtin");
// });

// const { shouldSortBy, isCurrent, isDesc } = useSorter();

// const form = useForm({
//   filters: props.filters,
//   sort: props.sort
// });

// function filterBuiltin(handle, model) {
//   if (model.id == _.get(form.filters, handle + ".value", null)) {
//     delete form.filters[handle];
//   } else {
//     form.filters = props.filters || {};
//     form.filters[handle] = {};
//     form.filters[handle]["value"] = model.id;
//     form.filters[handle]["operator"] = "=";
//     form.filters[handle]["type"] = "builtin";
//   }
//   applyFilter();
// }

// function sortFields(field) {
//   shouldSortBy(field, (arg) => {
//     form.sort = arg;
//     applyFilter()
//   })
// }

// function applyFilter() {
//   Inertia.visit(route("cards.index", { filters: form.filters, sort: form.sort }));
// }
</script>

<template>
  <VPageHeader class="shadow-none px-6">
    <VBreadcrumbs :items="breadcrumbs" />
    <div class="flex items-center justify-between">
      <VPageTitle>{{ title }}</VPageTitle>
    </div>
  </VPageHeader>
  <div class="h-full">
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
    </div>
    <div class="grid grid-cols-1 gap-8 py-8">
      <div class="" v-for="project in data?.data">
        <VBreadcrumbs :items="project.breadcrumbs" class="px-6 mb-2" />
        <ProjectView :project="project" :key="project.id" />
      </div>
    </div>
  </div>
</template>

