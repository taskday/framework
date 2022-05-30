<template>
  <div>
    <VPageHeader>
      <VContainer>
        <VBreadcrumb>
          <VBreadcrumbItem v-for="breadcrumb in breadcrumbs" :href="breadcrumb.url">
            {{ breadcrumb.title }}
          </VBreadcrumbItem>
        </VBreadcrumb>
        <div class="flex items-start justify-between w-full gap-4">
          <div class="w-full">
            <div class="flex flex-col items-start justify-start gap-4 w-full">
              <div class="flex items-start gap-4 shrink-0 w-full">
                <VFormEdit v-model="state.title">
                  <VPageTitle>{{ state.title }}</VPageTitle>
                </VFormEdit>
                <div class="text-gray-700 dark:gray-400" v-show="state.recentlySuccessful">Saved.</div>
              </div>
              <VRoom :name="`App.Models.Card.${card.id}`"></VRoom>
            </div>
          </div>
          <div class="flex-col md:flex-row flex items-center gap-2">
            <VButton variant="primary" v-if="state.isDirty || !state.processing" @click.prevent="() => update(card)"
              >Save</VButton
            >
            <VConfirm class="w-full" title="Are you sure?" :onConfirm="submit">
              <VButton variant="danger" class="w-full">Delete</VButton>
            </VConfirm>
          </div>
        </div>
      </VContainer>
    </VPageHeader>

    <div class="py-6">
      <VContainer>
        <div class="flex flex-col md:flex-row gap-8">
          <div class="w-full max-w-3xl order-1 md:order-none">
            <VCard>
              <VFormHtmlEditor v-model="state.content" />
            </VCard>
          </div>
          <div class="space-y-8">
            <div class="flex items-center space-x-2" v-for="field in card.project.fields" :key="field.id">
              <h4 class="font-semibold">{{ field.title }}:</h4>
              <VFieldWrapper :card="card" :field="field"></VFieldWrapper>
            </div>
          </div>
        </div>
      </VContainer>
      <VContainer>
        <div class="w-full max-w-3xl space-y-10 mt-10">
          <div class="space-y-8">
            <VPageTitle>Comment</VPageTitle>
            <form @submit.prevent="() => store(card)" class="space-y-8">
              <VCard>
                <VFormHtmlEditor :toolbar="false" v-model="comment.body"></VFormHtmlEditor>
              </VCard>
              <VButton type="submit">Submit</VButton>
            </form>
          </div>
          <VPageTitle>Comments</VPageTitle>
          <VCommentList :comments="card.comments" />
        </div>
      </VContainer>
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
