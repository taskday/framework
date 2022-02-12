<template>
  <div>
    <VPageHeader>
      <VContainer>
        <div class="flex items-center justify-between">
          <VPageTitle>{{ title }}</VPageTitle>
          <div class="flex items-center gap-2">
            <VButton variant="secondary" :href="route('workspaces.create')">
              <PlusIcon class="h-5 w-5" />
              <span class="ml-2">New Workspace</span>
            </VButton>
          </div>
        </div>
      </VContainer>
    </VPageHeader>

    <div class="py-16 grid grid-cols-1 gap-16">
      <div v-for="workspace in workspaces" class="flex flex-col">
        <VContainer>
          <Link
            :href="route('workspaces.show', workspace)"
            class="text-xl font-semibold hover:underline"
          >{{ workspace.title }}</Link>
        </VContainer>
        <div class="relative">
          <div class="overflow-hidden">
            <div class="overflow-x-auto snap-x snap-mandatory relative">
              <div class="w-full inline-flex align-top py-8">
                <div
                  class="snap-start last:pr-6" v-for="project in workspace.projects"
                >
                  <VCard class="my-1 w-96 flex shrink-0 mr-6 translated-container">
                    <div class="flex items-center justify-between w-full">
                      <Link :href="route('projects.show', project)" class="hover:underline">
                        <span class="font-semibold">{{ project.title }}</span>
                      </Link>
                      <span
                        class="text-sm text-gray-600 dark:text-gray-400"
                      >updated {{ moment(project.updated_at).fromNow() }}</span>
                    </div>
                    <div class="mt-4 font-medium">Latest activity:</div>
                    <ul class="flex flex-col gap-1 mt-2">
                      <li
                        v-for="activity in [...project.cards.flatMap(c => c.activities)]"
                        class="block text-gray-600 dark:text-gray-400 gap-2"
                      >
                        <span class="inline-block">
                          <VAvatar :user="activity.causer" />
                        </span>
                        {{ activity.event + ' ' + activity.subject_type.replace('App\\Models\\', '').toLowerCase() }}
                        <Link
                          :href="activity.subject.link"
                          class="text-blue-600 dark:text-blue-300 hover:underline inline break-words"
                        >{{ activity.subject.title }}</Link>
                      </li>
                    </ul>
                  </VCard>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import moment from 'moment';
import { PlusIcon } from '@heroicons/vue/outline'
const props = defineProps<{
  title: string;
  workspaces: Workspace[]
}>()
</script>
