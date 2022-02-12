<template>
  <div
    class="fixed top-0 right-0 mt-4 mr-4 text-sm px-4 py-2 bg-green-300 text-green-800"
    v-show="show"
  >{{ $page.props.flash.success }}</div>
</template>

<script lang="ts" setup>
import { usePage } from '@inertiajs/inertia-vue3';
import { watch, ref } from 'vue';

const show = ref(false);
const page = usePage();

watch(() => page.props.value, (value) => {
  if (value.flash.success) {
    show.value = true;
    setTimeout(() => {
      show.value = false;
    }, 3000);
  }
}, { immediate: true });
</script>
