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
  localStorage.setItem('selectedTab-' + location.href, index);
}

onMounted(() => {
  selectedTab.value = parseInt(localStorage.getItem('selectedTab-' + location.href) ?? '0');
})
</script>
