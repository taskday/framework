<script lang="ts" setup>
import moment from 'moment';

defineProps<{ project: Project }>()
</script>

<template>
  <VCard>
    <div class="flex flex-col items-start justify-between w-full gap-4 overflow-wrap">
      <div>
        <Link class="text-base" :href="route('projects.show', project)">
          {{ project.title }}
        </Link>
        <div v-if="project.description" class="text-sm text-gray-800">
          {{ project.description }}
        </div>
      </div>
      <div v-if="project.comments.length > 0" v-for="comment in project.comments" style="overflow-wrap: anywhere">
        <div class="flex gap-2 items-start flex-shrink-0">
          <VAvatar :user="comment.creator" />
          <div>
            <p>
              <span class="inline-flex gap-2"> commented on </span> "<Link
                class="underline"
                style="overflow-wrap: anywhere"
                :href="route('cards.show', comment.commentable)"
                >{{ comment.commentable.title }}</Link
              >"
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
</template>
