<template>
  <div class="py-6 bg-white dark:bg-gray-800 shadow">
    <VContainer>
      <div class="flex items-end justify-between">
        <div class="flex flex-col">
          <VBreadcrumb>
            <VBreadcrumbItem :href="route('workspaces.show', project.workspace)">
              {{ project.workspace.title }}
            </VBreadcrumbItem>
            <VBreadcrumbItem :href="route('projects.show', project)">
              {{ project.title }}
            </VBreadcrumbItem>
          </VBreadcrumb>
          <VPageTitle>Settings</VPageTitle>
        </div>
      </div>
    </VContainer>
  </div>
  <VContainer>
    <div class="py-6 space-y-8">
      <div class="flex flex-col w-full space-y-16">
        <VFormSection @submitted="() => update(project)">
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
          <template #title>Fields</template>
          <template
            #description
          >Gallia est omnis divisa in partes tres, quarum. Donec sed odio operae, eu vulputate felis rhoncus. Praeterea iter est quasdam res quas ex communi.</template>
          <template #content>
            <ProjectFieldsForm :project="project" :fields="fields" />
          </template>
        </VFormSection>

        <!-- <VFormSection @submitted="submitMembers">
          <template #title>Member</template>
          <template #description>All members of this workspace</template>
          <template #content>
            <project-members-form :users="users" :project="project" :form="formMembers" />
          </template>
          <template #actions>
            <VButton type="submit">Save</VButton>
          </template>
        </VFormSection> -->

        <VFormSection>
          <template #title>Delete Project</template>
          <template #description>This will delete this project.</template>
          <template #content>You cannot undo this action.</template>
          <template #actions>
            <VConfirm variant="danger" :onConfirm="() => destroy(project)">
              <VButton variant="danger">Delete</VButton>
            </VConfirm>
          </template>
        </VFormSection>
      </div>
    </div>
  </VContainer>
</template>

<script lang="ts">
import AppLayoutNoSidebarVue from '@/layouts/AppLayoutNoSidebar.vue';
export default {
  layout: AppLayoutNoSidebarVue
}
</script>

<script lang="ts" setup>
import { onMounted } from "vue";
import useProjectForm from "@/composables/useProjectForm";
import ProjectFieldsForm from "./ProjectFieldsForm.vue";

const { form, update, destroy } = useProjectForm();

const props = defineProps<{
  title: string,
  workspace: Workspace
  project: Project
  fields: Field[]
  users: User[]
}>();

onMounted(() => {
  form.title = props.project.title;
  form.description = props.project.description;
})
</script>
