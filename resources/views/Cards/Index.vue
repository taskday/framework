<template>
  <VPageHeader>
    <VContainer>
      <div class="flex items-center justify-between">
        <VPageTitle>{{ title }}</VPageTitle>
      </div>
    </VContainer>
  </VPageHeader>

  <VContainer>
    <div class="grid grid-cols-1 gap-8 py-8">
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

<script setup lang="ts">
import { Inertia } from '@inertiajs/inertia';
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
