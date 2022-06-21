<script setup lang="ts">
import moment from "moment";
import { PlusIcon } from "@heroicons/vue/outline";
import { useAxios } from '@vueuse/integrations/useAxios'
import { useStorage } from "@vueuse/core";
import _ from 'lodash';
import { onMounted, watch } from "vue";

const props = defineProps<{
  title: string;
  breadcrumbs: Breadcrumb[];
  workspaces: Workspace[];
  projects: Project[];
}>();

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
    execute(route('api.workspaces.index', { filters: filters.value }));
})

watch(filters, _.throttle(function (value) {
  execute(route('api.workspaces.index', { filters: value }));
}), { deep: true })

function toggleFilter(model: any, key: string) {
  if ( filters.value[key].includes(model.id) ) {
    filters.value[key] = filters.value[key].filter(id => id !== model.id);
  } else {
    filters.value[key] = [...filters.value[key], model.id];
  }
}
</script>

<template>
  <div>
    <VPageHeader>
      <VBreadcrumbs :items="breadcrumbs" />
      <div class="flex items-center justify-between">
        <VPageTitle>{{ title }}</VPageTitle>
        <div class="flex items-center gap-2">
          <VButton :href="route('workspaces.create')">
            <PlusIcon class="h-5 w-5" />
            <span class="ml-2">New Workspace</span>
          </VButton>
        </div>
      </div>
    </VPageHeader>

    <div class="px-6 flex items-center gap-2 mt-4">
      <VDropdown>
        <VDropdownButton>
          <VButton variant="secondary" class="text-sm">
            {{ "Filter Project" }}
          </VButton>
        </VDropdownButton>
        <VDropdownItems>
          <VDropdownItem
            v-for="project in projects"
            @click="toggleFilter(project, 'projects')"
            :key="project.id"
            :class="{ 'bg-gray-100 dark:bg-gray-800': filters.projects.includes(project.id) }">
            <span>{{ project.title }}</span>
          </VDropdownItem>
        </VDropdownItems>
      </VDropdown>
      <VDropdown>
        <VDropdownButton>
          <VButton variant="secondary" class="text-sm">{{ "Filter Workspace" }}</VButton>
        </VDropdownButton>
        <VDropdownItems>
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
    </div>

    <Transition
      enter-active-class="transition-all duration-75"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition-all duration-150"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div class="py-16 grid grid-cols-1 gap-16">
        <div v-for="workspace in data" class="flex flex-col">
          <Link :href="route('workspaces.show', workspace)" class="text-xl font-extrabold sticky hover:underline px-6">
            {{ workspace.title }}
          </Link>
          <div class="relative">
            <div class="overflow-hidden">
              <div class="overflow-x-auto snap-x snap-mandatory relative">
                <div class="w-full inline-flex align-top py-8">
                  <div class="snap-start last:pr-12 last:mr-12 shrink-0" v-for="project in workspace.projects">
                    <VCard class="my-1 w-96 flex shrink-0 ml-6 last:mr-6">
                      <div class="flex flex-col items-start justify-between w-full gap-4 overflow-wrap">
                        <div>
                          <Link class="text-base" :href="route('projects.show', project)">
                            {{ project.title }}
                          </Link>
                          <div v-if="project.description" class="text-sm text-gray-800">
                            {{ project.description }}
                          </div>
                        </div>
                        <div v-if="project.comments.length > 0" v-for="comment in project.comments" style="overflow-wrap: anywhere;">
                          <div class="flex gap-2 items-start flex-shrink-0">
                            <VAvatar :user="comment.creator"/>
                            <div>
                              <p>
                                <span class="inline-flex gap-2">
                                  commented on
                                </span> "<Link class="underline" style="overflow-wrap: anywhere;" :href="route('cards.show', comment.commentable)">{{ comment.commentable.title }}</Link>"
                              </p>
                              <div class="prose mt-2 line-clamp-2" v-html="comment.body"></div>
                            </div>
                          </div>
                        </div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                          updated {{ moment(project.updated_at).fromNow() }}
                        </span>
                      </div>
                    </VCard>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </Transition>

  </div>
</template>
