<template>
  <div class="w-full">
    <VCard class="overflow-hidden">
      <template #header>
        <div :class="`h-10 flex ${comment?.creator?.name === $page.props.user.name
          ? 'bg-blue-50 border-b dark:bg-blue-400 dark:text-blue-400 dark:bg-opacity-20'
          : 'bg-gray-50 border-b dark:bg-gray-700'
          } justify-between items-center text-sm whitespace-pre px-4 py-3 sm:px-6`"
        >
          <div class="flex items-center justify-between w-full">
            <span
              class="font-bold text-gray-900 dark:text-gray-100"
            >{{ comment?.creator?.name ?? 'Unknown' }}</span>
            <div class="text-gray-400 dark:text-gray-400">
              <span>commented</span>
              {{ moment(comment.created_at).from(moment(), true) }}
            </div>
            <button v-if="!value && comment?.creator?.id === $page.props.auth.user.id" @click="toggle">Edit</button>
            <button v-if="value && comment?.creator?.id === $page.props.auth.user.id" @click="toggle">Save</button>
          </div>
        </div>
      </template>
      <div v-if="!value" v-html="comment.body" />
      <div v-if="value && comment?.creator?.id === $page.props.auth.user.id">
        <VFormHtmlEditor v-model="comment.body"></VFormHtmlEditor>
      </div>
    </VCard>
  </div>
</template>

<script lang="ts" setup>
import moment from "moment";
import VCard from "./VCard.vue";
import { useToggle } from '@vueuse/core'
import { PropType, watch } from "vue";
import useCommentForm from '@/composables/useCommentForm';

let props = defineProps({
  comment: {
    type: Object as PropType<Comment>,
    required: true,
  }
})

const { form, update } = useCommentForm()
const [value, toggle] = useToggle()

watch(() => value.value, () => {
  if (!value.value) {
    form.body = props.comment.body;
    update(props.comment.commentable_id, props.comment)
  }
})

</script>
