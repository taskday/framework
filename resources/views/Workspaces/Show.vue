<template>
  <div>
    <VPageHeader class="shadow-none">
      <VContainer>
        <div class="flex items-center justify-between">
          <VPageTitle>{{ props.title }}</VPageTitle>
          <div class="flex items-center gap-2">
            <div v-show="form.recentlySuccessful">Saved.</div>
            <VButton :disabled="!form.isDirty || form.processing" @click.prevent="submit">Save</VButton>
            <VButton variant="secondary" :href="route('workspaces.edit', workspace)">
              <CogIcon class="h-5 w-5" />
            </VButton>
          </div>
        </div>
      </VContainer>
    </VPageHeader>
    <div class>
      <VTabs>
        <VTabsList>
          <VTabsItem>Readme</VTabsItem>
          <VTabsItem>Projects</VTabsItem>
        </VTabsList>
        <VContainer>
          <VTabsPanels>
            <VTabsPanel class="pt-6 pb-10">
              <VCard>
                <VFormHtmlEditor v-model="form.description" />
              </VCard>
            </VTabsPanel>
            <VTabsPanel class="pt-6 pb-10">
              <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <VCard v-for="project in workspace.projects">
                  <div class="flex items-center justify-between w-full">
                    <VLink variant="secondary" :href="route('projects.show', project)">
                      <span class="text-lg font-medium">{{ project.title }}</span>
                    </VLink>
                    <span
                      class="text-sm text-gray-600"
                    >updated {{ moment(project.updated_at).fromNow() }}</span>
                  </div>
                  <ul class="flex flex-col gap-1 mt-2">
                    <li
                      v-for="activity in [...project.cards.flatMap(c => c.activities)]"
                      class="block text-gray-600 dark:text-gray-400 gap-2"
                    >
                      <span class="inline-block">
                        <VAvatar :user="activity.causer" />
                      </span>
                      {{ activity.event + ' ' + activity.subject_type.replace('App\\Models\\', '').toLowerCase() }}
                      <Link
                        :href="activity.subject.link"
                        class="text-blue-600 dark:text-blue-300 hover:underline inline break-words"
                      >{{ activity.subject.title }}</Link>
                    </li>
                  </ul>
                </VCard>
                <VCard>
                  <VLink
                    :href="route('workspaces.projects.create', workspace)"
                    class="flex items-center justify-center"
                  >
                    <PlusIcon class="h-6 w-6" />
                  </VLink>
                </VCard>
              </div>
            </VTabsPanel>
          </VTabsPanels>
        </VContainer>
      </VTabs>
    </div>
  </div>
</template>

<script setup lang="ts">
import moment from 'moment';
import { onMounted } from 'vue';
import { CogIcon, PlusIcon } from '@heroicons/vue/outline';
import useWorkspaceForm from '@/composables/useWorkspaceForm';
import useWarnBeforeLeave from '@/composables/useWarnBeforeLeave';

const props = defineProps<{
  title: String,
  breadcrumbs: {
    name: String,
    href: String,
  }[]
  workspace: Workspace
}>()

const { form, update } = useWorkspaceForm({
  title: props.workspace.title,
  description: props.workspace.description
});

const { enable, disable } = useWarnBeforeLeave(() => {
  return form.isDirty;
});

onMounted(() => {
  enable();
})

function submit() {
  update(props.workspace, {
    onBefore: () => disable(),
    onFinish: () => enable()
  })
}

</script>
