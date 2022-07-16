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
  <VPageHeader />

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
