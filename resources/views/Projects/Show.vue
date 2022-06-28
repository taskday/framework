<template>

  <VPageHeader>
    <VFormList :options="views" v-slot="{ item }" @change="updateCurrentView">
      <ViewBoardsIcon class="h-6 w-6 mr-2" />
      <span>{{ item.title }}</span>
    </VFormList>

    <VButton variant="secondary" :href="route('projects.edit', props.project)">
      <VIcon name="settings"/>
      <span>Settings</span>
    </VButton>

    <VDropdown>
      <VDropdownButton>
        <VIcon name="share" />
        <span>Share</span>
      </VDropdownButton>
      <VDropdownItems align="bottom-start">
        <div class="flex items-center justify-between gap-8 px-4 py-2">
          <div class="flex items-end gap-1 justify-between">
            <VIcon name="globe" class=""></VIcon>
            <span class="text-sm mt-1 whitespace-nowrap">Anyone with the link</span>
          </div>
          <VFormSwitch v-model="share" />
        </div>
        <div v-if="project.share_uuid" class="flex items-center px-4 py-2 gap-2">
          <div
            class="text-sm w-full text-blue-600 hover:text-blue-500 dark:text-blue-300 hover:dark:text-blue-200">
            <VFormInput readonly :modelValue="route('projects.share.show', project)" />
          </div>
          <a target="_blank" :href="route('projects.share.show', project)">
            <ExternalLinkIcon class="h-5 w-5 mr-1" />
          </a>
        </div>
      </VDropdownItems>
    </VDropdown>
  </VPageHeader>

  <div class="mt-8" :key="currentView">
    <component :is="currentView.component" :project="project"></component>
  </div>
</template>

<script setup lang="ts">
import { Switch } from "@headlessui/vue";
import { CogIcon, ViewBoardsIcon, ExternalLinkIcon, ShareIcon, GlobeAltIcon } from "@heroicons/vue/outline";
import { Inertia } from "@inertiajs/inertia";
import { ref, watch, onMounted, onUnmounted } from "vue";
import useViews from "./useViews";
import VButton from "../../components/VButton.vue";

let props = defineProps<{
  title: String;
  breadcrumbs: Breadcrumb[];
  project: Project;
}>();

onMounted(() => {
  window.Echo.private(`projects.${props.project.id}`).listen(".ProjectUpdatedEvent", function (e, data) {
    Inertia.get(route("projects.show", props.project), { replace: true });
  });
});

onUnmounted(() => {
  window.Echo.private(`projects.${props.project.id}`).stopListening(".ProjectUpdatedEvent");
});

const { currentView, views, updateCurrentView } = useViews(props.project);

const share = ref(!!props.project.share_uuid);

watch(
  () => share.value,
  () => {
    Inertia.post(route("projects.share.update", props.project), { share: share.value });
  }
);
</script>
