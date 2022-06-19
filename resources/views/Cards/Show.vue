<template>
  <div class="h-full">
    <VPageHeader class="shadow-none px-6">
      <VBreadcrumb>
        <VBreadcrumbItem v-for="breadcrumb in breadcrumbs" :href="breadcrumb.url">
          {{ breadcrumb.title }}
        </VBreadcrumbItem>
      </VBreadcrumb>
      <div class="flex items-end justify-between">
        <div class="flex items-start">
          <VFormEdit v-model="state.title">
            <VPageTitle>{{ state.title }}</VPageTitle>
          </VFormEdit>
        </div>
        <div class="flex-col md:flex-row flex items-center gap-2">
          <VRoom :name="`App.Models.Card.${card.id}`"></VRoom>
          <div class="text-gray-700 dark:gray-400" v-show="state.recentlySuccessful">Saved.</div>
          <VButton
            variant="primary"
            v-if="state.isDirty || !state.processing" @click.prevent="() => update(card)"
          >
            Save
          </VButton>
          <VConfirm class="w-full" title="Are you sure?" :onConfirm="submit">
            <VButton variant="danger" class="w-full">Delete</VButton>
          </VConfirm>
        </div>
      </div>
    </VPageHeader>

    <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,56rem),1fr] gap-8">
      <div class="w-full p-6 space-y-8 order-1 lg:order-none">
        <div class="w-full order-1 md:order-none">
          <VCard>
            <VFormHtmlEditor v-model="state.content" />
          </VCard>
        </div>
        <form @submit.prevent="() => store(card)" class="space-y-8 w-full">
          <VCard>
            <VFormHtmlEditor placeholder="Add a comment..." :toolbar="false" v-model="comment.body"></VFormHtmlEditor>
          </VCard>
          <VButton type="submit">Submit</VButton>
        </form>
        <VCommentList :comments="card.comments" />
      </div>
      <div class="space-y-8 p-6">
        <div class="flex items-center space-x-2" v-for="field in card.project.fields" :key="field.id">
          <h4 class="font-semibold">{{ field.title }}:</h4>
          <VFieldWrapper :card="card" :field="field"></VFieldWrapper>
        </div>
      </div>
    </div>


  </div>
</template>

<script setup lang="ts">
import useCardForm from "@/composables/useCardForm";
import useCommentForm from "@/composables/useCommentForm";
import { onMounted } from "vue";

const { form: state, update, destroy } = useCardForm();
const { form: comment, store } = useCommentForm();

const props = defineProps<{
  title: String;
  breadcrumbs: Breadcrumb[];
  card: Card;
}>();

onMounted(() => {
  state.title = props.card.title;
  state.content = props.card.content;
});

function submit() {
  destroy(props.card);
}
</script>
