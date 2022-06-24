<script lang="ts" setup>
import { Inertia } from "@inertiajs/inertia";
import { ref, watch, PropType } from "vue";
import useViews from "../useViews";
import { Switch } from '@headlessui/vue';
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
    <div class="flex flex-col px-6 space-y-3">
      <div class="flex w-full justify-between">
        <VFormList :options="views" :selected="views.find((v) => v.id == currentView.id)" @change="updateCurrentView">
          <template #trigger="{ item }">
            <ViewBoardsIcon class="h-5 w-5 mr-1" />
            <span>{{ item.title ?? item.name }}</span>
          </template>
        </VFormList>
        <div class="flex items-center gap-2" v-if="project.id">
          <Link :href="route('projects.edit', project)" class="flex text-sm items-center hover:text-blue-600 dark:hover:text-blue-200 p-1 px-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
            <CogIcon class="h-5 w-5 mr-1" ></CogIcon>
            <span>Settings</span>
          </Link>
          <VDropdown>
            <VDropdownButton
              class="flex text-sm items-center hover:text-blue-600 dark:hover:text-blue-200 h-8 px-3 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg"
            >
              <ShareIcon class="h-5 w-5 mr-1" /> Share
            </VDropdownButton>
            <VDropdownItems align="bottom-start">
              <div class="p-2">
                <ul class="space-y-3">
                  <li class="flex items-center gap-8">
                    <div class="flex items-center ">
                      <GlobeAltIcon class="h-5 w-5 mr-1" /> <span>Anyone with the link</span>
                    </div>
                    <Switch
                      v-model="share"
                      :class="share ? 'bg-green-600' : 'bg-blue-700'"
                      class="relative inline-flex flex-shrink-0 h-6 w-10 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
                    >
                      <span class="sr-only">Use setting</span>
                      <span
                        aria-hidden="true"
                        :class="share ? 'translate-x-4' : 'translate-x-0'"
                        class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow-lg transform ring-0 transition ease-in-out duration-200"
                      />
                    </Switch>
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
      </div>
    </div>
    <div class="h-full py-6" :key="currentView">
      <component :is="currentView.component" :project="project"></component>
    </div>
  </div>
</template>
