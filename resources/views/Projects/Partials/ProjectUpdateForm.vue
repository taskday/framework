<template>
  <VFormSection @submitted="() => update(project)">
    <template #title>Title</template>
    <template #description></template>
    <template #content>
      <VFormInput :errors="form.errors.title" label="Title" v-model="form.title"></VFormInput>
      <VFormInput :errors="form.errors.description" label="Description" v-model="form.description"></VFormInput>
    </template>
    <template #actions>
      <VButton type="submit">Save</VButton>
    </template>
  </VFormSection>
</template>

<script setup lang="ts">
import useProjectForm from "@/composables/useProjectFieldsForm";
import { onMounted } from "vue";

const props = defineProps<{ project: Project }>();

const { form, update, destroy } = useProjectForm();

onMounted(() => {
  form.title = props.project.title;
  form.description = props.project.description;
});
</script>
