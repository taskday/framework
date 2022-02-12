<template>
  <tr class="min-w-full overflow-hidden border-collapse dark:divide-gray-700" v-bind="$attrs">
    <slot></slot>
  </tr>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  inheritAttrs: false,
  setup() { },
});
</script>
