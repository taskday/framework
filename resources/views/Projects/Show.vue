<template>
  <div class="">
    <VPageHeader class="shadow-none">
      <VContainer>
        <div class="flex items-end justify-between">
          <div>
            <VLink :href="route('workspaces.show', project.workspace)">
              <span class="font-semibold">{{ project.workspace.title }}</span>
            </VLink>
            <VPageTitle>{{ title }}</VPageTitle>
          </div>
          <div>
            <VButton variant="secondary" :href="route('projects.edit', project)">
              <CogIcon class="h-5 w-5" />
            </VButton>
          </div>
        </div>
      </VContainer>
    </VPageHeader>
    <div class="">
      <VTabs>
        <VTabsList>
          <VTabsItem v-for="view in taskday().views" :key="view.name">{{view.name}}</VTabsItem>
        </VTabsList>
        <VTabsPanels>
          <VTabsPanel class="pt-6 pb-10"  v-for="view in taskday().views" :key="view.name">
            <component :is="view.component" :project="project"></component>
          </VTabsPanel>
        </VTabsPanels>
      </VTabs>
    </div>
  </div>
</template>

<script setup lang="ts">
import { CogIcon } from '@heroicons/vue/outline';
import VLink from '@/components/VLink.vue';

const props = defineProps<{
  title: String,
  breadcrumbs: {
    name: String,
    href: String,
  }[]
  project: Project
}>()
</script>
