<template>
  <div>
    <VPageHeader>
      <VBreadcrumb>
        <VBreadcrumbItem v-for="breadcrumb in breadcrumbs" :href="breadcrumb.url">
          {{ breadcrumb.title }}
        </VBreadcrumbItem>
      </VBreadcrumb>
      <div class="flex items-center justify-between">
        <VPageTitle>{{ title }}</VPageTitle>
        <div class="flex items-center gap-2">
          <VButton :href="route('workspaces.create')">
            <PlusIcon class="h-5 w-5" />
            <span class="ml-2">New Workspace</span>
          </VButton>
        </div>
      </div>
    </VPageHeader>

    <div class="py-16 grid grid-cols-1 gap-16">
      <div v-for="workspace in workspaces" class="flex flex-col">
        <Link :href="route('workspaces.show', workspace)" class="text-xl font-extrabold sticky hover:underline px-6">
          {{ workspace.title }}
        </Link>
        <div class="relative">
          <div class="overflow-hidden">
            <div class="overflow-x-auto snap-x snap-mandatory relative">
              <div class="w-full inline-flex align-top py-8">
                <div class="snap-start last:pr-12 last:mr-12 shrink-0" v-for="project in workspace.projects">
                  <VCard class="my-1 w-96 flex shrink-0 ml-6 last:mr-6">
                    <div class="flex flex-col items-start justify-between w-full gap-4 overflow-wrap">
                      <div>
                        <Link class="text-base" :href="route('projects.show', project)">
                          {{ project.title }}
                        </Link>
                        <div v-if="project.description" class="text-sm text-gray-800">
                          {{ project.description }}
                        </div>
                      </div>
                      <div v-if="project.comments.length > 0" v-for="comment in project.comments" style="overflow-wrap: anywhere;">
                        <div class="flex gap-2 items-start flex-shrink-0">
                          <VAvatar :user="comment.creator"/>
                          <div>
                            <p>
                              <span class="inline-flex gap-2">
                                commented on
                              </span> "<Link class="underline" style="overflow-wrap: anywhere;" :href="route('cards.show', comment.commentable)">{{ comment.commentable.title }}</Link>"
                            </p>
                            <div class="prose mt-2 line-clamp-2" v-html="comment.body"></div>
                          </div>
                        </div>
                      </div>
                      <span class="text-sm text-gray-600 dark:text-gray-400">
                        updated {{ moment(project.updated_at).fromNow() }}
                      </span>
                    </div>
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
import moment from "moment";
import { PlusIcon } from "@heroicons/vue/outline";
const props = defineProps<{
  title: string;
  breadcrumbs: Breadcrumb[];
  workspaces: Workspace[];
}>();
</script>
