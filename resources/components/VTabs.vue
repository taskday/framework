<template>
  <TabGroup :selectedIndex="selectedTab" @change="changeTab">
    <slot />
  </TabGroup>
</template>

<script setup lang="ts">
import { TabGroup } from "@headlessui/vue";
import { onMounted, ref } from 'vue';

const selectedTab = ref(0);

function changeTab(index) {
  selectedTab.value = index;
  localStorage.setItem('selectedTab-' + location.pathname, index);
}

onMounted(() => {
  selectedTab.value = parseInt(localStorage.getItem('selectedTab-' + location.pathname) ?? '0');
})
</script>
