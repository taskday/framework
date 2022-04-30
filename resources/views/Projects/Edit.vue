 <template>
  <div class="py-6 bg-white dark:bg-gray-800 shadow">
    <VContainer>
      <VBreadcrumb>
        <VBreadcrumbItem :href="route('workspaces.show', project.workspace)">
          {{ project.workspace.title }}
        </VBreadcrumbItem>
        <VBreadcrumbItem :href="route('projects.show', project)">
          {{ project.title }}
        </VBreadcrumbItem>
      </VBreadcrumb>
      <div class="flex items-end justify-between">
        <VPageTitle>Settings</VPageTitle>
      </div>
    </VContainer>
  </div>
  <VContainer>
    <div class="py-6 space-y-8">
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
  </VContainer>
</template>

<script lang="ts" setup>
import { onMounted } from "vue";

import ProjectUpdateForm from "./Partials/ProjectUpdateForm.vue";
import ProjectFieldsForm from "./Partials/ProjectFieldsForm.vue";
import ProjectMembersForm from "./Partials/ProjectMembersForm.vue";

defineProps<{
  title: string,
  workspace: Workspace
  project: Project
  fields: Field[]
  users: User[]
}>();
</script>
