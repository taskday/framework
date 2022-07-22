<script lang="ts" setup>
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import { useModels } from '@/composables/useModels';
import { ref, reactive, onMounted, computed, watchEffect } from 'vue';

const { models, pagination, actions } = useModels<Workspace, { }>(route('api.workspaces.index'));

onMounted(() => actions.fetch());
</script>

<template>
  <div>
    <Disclosure v-for="workspace in models?.data" :key="Math.random()">
      <DisclosureButton class="p-2 text-sm" :class="{
        'text-blue-400 dark:text-blue-300': route().current('workspaces.show', workspace)
      }">
        # <Link :onFinish="$forceUpdate" :href="route('workspaces.show', workspace)">{{ workspace.title }}</Link>
      </DisclosureButton>
      <DisclosurePanel class="border-l ml-2 background-200">
        <nav class="space-y-1 py-1" aria-label="Sidebar">
          <Link v-for="item in workspace.projects" :key="item.title" :href="route('projects.show', item)" :class="['flex items-center px-2 py-1 text-sm font-medium rounded-md']">
            <span class="truncate">
              {{ item.title }}
            </span>
          </Link>
        </nav>
      </DisclosurePanel>
    </Disclosure>
    <div class="p-2 text-sm">
      <button v-if="models?.total > models?.data?.length" class="underline" @click="pagination.loadMore()">Load more...</button>
    </div>
  </div>
</template>
