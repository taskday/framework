<template>
  <label class="flex items-start w-full">
    <input
      class="transition border border-gray-200 rounded dark:border-gray-800 focus:outline-none focus:shadow-sm dark:focus:bg-gray-600 focus:ring-1 dark:focus:ring-offset-0 dark:ring-opacity-10 dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600"
      type="checkbox"
      v-bind="$attrs"
      v-model="value"
    />
    <span
      v-if="label"
      class="ml-2 -mt-0.5 dark:text-gray-300 block text-sm text-gray-700"
    >{{ label }}</span>
    <span v-if="errors">
      <p class="mt-1 text-red-600">{{ errors }}</p>
    </span>
  </label>
</template>

<script lang="ts">
import { watch } from 'vue';
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
  },
  setup(props, vm) {
    const value = ref(false);

    watch(() => value, (newValue) => {
      vm.emit("update:modelValue", newValue);
    });
  }
};
</script>
