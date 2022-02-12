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
          <VTabsItem>Table</VTabsItem>
          <VTabsItem v-if="project.customFields.status">Kanban</VTabsItem>
        </VTabsList>
        <VTabsPanels>
          <VTabsPanel class="pt-6 pb-10">
            <VContainer class="lg:hidden">
              <VCard v-for="card in project.cards" :key="card.id">
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
            </VContainer>
            <VContainer class="hidden lg:block">
              <VTable>
                <VTableHead>
                  <VTableHeading>Title</VTableHeading>
                  <VTableHeading v-for="field in project.fields">{{ field.title }}</VTableHeading>
                </VTableHead>
                <VTableBody>
                  <VTableRow v-for="card in project.cards">
                    <VTableCell class="py-2">
                      <div class="">
                        <Link
                          :href="route('cards.show', card)"
                          class="inline cursor-pointer hover:underline text-left"
                        >{{ card.title }}</Link>
                        <span
                          class="ml-2 inline-flex align-middle"
                          v-if="card.comments.length > 0"
                        >
                            <ChatIcon class="h-5 w-5" />
                          <span class="text-gray-800 text-sm dark:text-gray-300">{{ card.comments.length }}</span>
                        </span>
                      </div>
                    </VTableCell>
                    <VTableCell v-for="field in project.fields">
                      <VFieldWrapper
                        :field="{ ...field, ...card.customFields[field.handle] }"
                        :card="card"
                      />
                    </VTableCell>
                  </VTableRow>
                </VTableBody>
              </VTable>
            </VContainer>
          </VTabsPanel>
          <VTabsPanel v-if="project.customFields.status">
            <div v-if="project.customFields.status" class="h-full flex-grow">
              <div class="flex flex-col h-full flex-grow">
                <div class="-my-2 overflow-x-auto h-full flex-grow">
                  <div class="py-2 align-middle inline-block min-w-full h-full flex-grow">
                    <div class="h-full flex-grow">
                      <div class="flex mx-auto gap-x-8 overflow-hidden h-full flex-grow translated-container">
                        <div
                          class="w-72 flex-col flex flex-shrink-0 pb-4 rounded font-semibold"
                          v-for="column in state.columns"
                          :key="column.color"
                        >
                          <div class="border-b py-3">
                            <span
                              class="px-3 rounded h-6 inline-flex items-center text-sm"
                              :class="{
                                'bg-gray-100 dark:bg-gray-400 text-gray-600 dark:text-gray-400 dark:bg-opacity-20': column.color === 'gray',
                                'bg-red-100 dark:bg-red-400 text-red-600 dark:text-red-400 dark:bg-opacity-20': column.color === 'red',
                                'bg-green-100 dark:bg-green-400 text-green-600 dark:text-green-400 dark:bg-opacity-20': column.color === 'green',
                                'bg-yellow-100 dark:bg-yellow-400 text-yellow-600 dark:text-yellow-400 dark:bg-opacity-20': column.color === 'yellow',
                                'bg-blue-100 dark:bg-blue-400 text-blue-600 dark:text-blue-400 dark:bg-opacity-20': column.color === 'blue',
                                'bg-teal-100 dark:bg-teal-400 text-teal-600 dark:text-teal-400 dark:bg-opacity-20': column.color === 'teal',
                                'bg-purple-100 dark:bg-purple-400 text-purple-600 dark:text-purple-400 dark:bg-opacity-20': column.color === 'purple',
                              }"
                            >{{ column.name }}</span>
                          </div>
                          <div class="mt-4">
                            <draggable
                              class="space-y-4"
                              @change="({ added }) => added && updateColumn(column, added.element)"
                              v-model="column.cards"
                              :animation="200"
                              ghost-class="opacity-50"
                              group="tasks"
                              itemKey="id"
                            >
                              <template #item="{ element }">
                                <VCard>
                                  <Link
                                    :href="route('cards.show', element)"
                                    class="flex items-center text-left font-semibold text-sm hover:underline"
                                  >{{ element.title }}</Link>
                                  <div class="mt-4 flex items-center flex-wrap gap-4">
                                    <VFieldWrapper
                                      :key="field.id + '' + element.id"
                                      v-for="field in project.fields"
                                      :field="{ ...field, ...element.customFields[field.handle] }"
                                      :card="element"
                                    />
                                  </div>
                                </VCard>
                              </template>
                            </draggable>
                            <KanbanCardForm class="mt-4" :project="project" :status="column" />
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </VTabsPanel>
        </VTabsPanels>
      </VTabs>
      <div v-if="state.selected != null">
        <VDrawer
          :isOpen="state.selected != null"
          :title="state.selected.title"
          :onClose="() => state.selected = null"
        >
          <div class="space-y-4">
            <VLink
              :href="route('cards.show', state.selected)"
              class="h-7 w-7 flex items-center justify-center"
            >
              <ExternalLinkIcon
                class="h-5 w-5 hover:bg-gray-200 dark:bg-gray-800 rounded stroke-current text-gray-700 dark:text-gray-300"
              ></ExternalLinkIcon>
            </VLink>
            <VConfirm title="Are you sure?" :onConfirm="destroy">
              <VButton>Delete</VButton>
            </VConfirm>
            <VRoom :name="`App.Models.Card.${state.selected['id']}`"></VRoom>
            <VFormHtmlEditor v-model="state.selected.content" />
            <VCommentList :comments="state.selected.comments ?? []" />
          </div>
        </VDrawer>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import draggable from 'vuedraggable';
import { watch, reactive } from 'vue'
import useCardFieldForm from '@/composables/useCardFieldForm';
import KanbanCardForm from './KanbanCardForm.vue';
import { InformationCircleIcon, ChatIcon, CogIcon, ExternalLinkIcon } from '@heroicons/vue/outline';
import { Inertia } from '@inertiajs/inertia';
import VLink from '@/components/VLink.vue';

const props = defineProps<{
  title: String,
  breadcrumbs: {
    name: String,
    href: String,
  }[]
  project: Project
}>()

const state = reactive<{
  columns: {
    id: string,
    name: String,
    color: String,
    cards: Card[],
  }[],
  selected: Card | null,
  options: { color: string, name: string }[]
}>({
  columns: [],
  options: props.project.customFields?.status?.options,
  selected: null,
});

const updateColumn = ((column, card) => {
  const { form, update } = useCardFieldForm();
  form.value = column.color;
  update(card, props.project.customFields.status.id);
});

const cardsForOption = (option): Card[] => {
  return props.project.cards.filter(card => {
    return card.fields?.some(f => f.type === 'status' && (f.pivot.value == option.color))
  })
}

watch(() => props.project, () => {
  state.columns = state.options?.map((option) => {
    return {
      ...option,
      cards: cardsForOption(option)
    }
  })
}, { immediate: true });

function destroy(status) {
  Inertia.delete(route('cards.destroy', state.selected), {
    onSuccess: () => {
      state.selected = null;
    }
  })
}
</script>
