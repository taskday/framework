<script setup lang="ts">
import { onMounted } from "vue";
import ProjectPreview from "@/views/Projects/Partials/ProjectPreview.vue";
import { useModels } from "@/composables/useModels";

const props = defineProps<{
  title: string;
  breadcrumbs: Breadcrumb[];
  workspaces: Workspace[];
  projects: Project[];
  fields: Field[];
}>();

const { models, actions, status, pagination, params } = useModels<Project, Filter>(route('api.workspaces.index'))
</script>

<template>
  <VPageHeader>
    <VButton :href="route('workspaces.create')">
      <VIcon name="plus" class="h-4 w-4" />
      <span>New Workspace</span>
    </VButton>
  </VPageHeader>

  <VFetchStatus
    :status="status"
    :models="models"
    :pagination="pagination"
  />

  <div class="grid grid-cols-1 gap-10 mt-8">
    <VCarousel v-for="workspace in models?.data">
      <template #title>
        <h2 class="text-lg font-bold hover:underline px-6">
          <Link :href="route('workspaces.show', workspace)" class="inline-flex items-center space-x-2">
            <span>{{ workspace.title }}</span>
            <VIcon name="link" class="h-4 w-4 stroke-current"></VIcon>
          </Link>
        </h2>
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
