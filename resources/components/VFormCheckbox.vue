<template>
  <label class="flex items-start w-full">
    <input
      class="input text-blue-600 dark:text-blue-600 px-0 h-5 w-5"
      type="checkbox"
      v-bind="$attrs"
      v-model="modelValue"
    />
    <span class="ml-2 -mt-0.5">
      <span v-if="label">{{ label }}</span>
      <slot v-else></slot>
    </span>
    <span v-if="errors">
      <p class="mt-1 text-red-600">{{ errors }}</p>
    </span>
  </label>
</template>

<script lang="ts">
export default {
  inheritAttrs: false,
  props: {
    label: {
      type: String,
      required: true,
    },
    modelValue: {
      type: Boolean,
      required: true,
    },
    errors: {
      type: String,
      default: null,
    },
  }
};
</script>
