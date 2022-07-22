<script lang="ts" setup>
import { Inertia } from "@inertiajs/inertia";
import { ref, watch, PropType } from "vue";
import useViews from "../useViews";

import {
  GlobeAltIcon,
  ExternalLinkIcon,
  ViewBoardsIcon,
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
    <div class="flex flex-col items-start w-full gap-4 mb-4">
      <div class="px-6">
        <slot name="title"></slot>
      </div>
      <VTabs :selectedIndex="0">
        <VTabsList class="px-6">
          <VTabsItem v-for="view in views">
            <div class="flex [&>span+span]:ml-2">
              <ViewBoardsIcon class="h-5 w-5 mr-1" />
              <span>{{ view.title ?? view.name }}</span>
            </div>
          </VTabsItem>
        </VTabsList>
        <VTabsPanels>
          <VTabsPanel v-for="view in views">
            <div class="flex flex-col w-full">
              <div v-if="project.id" class="flex items-center justify-end gap-2 px-6 mb-4">
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
              </div>
              <component :is="view.component" :project="project"></component>
            </div>
          </VTabsPanel>
        </VTabsPanels>
      </VTabs>
    </div>
  </div>
</template>
