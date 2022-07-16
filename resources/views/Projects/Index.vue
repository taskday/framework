<script setup lang="ts">
import _ from "lodash";
import { onMounted, PropType } from "vue";
import ProjectView from "./Partials/ProjectView.vue";
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

interface Filters {
  search: string
  workspaces: number[]
  projects: number[]
  fields: number[]
}

const { models, actions, status, pagination, params } = useModels<Project, Filters>(route('api.projects.index'))

useChannel('projects.any', {
  '.ProjectUpdatedEvent': (e) => actions.syncModels(e.projects)
});

useChannel('cards.any', {
  '.CardUpdatedEvent': (e) => actions.syncModels(e.cards),
  '.CardCreatedEvent': (e) => actions.syncModels(e.cards)
});
</script>

<template>
  <VPageHeader />

  <VFetchStatus
    :status="status"
    :models="models"
    :pagination="pagination"
  />

  <div class="h-full">
    <div class="grid grid-cols-1 gap-8 py-8">
      <div class="" v-for="project in models?.data">
        <ProjectView :project="project" :key="project.id">
          <template #title>
            <VBreadcrumbs :items="project.breadcrumbs" />
          </template>
        </ProjectView>
      </div>
    </div>
    <div class="flex items-center justify-center" v-if="models && models.current_page < models.last_page">
      <VButton :loading="status.isLoading" @click="() => pagination.per_page = pagination.per_page + 5">
        Load more
      </VButton>
    </div>
  </div>
</template>

