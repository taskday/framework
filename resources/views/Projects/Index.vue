<template>
  <VPageHeader class="shadow-none px-6">
    <VBreadcrumb>
      <VBreadcrumbItem v-for="breadcrumb in breadcrumbs" :href="breadcrumb.url">
        {{ breadcrumb.title }}
      </VBreadcrumbItem>
    </VBreadcrumb>
    <div class="flex items-center justify-between">
      <VPageTitle>{{ title }}</VPageTitle>
    </div>
  </VPageHeader>
  <div class="h-full">
    <div class="px-6 pt-8">
      <div class="flex items-center gap-2">
        <VDropdown>
          <VDropdownButton>
            <VButton variant="secondary" class="text-sm">
              {{ projects.find((p) => p.id == _.get(form.filters, "project.value", null))?.title ?? "Filter Project" }}
            </VButton>
          </VDropdownButton>
          <VDropdownItems>
            <VDropdownItem
              v-for="project in projects"
              @click="filterBuiltin('project', project)"
              :key="project.id"
              :class="{ 'bg-gray-100 dark:bg-gray-800': project.id == _.get(form.filters, 'project.value', null) }">
              <span>{{ project.title }}</span>
            </VDropdownItem>
          </VDropdownItems>
        </VDropdown>
        <VDropdown>
          <VDropdownButton>
            <VButton variant="secondary" class="text-sm">{{
              workspaces.find((p) => p.id == _.get(form.filters, "workspace.value", null))?.title ??
              "Filter Workspace"
            }}</VButton>
          </VDropdownButton>
          <VDropdownItems>
            <VDropdownItem
              v-for="workspace in workspaces"
              @click="filterBuiltin('workspace', workspace)"
              :key="workspace.id"
              :class="{
                'bg-gray-100 dark:bg-gray-800': workspace.id == _.get(form.filters, 'workspace.value', null),
              }">
              <span>{{ workspace.title }}</span>
            </VDropdownItem>
          </VDropdownItems>
        </VDropdown>
        <VDropdown>
          <VDropdownButton>
            <VButton variant="secondary" class="text-sm">
              {{ form.sort ?? "Sort by" }}
            </VButton>
          </VDropdownButton>
          <VDropdownItems>
            <VDropdownItem
              v-for="field in fields"
              @click="sortFields(field)"
              :key="field.handle"
              :class="{
                'bg-gray-100 dark:bg-gray-800': isCurrent(field),
              }">
              <span>{{ field.title }}</span>
            </VDropdownItem>
          </VDropdownItems>
        </VDropdown>
        <div v-for="(filter, handle) in fieldsFilter" class="flex items-center">
          <div class="text-sm">{{ handle }}: {{ filter }}</div>
          <div class="flex items-center">
            <VButton variant="secondary" class="text-sm"> Remove </VButton>
          </div>
        </div>
      </div>
    </div>
    <div class="grid grid-cols-1 gap-8 py-8">
      <VTabs>
        <VTabsList class="px-6">
          <VTabsItem v-for="view in taskday().views" :key="view.name">{{ view.name }}</VTabsItem>
        </VTabsList>
        <VTabsPanels class="h-full">
          <VTabsPanel class="h-full space-y-8" v-for="view in taskday().views" :key="view.name">
            <div v-for="project in projects">
              <h3 class="font-bold mb-4 px-6">
                 <VBreadcrumb>
                  <VBreadcrumbItem :href="route('workspaces.show', project.workspace)">
                    {{ project.workspace.title }}
                  </VBreadcrumbItem>
                  <VBreadcrumbItem :href="route('projects.show', project)">
                    {{ project.title }}
                  </VBreadcrumbItem>
                </VBreadcrumb>
              </h3>
              <component :is="view.component" :project="project"></component>
            </div>
          </VTabsPanel>
        </VTabsPanels>
      </VTabs>
    </div>
  </div>
</template>

<script setup lang="ts">
import _ from "lodash";
import { PropType, computed, onMounted } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import useSorter from "@/composables/useSorter";

const props = defineProps({
  title: String,
  breadcrumbs: {
    type: Object as PropType<
      {
        name: String;
        href: String;
      }[]
    >,
  },
  filters: {
    type: Object,
    default: {},
    required: false,
  },
  sort: {
    type: String,
    default: null,
    required: false,
  },
  fields: {
    type: Array as PropType<Field[]>,
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
  cards: {
    type: Object as PropType<Pagination<Card>>,
  },
});

const fieldsFilter = computed<TaskdayInterface>(() => {
  return _.pickBy(props.filters, (p) => p.type != "builtin");
});

const { shouldSortBy, isCurrent, isDesc } = useSorter();

const form = useForm({
  filters: props.filters,
  sort: props.sort
});

function filterBuiltin(handle, model) {
  if (model.id == _.get(form.filters, handle + ".value", null)) {
    delete form.filters[handle];
  } else {
    form.filters = props.filters || {};
    form.filters[handle] = {};
    form.filters[handle]["value"] = model.id;
    form.filters[handle]["operator"] = "=";
    form.filters[handle]["type"] = "builtin";
  }
  applyFilter();
}

function sortFields(field) {
  shouldSortBy(field, (arg) => {
    form.sort = arg;
    applyFilter()
  })
}

function applyFilter() {
  Inertia.visit(route("cards.index", { filters: form.filters, sort: form.sort }));
}
</script>
