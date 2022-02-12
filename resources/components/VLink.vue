<template>
  <Link
    :href="href"
    :class="classes"
    class="flex items-center text-left transition"
  >
    <slot></slot>
  </Link>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  inheritAttrs: false,
  props: {
    variant: {
      type: String,
      default: 'primary'
    },
    href: {
      default: '#'
    }
  },
  computed: {
    classes(): object {
      return {
        "text-blue-600 dark:text-blue-300": this.variant === "primary",
        "text-gray-600 dark:text-gray-300 font-semibold": this.variant === "secondary",
        "text-red-600 dark:text-red-400": this.variant === "danger",

        "hover:text-blue-500 dark:hover:text-blue-200": this.variant === "primary",
        "hover:text-gray-500 dark:hover:text-gray-200": this.variant === "secondary",
        "hover:text-red-300 dark:hover:text-red-300": this.variant === "danger"
      };
    }
  }
});
</script>
