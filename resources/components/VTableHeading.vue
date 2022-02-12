<template>
  <th
    style="touch-action: none;"
    class="sticky uppercase rounded-lg top-0 px-3 py-2 text-xs font-bold leading-4 tracking-wider text-left bg-gray-50 dark:bg-gray-800 border-r"
  >
    <span>
      <slot></slot>
    </span>
    <div
      class="resize-handle absolute rounded inset-y-0 right-0 flex flex-col items-center justify-center bg-gray-100 dark:bg-gray-800 border-r w-px px-px hover:bg-blue-600 dark:hover:bg-blue-600"
      style="cursor: col-resize;"
    ></div>
  </th>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import { MinusIcon } from "@heroicons/vue/solid";

export default defineComponent({
  components: { MinusIcon },
  setup() { },
});
</script>
