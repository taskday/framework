<template>
  <div>
    <TransitionRoot as="template" :show="store.state.sidebar.isOpen">
      <Popover as="div" class="relative z-40 md:hidden" >
        <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
          <div class="fixed inset-0 bg-gray-600 dark:bg-gray-400 bg-opacity-10" />
        </TransitionChild>

        <div class="fixed inset-0 flex z-40">
          <div class="flex-shrink-0 absolute inset-0 " aria-hidden="true" @click="store.commit('sidebar/close')">
            <!-- Dummy element to force sidebar to shrink to fit close icon -->
          </div>
          <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="-translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="-translate-x-full">
            <div class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 background-200">
              <div class="flex-shrink-0 flex items-center px-4">
                <VLogo />
              </div>
              <div class="mt-5 flex-1 h-0 overflow-y-auto">
                <nav class="px-2 space-y-1">
                  <Link v-for="item in navigation" :onFinish="() => store.commit('sidebar/close')" :key="item.name" :href="item.href" :class="[item.current ? 'background-200' : '', 'group flex items-center px-2 py-2 text-base font-medium rounded-md']">
                    <component :is="item.icon" :class="[item.current ? '' : '', 'mr-4 flex-shrink-0 h-6 w-6']" aria-hidden="true" />
                    {{ item.name }}
                  </Link>
                  <hr>
                  <WorkspacesList />
                </nav>
              </div>
            </div>
          </TransitionChild>
        </div>
      </Popover>
    </TransitionRoot>

    <!-- Static sidebar for desktop -->
    <div v-show="store.state.sidebar.isOpen"  class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
      <!-- Sidebar component, swap this element with another sidebar if you like -->
      <div class="flex flex-col flex-grow border-r border-gray-400 dark:border-gray-600 background-400 overflow-y-auto">
        <div class="flex items-center flex-shrink-0 px-4 h-16 border-b">
          <VLogo /> <strong class="ml-3">Taskday</strong>
        </div>
        <div class="mt-5 flex-grow flex flex-col">
          <nav class="flex-1 px-2 pb-4">
            <Link v-for="item in navigation" :key="item.name" :href="item.href" :class="[item.current ? '' : '', 'group flex items-center px-2 py-2 text-sm font-medium rounded-md']">
              <VIcon :name="item.icon" :class="[item.current ? '' : '', 'mr-3 mb-1 flex-shrink-0 h-5 w-5']" aria-hidden="true" />
              {{ item.name }}
            </Link>
            <hr class="border-b my-4 border-gray-400 dark:border-gray-600">
            <WorkspacesList />
          </nav>
        </div>
      </div>
    </div>

    <div class="flex flex-col flex-1 overflow-y-auto h-screen" :class="{ 'md:pl-64': store.state.sidebar.isOpen  }">
      <div class="sticky top-0 z-10 flex-shrink-0 flex h-16 background-400 shadow">
        <button type="button" class="px-4 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" @click="() => store.commit('sidebar/toggle')">
          <span class="sr-only">Open sidebar</span>
          <VIcon name="sidebar-open" class="h-5 w-5" aria-hidden="true" />
        </button>
        <div class="flex-1 px-4 flex justify-between">
          <div class="flex-1 flex items-center">
            <label for="search-field" class="sr-only">Search</label>
            <div class="relative w-full max-w-sm">
              <VSearch />
            </div>
          </div>
          <div class="ml-4 flex items-center md:ml-6">
            <VPopover>
                <VPopoverButton class="rounded-full flex items-center justify-center h-8 w-8 px-0">
                  <div class="flex items-center w-6 h-6 justify-center">
                    <div class="relative">
                      <VIcon name="bell" class="h-4 w-4"></VIcon>
                      <span
                        v-if="$store.state.notifications.notifications.length > 0"
                        class="rounded-full bg-red-500 text-white font-semibold flex items-center justify-center h-2 w-2 absolute top-0 right-0"></span>
                    </div>
                  </div>
                </VPopoverButton>
                <VPopoverPanel>
                  <div class="p-2 overflow-x-hidden divide-y">
                    <div v-for="notification in $store.state.notifications.notifications" class="py-4">
                      <VNotification :notification="notification"/>
                    </div>
                    <div v-if="$store.state.notifications.notifications.length == 0">
                      <div class="text-center w-full">
                        <span class="text-sm">No new notifications.</span>
                      </div>
                    </div>
                  </div>
                </VPopoverPanel>
              </VPopover>

            <!-- Profile dropdown -->
            <VDropdown class="ml-4 relative flex-shrink-0">
              <VDropdownButton class="rounded-full w-8 h-8 px-0">
                <button type="button" class="bg-white rounded-full flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                  <span class="sr-only">Open user menu</span>
                  <VAvatar :user="$page.props.user"></VAvatar>
                </button>
              </VDropdownButton>


              <VDropdownItems>
                <VDropdownItem>
                  <Link class="flex w-full" :href="route('profile.show')">Your Profile</Link>
                </VDropdownItem>

                <VDropdownDivider />

                <VDropdownItem >
                  <Link class="flex w-full" method="post" :href="route('logout')">Logout</Link>
                </VDropdownItem>
              </VDropdownItems>
            </VDropdown>
          </div>
        </div>
      </div>

      <main class="flex-1">
        <div class="px-6 pt-6">
          <VBreadcrumbs :items="$page.props.breadcrumbs"></VBreadcrumbs>
        </div>
        <div class="py-6">
          <div class="">
            <!-- Replace with your content -->
            <slot></slot>
            <!-- /End replace -->
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'

import {
  Popover,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'

import { useStore } from 'vuex';
import WorkspacesList from './Partials/WorkspacesList.vue';

const navigation = [
  { name: 'Dashboard', href: route('dashboard'), icon: 'home', current: route().current('dashboard') },
  { name: 'Workspaces', href: route('workspaces.index'), icon: 'users', current: route().current('workspaces.index') },
  { name: 'Projects', href: route('projects.index'), icon: 'folder', current: route().current('projects.index') },
  { name: 'Cards', href: route('cards.index'), icon: 'files', current: route().current('cards.index') },
]

const userNavigation = [
  { name: 'Your Profile', href: '#' },
  { name: 'Settings', href: '#' },
  { name: 'Sign out', href: '#' },
]

const store = useStore();

onMounted(() => {
  store.dispatch('notifications/fetch')
  store.dispatch('notifications/listen')
})
</script>
