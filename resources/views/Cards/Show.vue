<template>
  <VPageHeader>
    <template #title>
      <VFormEdit v-model="state.title">
        <VPageTitle>{{ state.title }}</VPageTitle>
      </VFormEdit>
    </template>
    <div class="text-gray-700 dark:gray-400" v-show="state.recentlySuccessful">Saved.</div>
    <VButton variant="primary" v-if="state.isDirty || !state.processing" @click.prevent="() => update(card)">
      Save
    </VButton>
    <VConfirm class="w-full" title="Are you sure?" :onConfirm="submit">
      <VButton variant="danger" class="w-full">Delete</VButton>
    </VConfirm>
  </VPageHeader>

  <div class="h-full px-6 mt-8">
    <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,56rem),1fr] gap-8">
      <div class="w-full space-y-8 order-1 lg:order-none">
        <div class="w-full order-1 md:order-none">
          <VCard>
            <VFormHtmlEditor v-model="state.content" />
          </VCard>
        </div>
        <VTabs>
          <VTabsList>
            <VTabsItem>Comments</VTabsItem>
            <VTabsItem>Activites</VTabsItem>
          </VTabsList>
          <VTabsPanels>
            <VTabsPanel>
              <VCommentList class="mb-8" :card="card" :comments="card.comments" />
              <form @submit.prevent="() => store(card)" class="space-y-8 w-full">
                <VCard>
                  <VFormHtmlEditor placeholder="Add a comment..." :toolbar="false" v-model="comment.body"></VFormHtmlEditor>
                </VCard>
                <VFormInput type="file" @input="comment.attachments.push($event.target.files[0])" />
                <VButton type="submit">Submit</VButton>
              </form>
            </VTabsPanel>
            <VTabsPanel>
              <ul class="list-none">
                <li v-for="audit in audits">
                    <ul class="px-4 py-2 list-disc">
                      <li v-for="old,key in audit.old_values">
                        <strong>{{ audit.user.name }}</strong> {{ audit.event }} {{ key }} from
                        <span class="font-bold">
                          <span v-if="key == 'content'" class="ProseMirror" v-html="old"></span>
                          <span v-else v-text="old"></span>
                        </span>
                        to
                        <span class="font-bold">
                          <span v-if="key == 'content'" class="ProseMirror" v-html="audit.new_values[key]"></span>
                          <span v-else v-text="audit.new_values[key]"></span>
                        </span>
                      </li>
                    </ul>
                </li>
              </ul>
            </VTabsPanel>
          </VTabsPanels>
        </VTabs>
      </div>
      <div class="flex flex-col gap-8">
        <div class="flex items-center gap-2 h-9" v-for="field in card.project.fields" :key="field.id">
          <h4 class="font-semibold w-24 truncate dark:text-gray-400 text-sm">{{ field.title }}</h4>
          <VFieldWrapper :cardb="card" :field="field"></VFieldWrapper>
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
  audits: any[];
}>();

onMounted(() => {
  state.title = props.card.title;
  state.content = props.card.content;
});

function submit() {
  destroy(props.card);
}
</script>
