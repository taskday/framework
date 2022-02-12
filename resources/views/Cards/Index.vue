<template>
  <VPageHeader>
    <VContainer>
      <div class="flex items-center justify-between">
        <VPageTitle>{{ title }}</VPageTitle>
      </div>
    </VContainer>
  </VPageHeader>

  <VContainer>
    <div class="grid grid-cols-1 lg:grid-cols-[1fr,4fr] gap-8 py-8">
      <div class>
        <div>
          <div>
            <VNav class="flex flex-col gap-2">
              <VNavLink
                v-for="filter in [{
                  title: 'Assigned to me',
                  handle: 'assigned_to_me',
                }, {
                  title: 'Backlog',
                  handle: 'backlog',
                }, {
                  title: 'To Do',
                  handle: 'to_do',
                }, {
                  title: 'In Progress',
                  handle: 'in_progress',
                }, {
                  title: 'Completed',
                  handle: 'completed',
                }, {
                  title: 'Reset',
                  handle: '',
                }]"
                class="px-2"
                :class="{ 'bg-gray-200 dark:bg-gray-700': filter.handle === currentFilter }"
                @click="applyFilter(filter)"
                href="#"
              >
                {{ filter.title }}
              </VNavLink>
            </VNav>
          </div>
        </div>
      </div>
      <div class="flex flex-col gap-2">
        <VCard v-for="card in cards.data">
          <VBreadcrumb>
            <VBreadcrumbItem
              :href="route('workspaces.show', card.project.workspace)"
            >{{ card.project.workspace.title }}</VBreadcrumbItem>
            <VBreadcrumbItem :href="route('projects.show', card.project)">{{ card.project.title }}</VBreadcrumbItem>
          </VBreadcrumb>
          <VLink :href="route('cards.show', card)" class="block">{{ card.title }}</VLink>
          <div class="flex items-center gap-3 mt-2">
            <div v-for="field in card.project.fields" :key="card.id + '' +field.handle">
              <VFieldWrapper
                :field="{ ...field, ...card.customFields[field.handle] }"
                :card="card"
              />
            </div>
          </div>
        </VCard>
      </div>
    </div>
  </VContainer>
</template>

<script setup lang="ts">import { Inertia } from '@inertiajs/inertia';
import VNavLink from '@/components/VNavLink.vue';

const props = defineProps<{
  title: String,
  breadcrumbs: {
    name: String,
    href: String,
  }[],
  currentFilter: String,
  cards: Pagination<Card>
}>()

function applyFilter(filter) {
  Inertia.get(route('cards.index', { filter: filter.handle }))
}
</script>
