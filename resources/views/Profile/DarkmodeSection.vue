<template>
  <VFormSection>
    <template #title> Dark Mode </template>
    <template #description> Active dark mode. </template>
    <template #content>
      <div class="flex items-center justify-start">
        <VFormSwitch v-model="enabled" />
      </div>
    </template>
  </VFormSection>
</template>

<script lang="ts">
import { useStorage } from "@vueuse/core";
import { watch } from "vue";
import { useStore } from 'vuex';

export default {
  setup() {
    const store = useStore();
    const enabled = useStorage('dark', false);

    watch(enabled, (newValue) => {
      store.commit('darkmode/toggle');
    })

    return { enabled };
  },
};
</script>

<style></style>
