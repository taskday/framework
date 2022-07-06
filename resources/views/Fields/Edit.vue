<template>
  <VPageHeader />
  <VContainer>
    <div class="mt-8 space-y-8">
      <VFormSection @submitted="submit">
        <template #title>Edit field</template>
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
</template>

<script setup lang="ts">
import useFieldForm from "@/composables/useFieldForm";
import { onMounted } from "vue";
import Form from "./Form.vue";

const props = defineProps<{ field: Field; breadcrumbs: Breadcrumb[] }>();

const { form, update } = useFieldForm();

onMounted(() => {
  form.title = props.field.title;
  form.handle = props.field.handle;
  form.type = props.field.type;
  form.options = props.field.options;
});

function submit() {
  update(props.field);
}
</script>
