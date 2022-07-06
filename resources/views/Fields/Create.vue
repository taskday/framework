<template>
  <div>
    <VPageHeader />
    <VContainer>
      <div class="mt-8 space-y-8">
        <VFormSection @submitted="submit">
          <template #title>Nuovo field</template>
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
import useFieldForm from '@/composables/useFieldForm';
import { useForm } from '@inertiajs/inertia-vue3';
import Form from './Form.vue';

const props = defineProps<{ title: string, field: Field }>()

const { form, store } = useFieldForm()

function submit() {
  store()
}
</script>
