<template>
  <label class="block w-full">
    <span v-if="label" class="block mb-1 text-gray-700 dark:text-gray-300">{{ label }}</span>
    <input
      class="w-full px-2 placeholder-gray-300 transition border border-gray-200 rounded dark:border-gray-800 focus:outline-none focus:border-transparent focus:ring-1 focus:ring-offset-blue-400 dark:focus:ring-offset-blue-700 focus:shadow-sm dark:ring-opacity-10 dark:bg-gray-700 dark:text-gray-100"
      v-bind="$attrs"
      :value="modelValue"
      @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)" />
    <div v-if="errors">
      <p class="mt-1 text-red-600">{{ errors }}</p>
    </div>
  </label>
</template>

<script lang="ts">
export default {
  inheritAttrs: false,
  customOptions: {},
};
</script>

<script lang="ts" setup>
defineProps({
  errors: String,
  modelValue: String,
  label: {
    type: String,
    default: null,
  },
});
</script>
