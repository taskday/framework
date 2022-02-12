<template>
  <div class="py-6 bg-white dark:bg-gray-800 shadow">
    <VContainer>
      <div class="flex items-center justify-between">
        <VPageTitle>{{ title }}</VPageTitle>
        <div>
          <VButton variant="secondary" :href="route('workspaces.edit', workspace)">
            <CogIcon class="h-5 w-5" />
          </VButton>
        </div>
      </div>
    </VContainer>
  </div>
  <VContainer>
    <div class="py-6 space-y-8">
      <div class="flex flex-col w-full space-y-16">
        <VFormSection @submitted="() => update(workspace)">
          <template #title>Title</template>
          <template #description></template>
          <template #content>
            <VFormInput label="Title" v-model="form.title"></VFormInput>
            <VFormInput label="Description" v-model="form.description"></VFormInput>
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
import useWorkspaceForm from '@/composables/useWorkspaceForm';
import { CogIcon } from '@heroicons/vue/outline';
import { onMounted } from 'vue';

let props = defineProps<{
  title: string,
  workspace: Workspace
}>()

const { form, update, destroy } = useWorkspaceForm();

onMounted(() => {
  form.title = props.workspace.title
  form.description = props.workspace.description
})

function submit() {
  destroy(props.workspace)
}
</script>
