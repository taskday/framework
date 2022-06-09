<template>
  <div>
    <VPageHeader class="shadow-none px-6">
      <VBreadcrumb>
        <VBreadcrumbItem v-for="breadcrumb in breadcrumbs" :href="breadcrumb.url">
          {{ breadcrumb.title }}
        </VBreadcrumbItem>
      </VBreadcrumb>
      <div class="flex items-center justify-between">
        <VPageTitle>{{ props.title }}</VPageTitle>
        <div class="flex items-center gap-2">
          <VButton :href="route('workspaces.projects.create', workspace)" class="flex items-center justify-center">
            <PlusIcon class="h-5 w-5" />
            <span class="ml-2">New project</span>
          </VButton>
          <div v-show="form.recentlySuccessful">Saved.</div>
          <VButton :disabled="!form.isDirty || form.processing" @click.prevent="submit">Save</VButton>
          <VButton variant="secondary" :href="route('workspaces.edit', workspace)">
            <CogIcon class="h-5 w-5" />
            <span class="ml-2">Settings</span>
          </VButton>
        </div>
      </div>
    </VPageHeader>
    <div class="my-8 px-6 space-y-8">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 [&>*]:min-h-[100px]">
        <VCard v-for="project in workspace.projects">
          <div class="flex flex-col items-start justify-between w-full gap-4 overflow-wrap">
            <div>
              <Link class="text-base hover:underline" :href="route('projects.show', project)">
                {{ project.title }}
              </Link>
              <div v-if="project.description" class="text-sm text-gray-800">
                {{ project.description }}
              </div>
            </div>
            <span class="text-sm text-gray-600 dark:text-gray-400">
              updated {{ moment(project.updated_at).fromNow() }}
            </span>
          </div>
        </VCard>
      </div>
      <hr class="border dark:border-gray-700">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div>
          <VCard>
            <VFormHtmlEditor v-model="form.description" />
          </VCard>
        </div>
        <div class="flex flex-col space-y-4">
          <template v-for="project in workspace.projects">
            <div v-if="project.comments.length > 0" v-for="comment in project.comments" style="overflow-wrap: anywhere">
              <div class="flex gap-2 items-start flex-shrink-0">
                <VAvatar :user="comment.creator" />
                <div>
                  <p>
                    <span class="inline-flex gap-2"> commented on </span> "<Link
                      class="underline"
                      style="overflow-wrap: anywhere"
                      :href="route('cards.show', comment.commentable)"
                      >{{ comment.commentable.title }}</Link
                    >"
                  </p>
                  <div class="prose text-gray-700 dark:text-gray-300 mt-2 line-clamp-2" v-html="comment.body"></div>
                </div>
              </div>
            </div>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import moment from "moment";
import { onMounted } from "vue";
import { CogIcon, PlusIcon } from "@heroicons/vue/outline";
import useWorkspaceForm from "@/composables/useWorkspaceForm";
import useWarnBeforeLeave from "@/composables/useWarnBeforeLeave";

const props = defineProps<{
  title: String;
  breadcrumbs: {
    name: String;
    href: String;
  }[];
  workspace: Workspace;
}>();

const { form, update } = useWorkspaceForm();

const { enable, disable } = useWarnBeforeLeave(() => {
  return form.description != props.workspace.description;
});

onMounted(() => {
  enable();
  form.title = props.workspace.title;
  form.description = props.workspace.description;
});

function submit() {
  disable();
  update(props.workspace, {
    onFinish: () => enable(),
  });
}
</script>
