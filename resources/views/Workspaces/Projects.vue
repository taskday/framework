<template>
  <div>
    <VPageHeader />
    <div class="py-6">
      <VContainer>
        <VCard v-for="project in workspace.projects">
          <VLink :href="route('projects.show', project)">{{ project.title }}</VLink>
        </VCard>
      </VContainer>
    </div>
  </div>
</template>

<script setup lang="ts">
const props = defineProps<{ workspace: Workspace }>()
</script>
