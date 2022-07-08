<template>
  <div class="h-full max-w-6xl mx-auto">
    <VPageHeader>
      <template #title>
        <VFormEdit v-model="state.title">
          <VPageTitle>{{ state.title }}</VPageTitle>
        </VFormEdit>
      </template>
      <div class="text-gray-700 dark:text-gray-400 flex items-center" v-show="state.recentlySuccessful">Saved.</div>
      <VButton variant="primary" v-if="state.isDirty || !state.processing" @click.prevent="() => update(card)">
        Save
      </VButton>
      <VConfirm class="w-full" title="Are you sure?" :onConfirm="submit">
        <VButton variant="danger" class="w-full">Delete</VButton>
      </VConfirm>
    </VPageHeader>
  </div>

  <div class="h-full px-6 mt-8 max-w-6xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-[3fr,minmax(20rem,1fr)] gap-8">
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
                  <VFormHtmlEditor
                    placeholder="Add a comment..."
                    :toolbar="false"
                    v-model="comment.body"></VFormHtmlEditor>
                </VCard>
                <VFormInput type="file" @input="comment.attachments.push($event.target.files[0])" />
                <VButton type="submit">Submit</VButton>
              </form>
            </VTabsPanel>
            <VTabsPanel>
              <ul class="list-none">
                <li v-for="audit in audits">
                  <ul class="px-4 py-2 list-disc">
                    <li v-for="(old, key) in audit.old_values" class="relative overflow-visible">
                      <span class="font-semibold">{{ audit.user.name }}</span>
                      <component :old="old" :name="key" :audit="audit"  v-if="key == 'title'" :is="TitleAudit"></component>
                      <component :old="old" :name="key" :audit="audit"  v-if="key == 'content'" :is="ContentAudit"></component>
                      <component :old="old" :name="key" :audit="audit"  v-if="key == 'value'" :is="ValueAudit"></component>
                    </li>
                  </ul>
                </li>
              </ul>
            </VTabsPanel>
          </VTabsPanels>
        </VTabs>
      </div>
      <div>
        <VCard>
          <div class="inline-flex flex-col gap-8 w-full">
            <div class="flex items-center gap-2 h-9" v-for="field in card.project.fields" :key="field.id">
              <h4 class="font-semibold w-24 truncate dark:text-gray-400 text-sm">{{ field.title }}</h4>
              <VFieldWrapper :card="card" :field="field"></VFieldWrapper>
            </div>
          </div>
        </VCard>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { onMounted } from "vue";
import useCardForm from "@/composables/useCardForm";
import useCommentForm from "@/composables/useCommentForm";
import ContentAudit from './Audits/ContentAudit.vue';
import TitleAudit from './Audits/TitleAudit.vue';
import ValueAudit from './Audits/ValueAudit.vue';

const { form: state, update, destroy } = useCardForm();
const { form: comment, store } = useCommentForm();

const props = defineProps<{
  title: String;
  breadcrumbs: Breadcrumb[];
  card: Card;
  audits: Audit[];
}>();

onMounted(() => {
  state.title = props.card.title;
  state.content = props.card.content;
});

function submit() {
  destroy(props.card);
}
</script>
