<template>
  <div class="w-full">
    <VCard style="padding: 0" class="overflow-hidden">
      <div
        :class="`h-10 flex ${comment?.creator?.name === $page.props.user.name
        ? 'bg-blue-50 border-b dark:bg-blue-400 dark:text-blue-400 dark:bg-opacity-20'
        : 'bg-gray-50 border-b dark:bg-gray-700'
        } justify-between items-center p-2 text-sm whitespace-pre`"
      >
        <div class="flex items-center justify-between w-full">
          <span
            class="font-bold text-gray-900 dark:text-gray-100"
          >{{ comment?.creator?.name ?? 'Unknown' }}</span>
          <div class="text-gray-400 dark:text-gray-400">
            <span>commented</span>
            {{ moment(comment.created_at).from(moment(), true) }}
          </div>
        </div>
      </div>
      <div class="px-4 py-2 ProseMirror max-w-none" v-html="comment.body" />
    </VCard>
  </div>
</template>

<script lang="ts" setup>
import moment from "moment";
import VCard from "./VCard.vue";

defineProps({
  comment: {
    type: Object,
    required: true,
  }
})
</script>
