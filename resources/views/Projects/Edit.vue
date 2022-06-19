 <template>
  <VPageHeader>
    <VBreadcrumb>
      <VBreadcrumbItem v-for="breadcrumb in breadcrumbs" :href="breadcrumb.url">
        {{ breadcrumb.title }}
      </VBreadcrumbItem>
    </VBreadcrumb>
    <VPageTitle>{{ title }}</VPageTitle>
  </VPageHeader>
  <div class="p-6 space-y-8">
    <div class="flex flex-col w-full space-y-16">
      <ProjectUpdateForm :project="project" />

      <ProjectFieldsForm :project="project" :fields="fields" />

      <ProjectMembersForm :users="users" :project="project"/>

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
</template>

<script lang="ts" setup>
import ProjectUpdateForm from "./Partials/ProjectUpdateForm.vue";
import ProjectFieldsForm from "./Partials/ProjectFieldsForm.vue";
import ProjectMembersForm from "./Partials/ProjectMembersForm.vue";
import useProjectForm from "@/composables/useProjectForm";

defineProps<{
  title: string,
  breadcrumbs: Breadcrumb[]
  workspace: Workspace
  project: Project
  fields: Field[]
  users: User[]
}>();

const { destroy } = useProjectForm();
</script>
