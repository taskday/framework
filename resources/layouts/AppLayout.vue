<template>
<div class="min-h-full background-500">
  <header class="shadow background-300">
    <div class="w-full mx-auto px-2 sm:px-4 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex px-2 lg:px-0">
          <div class="flex-shrink-0 flex items-center">
            <a href="#">
              <VLogo />
            </a>
          </div>
          <nav aria-label="Global" class="hidden lg:ml-6 lg:flex lg:items-center lg:space-x-4">
            <Link :href="route('dashboard')" class="px-3 py-2 text-gray-900 dark:text-gray-200 text-sm font-medium"> Dashboard </Link>
            <Link :href="route('workspaces.index')" class="px-3 py-2 text-gray-900 dark:text-gray-200 text-sm font-medium"> Workspaces </Link>
            <Link :href="route('projects.index')" class="px-3 py-2 text-gray-900 dark:text-gray-200 text-sm font-medium"> Projects </Link>
            <Link :href="route('cards.index')" class="px-3 py-2 text-gray-900 dark:text-gray-200 text-sm font-medium"> Cards </Link>
            <Link v-if="can('view fields')" :href="route('fields.index')" class="px-3 py-2 text-gray-900 dark:text-gray-200 text-sm font-medium"> Fields </Link>
          </nav>
        </div>
        <div class="flex-1 flex items-center justify-center px-2 lg:ml-6 lg:justify-end">
          <div class="max-w-lg w-full lg:max-w-xs">
            <VSearch />
          </div>
        </div>
        <div class="flex items-center lg:hidden">
          <!-- Mobile menu button -->
          <button @click="$store.commit('sidebar/toggle')" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <!-- Heroicon name: outline/menu -->
            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>

        <!-- Mobile menu, show/hide based on mobile menu state. -->
        <div class="lg:hidden" v-show="$store.state.sidebar.isOpen">
          <transition
            enter-active-class="duration-150 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="duration-150 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
          >
            <div class="z-20 fixed inset-0 bg-black bg-opacity-25" aria-hidden="true"></div>
          </transition>

          <transition
            enter-active-class="duration-150 ease-out"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="duration-150 ease-in"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
          >
            <div v-show="$store.state.sidebar.isOpen"  class="z-30 absolute top-0 right-0 max-w-none w-full p-2 transition transform origin-top">
              <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                <div class="pt-3 pb-2">
                  <div class="flex items-center justify-between px-4">
                    <div>
                      <VLogo />
                    </div>
                    <div class="-mr-2">
                      <button type="button" @click="$store.commit('sidebar/close')" class="bg-white dark:bg-gray-700 rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                        <span class="sr-only">Close menu</span>
                        <!-- Heroicon name: outline/x -->
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                      </button>
                    </div>
                  </div>
                  <div class="mt-3 px-2 space-y-1">
                    <Link :onFinish="() => $store.commit('sidebar/close')" :href="route('dashboard')" class="block rounded-md px-3 py-2 text-base text-gray-900 dark:text-gray-200 font-medium hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-800 dark:hover:text-gray-200"> Dashboard </Link>
                    <Link :onFinish="() => $store.commit('sidebar/close')" :href="route('workspaces.index')" class="block rounded-md px-3 py-2 text-base text-gray-900 dark:text-gray-200 font-medium hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-800 dark:hover:text-gray-200"> Workspaces </Link>
                    <Link :onFinish="() => $store.commit('sidebar/close')" :href="route('projects.index')" class="block rounded-md px-3 py-2 text-base text-gray-900 dark:text-gray-200 font-medium hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-800 dark:hover:text-gray-200"> Projects </Link>
                    <Link :onFinish="() => $store.commit('sidebar/close')" :href="route('cards.index')" class="block rounded-md px-3 py-2 text-base text-gray-900 dark:text-gray-200 font-medium hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-800 dark:hover:text-gray-200"> Cards </Link>
                    <Link v-if="can('view fields')" :onFinish="() => $store.commit('sidebar/close')" :href="route('fields.index')" class="block rounded-md px-3 py-2 text-base text-gray-900 dark:text-gray-200 font-medium hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-800 dark:hover:text-gray-200"> Fields </Link>
                  </div>
                </div>
                <div class="pt-4 pb-2">
                  <div class="flex items-center px-5">
                    <div class="flex-shrink-0">
                      <VAvatar :user="$page.props.user"></VAvatar>
                    </div>
                    <div class="ml-3">
                      <div class="text-base font-medium text-gray-800 dark:text-gray-200">{{ $page.props.user.name }}</div>
                      <div class="text-sm font-medium text-gray-500">{{ $page.props.user.email }}</div>
                    </div>
                  </div>
                  <div class="mt-3 px-2 space-y-1">
                    <Link :onFinish="() => $store.commit('sidebar/close')"  :href="route('profile.show')" class="block rounded-md px-3 py-2 text-base text-gray-900 dark:text-gray-200 font-medium hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-800 dark:hover:text-gray-200">Your Profile</Link>
                    <Link :onFinish="() => $store.commit('sidebar/close')" as="button"  method="post" :href="route('logout')" class="block w-full rounded-md px-3 py-2 text-base text-gray-900 dark:text-gray-200 font-medium hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-800 dark:hover:text-gray-200">Sign out</Link>
                  </div>
                </div>
              </div>
            </div>
          </transition>
        </div>

        <div class="hidden lg:ml-4 lg:flex lg:items-center">
          <VPopover>
            <VPopoverButton class="rounded-full h-8 w-8">
              <div class="flex items-center w-6 h-6 justify-center">
                <div class="relative">
                  <VIcon name="bell"></VIcon>
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
            <VDropdownButton class="rounded-full w-8 h-8">
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

    <div class="w-full mx-auto px-4 sm:px-6">
      <div class="border-t border-gray-200 dark:border-gray-600 py-3">
        <nav class="flex" aria-label="Breadcrumb">
          <div class="flex sm:hidden">
            <a v-if="$page.props.breadcrumbs?.at(-1)" :href="$page.props.breadcrumbs?.at(-1).url" class="group inline-flex space-x-3 text-sm font-medium text-gray-500 hover:text-gray-700">
              <!-- Heroicon name: solid/arrow-narrow-left -->
              <svg class="flex-shrink-0 h-5 w-5 text-gray-400 group-hover:text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
              </svg>
              <span>Back to {{ $page.props.breadcrumbs.at(-1).title }}</span>
            </a>
          </div>
          <div class="hidden sm:block">
            <ol role="list" class="flex items-center space-x-4">
              <li>
                <div>
                  <Link href="/" class="text-gray-400 hover:text-gray-500">
                    <!-- Heroicon name: solid/home -->
                    <svg class="flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                    <span class="sr-only">Home</span>
                  </Link>
                </div>
              </li>

              <li v-for="item in $page.props.breadcrumbs">
                <div class="flex items-center">
                  <svg class="flex-shrink-0 h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                  </svg>
                  <Link :href="item.url" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-200">{{ item.title }}</Link>
                </div>
              </li>
            </ol>
          </div>
        </nav>
      </div>
    </div>
  </header>

  <main class="py-10">
    <slot></slot>
  </main>
</div>
</template>

<script setup lang="ts">
  import { onMounted } from 'vue';
  import { useStore } from 'vuex';

  const store = useStore();

  onMounted(() => {
    store.dispatch('notifications/fetch')
    store.dispatch('notifications/listen')
  })
</script>
