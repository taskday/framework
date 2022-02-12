<template>
  <VFormSection>
    <template #title> Dark Mode </template>
    <template #description> Active dark mode. </template>
    <template #content>
      <div class="">
        <Switch
          v-model="enabled"
          :class="enabled ? 'bg-blue-900' : 'bg-blue-700'"
          class="relative inline-flex flex-shrink-0 h-[38px] w-[74px] border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
        >
          <span class="sr-only">Use setting</span>
          <span
            aria-hidden="true"
            :class="enabled ? 'translate-x-9' : 'translate-x-0'"
            class="pointer-events-none inline-block h-[34px] w-[34px] rounded-full bg-white shadow-lg transform ring-0 transition ease-in-out duration-200"
          />
        </Switch>
      </div>
    </template>
  </VFormSection>
</template>

<script lang="ts">
import { ref, watch } from "vue";
import { Switch } from "@headlessui/vue";
import { useStore } from 'vuex';

export default {
  components: { Switch },
  setup() {
    const store = useStore();
    const enabled = ref(localStorage.getItem('dark') == '1');

    watch(enabled, (newValue) => {
      store.commit('darkmode/toggle');
    })

    return { enabled };
  },
};
</script>

<style></style>
