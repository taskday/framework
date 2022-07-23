<template>
  <VPageHeader> </VPageHeader>

  <ProjectView :project="project" :settings="false" />
</template>

<script lang="ts">
import GuestLayout from '@/layouts/GuestLayout.vue';
import useViews from './useViews';

export default {
  layout: GuestLayout
}
</script>

<script setup lang="ts">
import ProjectView from './Partials/ProjectView.vue';

let props = defineProps<{
  title: String;
  breadcrumbs: Breadcrumb[];
  project: Project;
}>();

const { currentView, views, updateCurrentView } = useViews(props.project);
</script>
