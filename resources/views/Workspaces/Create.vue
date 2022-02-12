<template>
  <div>
    <div class="py-6 bg-white dark:bg-gray-800 shadow">
      <VContainer>
        <VPageTitle>{{ title }}</VPageTitle>
      </VContainer>
    </div>
    <VContainer>
      <div class="mt-8 space-y-8">
        <VFormSection @submitted="submit">
          <template #title>New Workspace</template>
          <template #description>Create a new field to start.</template>
          <template #content>
            <Form :form="form" :fields="[]" />
          </template>
          <template #actions>
            <VButton submit>Submit</VButton>
          </template>
        </VFormSection>
      </div>
    </VContainer>
  </div>
</template>

<script setup lang="ts">
import useWorkspaceForm from '@/composables/useWorkspaceForm';
import Form from './Form.vue';

defineProps<{ title: string, field: Field }>()

const { form, store } = useWorkspaceForm({ title: '' });

function submit() {
  store()
}
</script>
