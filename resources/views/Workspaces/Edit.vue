<template>
  <VPageHeader>
    <VContainer>
      <VBreadcrumb>
        <VBreadcrumbItem v-for="breadcrumb in breadcrumbs" :href="breadcrumb.href">
          {{ breadcrumb.name }}
        </VBreadcrumbItem>
      </VBreadcrumb>
      <div class="flex items-center justify-between">
        <VPageTitle>{{ title }}</VPageTitle>
      </div>
    </VContainer>
  </VPageHeader>

  <VContainer>
    <div class="py-6 space-y-8">
      <div class="flex flex-col w-full space-y-16">
        <VFormSection @submitted="() => update(workspace)">
          <template #title>Title</template>
          <template #description>You can edit info about this workspace.</template>
          <template #content>
            <VFormInput :errors="form.errors.title" label="Title" v-model="form.title"></VFormInput>
          </template>
          <template #actions>
            <VButton type="submit">Save</VButton>
          </template>
        </VFormSection>

        <VFormSection>
          <template #title>Delete Project</template>
          <template #description>This will delete this project.</template>
          <template #content>You cannot undo this action.</template>
          <template #actions>
            <VConfirm :onConfirm="submit">
              <VButton variant="danger">Delete</VButton>
            </VConfirm>
          </template>
        </VFormSection>
      </div>
    </div>
  </VContainer>
</template>

<script setup lang="ts">
//@ts-ignore
import useWorkspaceForm from "@/composables/useWorkspaceForm";
import { onMounted } from "vue";

let props = defineProps<{
  title: string;
  workspace: Workspace;
  breadcrumbs: Breadcrumb[];
}>();

const { form, update, destroy } = useWorkspaceForm();

onMounted(() => {
  form.title = props.workspace.title;
  form.description = props.workspace.description;
});

function submit() {
  destroy(props.workspace);
}
</script>
