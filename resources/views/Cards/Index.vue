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
  <div class="h-full px-6">
    <div class="grid grid-cols-1 gap-8 py-8">
      <div>
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
      <div class="flex flex-col gap-2">
        <VCard v-for="card in cards.data">
          <VBreadcrumb>
            <VBreadcrumbItem :href="route('workspaces.show', card.project.workspace)">{{
              card.project.workspace.title
            }}</VBreadcrumbItem>
            <VBreadcrumbItem :href="route('projects.show', card.project)">{{ card.project.title }}</VBreadcrumbItem>
          </VBreadcrumb>
          <Link class="text-base hover:underline" :href="route('cards.show', card)">{{ card.title }}</Link>
          <div class="flex items-center gap-3 mt-2">
            <div v-for="field in card.project.fields" :key="card.id + '' + field.handle">
              <VFieldWrapper :field="{ ...field, ...card.customFields[field.handle] }" :card="card" />
            </div>
          </div>
        </VCard>
      </div>
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
