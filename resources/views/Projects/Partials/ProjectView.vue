<script lang="ts" setup>
import { Inertia } from "@inertiajs/inertia";
import { ref, watch, PropType } from "vue";
import useViews from "../useViews";

import {
  GlobeAltIcon,
  ExternalLinkIcon,
  ViewBoardsIcon,
  CogIcon,
  ShareIcon,
} from '@heroicons/vue/outline';

const props = defineProps({
  project: {
    type: Object as PropType<Project>,
    required: true,
  }
})

const { currentView, views, updateCurrentView } = useViews(props.project);

const share = ref(!!props.project.share_uuid);

watch(() => share.value, () => {
  Inertia.post(route('projects.share.update', props.project), { share: share.value });
})
</script>

<template>
  <div>
    <div class="flex flex-col xl:flex-row items-center justify-between gap-4 px-6 mb-4">
      <div>
        <slot name="title"></slot>
      </div>
      <div class="flex items-center justify-end gap-2">
        <VFormList :options="views" :selected="views.find((v) => v.id == currentView.id)" @change="updateCurrentView">
          <template #trigger="{ item }">
            <ViewBoardsIcon class="h-5 w-5 mr-1" />
            <span>{{ item.title ?? item.name }}</span>
          </template>
        </VFormList>
        <template v-if="project.id">
          <VButton variant="secondary" :href="route('projects.edit', project)">
            <VIcon name="cog"></VIcon>
            <span>Settings</span>
          </VButton>
          <VDropdown>
            <VDropdownButton>
              <ShareIcon class="h-5 w-5 mr-1" />
              <span>Share</span>
              <VIcon name="caret"></VIcon>
            </VDropdownButton>
            <VDropdownItems align="bottom-start">
              <div class="p-2">
                <ul class="space-y-3">
                  <li class="flex items-center gap-8">
                    <div class="flex items-center ">
                      <GlobeAltIcon class="h-5 w-5 mr-1" /> <span>Anyone with the link</span>
                    </div>
                    <VFormSwitch v-model="share" />
                  </li>
                  <li v-if="project.share_uuid" class="flex items-center gap-2">
                    <div class="text-sm w-full text-blue-600 hover:text-blue-500 dark:text-blue-300 hover:dark:text-blue-200">
                      <VFormInput readonly :modelValue="route('projects.share.show', project)" />
                    </div>
                    <a target="_blank" :href="route('projects.share.show', project)">
                      <ExternalLinkIcon class="h-5 w-5 mr-1" />
                    </a>
                  </li>
                </ul>
              </div>
            </VDropdownItems>
          </VDropdown>
        </template>
      </div>
    </div>
    <div :key="currentView">
      <component :is="currentView.component" :project="project"></component>
    </div>
  </div>
</template>
