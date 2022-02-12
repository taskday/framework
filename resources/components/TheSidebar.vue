<template>
  <div class="bg-white dark:bg-gray-800 overflow-y-auto">
    <div class="h-20 border-b flex items-center px-6">
      <Link href="/">
        <strong>Taskday</strong>
      </Link>
    </div>
    <VNav class="py-4 px-2 flex flex-col gap-2">
      <VNavLink class="px-2" :href="route('dashboard')">
        <div class="flex items-center">
          <ChartPieIcon class="h-5 w-5 text-black dark:text-gray-100" />
          <span class="ml-2">Dashboard</span>
        </div>
      </VNavLink>
      <VNavLink class="px-2" :href="route('workspaces.index')">
        <div class="flex items-center">
          <CollectionIcon class="h-5 w-5 text-black dark:text-gray-100" />
          <span class="ml-2">Workspaces</span>
        </div>
      </VNavLink>
      <VNavLink class="px-2" :href="route('cards.index')">
        <div class="flex items-center">
          <CollectionIcon class="h-5 w-5 text-black dark:text-gray-100" />
          <span class="ml-2">Cards</span>
        </div>
      </VNavLink>
      <VNavLink class="px-2" :href="route('fields.index')">
        <div class="flex items-center">
          <CollectionIcon class="h-5 w-5 text-black dark:text-gray-100" />
          <span class="ml-2">Fields</span>
        </div>
      </VNavLink>
    </VNav>

    <VNav class="px-2 py-4 flex flex-col gap-2">
      <VNavLink
        class="px-2"
        v-for="workspace in $page.props.global.workspaces"
        :href="route('workspaces.show', workspace)"
      >{{ workspace.title }}</VNavLink>
    </VNav>
  </div>
</template>

<script setup lang="ts">
import { ChartPieIcon, CollectionIcon, PlusIcon } from '@heroicons/vue/outline';
</script>
