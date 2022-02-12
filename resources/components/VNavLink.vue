<template>
  <li>
    <Link
      v-bind="$attrs"
      :href="href"
      class="block items-center rounded py-1 h-8 border border-transparent whitespace-nowrap truncate
        text-gray-700 dark:text-gray-300 font-medium
        hover:text-gray-900 hover:bg-gray-100
        dark:hover:bg-gray-700 dark:hover:text-white
        focus:border focus:border-blue-600 focus:outline-none
      "
      :class="[ endsWith(href, route().current()) ? 'font-medium dark:bg-gray-700 text-gray-700 dark:text-gray-100' : '' ]"
    >
      <!-- :class="{ 'bg-gray-200 dark:bg-gray-700': route().current().url == href }" -->
      <slot />
    </Link>
  </li>
</template>

<script lang="ts">import { defineComponent } from "@vue/runtime-core"
import { endsWith } from "lodash";

export default defineComponent({
  inheritAttrs: false,
  props: {
    href: {
      type: String,
      default: "#"
    }
  },
  setup(props) {
    return { endsWith }
  }
});
</script>
