<template>
  <div class="px-6 py-2 bg-white inset-x-0 z-10 dark:bg-gray-800 border-b md:text-sm">
    <div class="flex w-full space-x-4">
      <!-- logo -->
      <Link :href="route('dashboard')">
        <div class="flex items-center">
          <svg
            version="1.0"
            xmlns="http://www.w3.org/2000/svg"
            class="h-8 w-8 text-blue-600 dark:text-blue-300 fill-current"
            viewBox="0 0 512 512">
            <path
              d="M183.5 1.1c-55 1.7-108.6 5.2-118.8 7.8-15.1 3.9-26.1 10.5-37.2 22.3-3.8 4.1-8.5 10-10.4 13.1-4.7 8-9.2 21.6-9.8 30.1-.6 7.2-.6 7.2 2.8 10 2.6 2.2 3.9 2.7 6.3 2.2 4.7-1 6.5-3.5 7.7-10.7 2.3-15.1 8-26.1 18.5-35.9 7.1-6.7 11-9.2 19.7-12.5 8-3 16.5-4 49.2-6 55.5-3.3 79.1-3.9 144.5-3.9s89.3.6 144.5 3.9c31.4 1.9 40.5 3 48.3 5.6 16 5.4 30.7 20.2 36.2 36.2 3.2 9.6 5 31 8.2 99.2 1.6 34 1.6 153 0 187-1.8 37.6-4.1 74.7-5.2 84.8-2.8 23.8-18 43.4-39.2 50.6-9.7 3.3-30.9 5.1-99.3 8.3-34 1.6-153.1 1.6-187 0-37.7-1.8-74.7-4.1-84.8-5.2-16-1.9-27.1-7.4-38-19-11.3-11.9-15-22.1-16.7-46-5.8-82-7.5-189.8-4-261.4 1.1-21.7.7-23.8-4.1-26.5-3-1.7-7.1-.9-9.8 1.8-2.4 2.4-2.9 8.1-4.1 51.6C-1.2 263 .4 340.9 5.6 417c1.6 24.4 2.9 31.6 7.3 42.1 5.5 13.1 18.7 28.1 31.5 35.8 7.9 4.7 20.6 8.8 31.1 10 27.3 3.1 94.4 6 155.5 6.8 82 .9 196.7-3.6 216.4-8.7 15-3.8 26.7-10.9 37.7-22.8 8-8.7 12.3-15.9 16-26.4 3.3-9.9 4.3-17.9 6.4-51.8 5.3-88 5.8-184.8 1.5-266-3.2-59.7-4.6-71.4-10.3-84.1-7.1-16.2-22.4-31.4-38.5-38.6C450 8.8 441 7.2 417.8 5.6 344.2.5 257.1-1.2 183.5 1.1z" />
            <path
              d="M364.8 131.4c-3.1 1.3-7.9 4.2-10.5 6.4-2.6 2.2-28.3 27.6-57 56.4-37 37.1-52.4 53.2-52.9 55.2-1.4 5.8 4.4 11.6 10.2 10.2 2.1-.5 19-16.7 58.4-56.1 30.5-30.4 56.5-55.8 57.7-56.4 2.7-1.4 9.3-1.4 13-.1 3.7 1.4 30.1 27.6 31.9 31.7 1.7 3.8 1.8 9.1.4 13-1.4 3.8-186.5 189.1-190.7 190.9-4.5 1.9-9.7 1.7-14.1-.5-4.8-2.5-104.8-102.7-106.2-106.4-1.5-4.1-1.2-10.4.6-14.2.8-1.8 7.7-9.4 15.3-16.8 16.4-16.1 18.2-17 29.6-14 1.1.3 16.2 14.7 33.6 31.9 32.5 32.3 33.2 32.9 38.2 30.2 3.3-1.7 4.6-3.9 4.7-7.8 0-3.3-2-5.5-32.2-35.6-29.2-29.1-32.8-32.3-37.8-34.1-3-1.2-7.4-2.4-9.7-2.8-5-.8-14.2.9-19.8 3.7-6.1 3.1-34.7 32.2-37.6 38.3-3.5 7.3-3.8 18.9-.9 27 2.1 5.7 4.7 8.5 55.8 59.7 61.2 61.3 58.6 59.3 73.7 59.3 7.8 0 9.7-.4 14.5-2.7 4.6-2.3 21.3-18.5 101.1-98.5 107.4-107.5 99.4-98.4 99.4-114.3 0-12.9-1.9-16.1-21.7-35.6-14.2-14-17.1-16.4-22.1-18.3-7.9-2.9-17.4-2.8-24.9.3z" />
          </svg>
        </div>
      </Link>

      <div class="hidden md:flex items-center justify-start space-x-4 w-full flex-grow">
        <VNav class="flex space-x-2">
          <VNavLink class="px-2" :href="route('workspaces.index')"> Workspaces </VNavLink>
          <VNavLink class="px-2" :href="route('projects.index')"> Projects </VNavLink>
          <VNavLink class="px-2" :href="route('cards.index')"> Cards </VNavLink>
          <VNavLink class="px-2" :href="route('fields.index')"> Fields </VNavLink>
        </VNav>
      </div>

      <div class="w-full max-w-[16rem]">
        <VSearch />
      </div>

      <div class="flex items-center justify-end space-x-4 flex-grow">
        <VDropdown>
          <VDropdownButton>
            <div class="flex items-center w-6 justify-center">
              <div class="relative">
                <BellIcon class="h-5 w-5 text-black dark:text-gray-100" />
                <span
                  v-if="store.state.notifications.notifications.length > 0"
                  class="rounded-full bg-red-500 text-white font-semibold flex items-center justify-center h-2 w-2 absolute top-0 right-0"></span>
              </div>
            </div>
          </VDropdownButton>
          <VDropdownItems class="w-[400px]">
            <VDropdownItem v-for="notification in store.state.notifications.notifications">
              <VNotification :notification="notification" />
            </VDropdownItem>
            <VDropdownItem v-if="store.state.notifications.notifications.length == 0">
              <div class="text-center w-full">
                <span class="text-sm">No new notifications.</span>
              </div>
            </VDropdownItem>
          </VDropdownItems>
        </VDropdown>
        <VDropdown>
          <VDropdownButton>
            <div class="flex whitespace-nowrap items-center space-x-2">
              <VAvatar :user="$page.props.user" />
              <!-- <span class="font-bold text-sm hidden lg:block">{{ name }}</span> -->
              <ChevronDownIcon class="w-4 h-4" />
            </div>
          </VDropdownButton>
          <VDropdownItems>
            <!-- Team Management -->
            <template v-if="$page.props.jetstream.hasTeamFeatures">
              <VDropdownDivider title="Manage Team" />

              <!-- Team Settings -->
              <VDropdownItem>
                <Link class="flex w-full" :href="route('teams.show', $page.props.user.current_team)"
                  >Team Settings</Link
                >
              </VDropdownItem>

              <VDropdownItem v-if="$page.props.jetstream.canCreateTeams">
                <Link class="flex w-full" :href="route('teams.create')"> Create New Team </Link>
              </VDropdownItem>

              <!-- Team Switcher -->
              <VDropdownDivider title="Switch Teams" />

              <template v-for="team in $page.props.user.all_teams" :key="team.id">
                <VDropdownItem>
                  <form @submit.prevent="switchToTeam(team)">
                    <button>
                      <div class="flex items-center w-full">
                        <svg
                          v-if="team.id == $page.props.user.current_team_id"
                          class="mr-2 h-5 w-5 text-green-400"
                          fill="none"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          stroke="currentColor"
                          viewBox="0 0 24 24">
                          <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>{{ team.name }}</div>
                      </div>
                    </button>
                  </form>
                </VDropdownItem>
              </template>
            </template>

            <VDropdownDivider />

            <VDropdownItem>
              <Link class="flex w-full" :href="route('profile.show')">Profile</Link>
            </VDropdownItem>

            <VDropdownDivider />

            <VDropdownItem>
              <Link class="flex w-full" method="post" :href="route('logout')">Logout</Link>
            </VDropdownItem>
          </VDropdownItems>
        </VDropdown>
      </div>

      <VButton hidden class="md:hidden ml-4" variant="base" @click.prevent="() => $store.commit('sidebar/toggle')">
        <MenuIcon class="h-5 w-5" />
      </VButton>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ChevronDownIcon, BellIcon, ChartPieIcon, CollectionIcon, MenuIcon, PlusIcon } from "@heroicons/vue/outline";
import { Inertia } from "@inertiajs/inertia";
import { usePage } from "@inertiajs/inertia-vue3";
import { ref, onMounted } from "vue";
import { useStore } from "vuex";
import VButton from "./VButton.vue";
import VDropdownButton from "./VDropdownButton.vue";
const page = usePage<{ user: User }>();
const store = useStore();

onMounted(() => {
  store.dispatch("notifications/fetch");
  store.dispatch("notifications/listen");
});

const switchToTeam = (team) => {
  Inertia.put(
    route("current-team.update"),
    {
      team_id: team.id,
    },
    {
      preserveState: false,
    }
  );
};
</script>
