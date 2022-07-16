<template>
  <label class="block w-full">
    <span v-if="label" class="block mb-1 text-gray-700 dark:text-gray-300">{{ label }}</span>
    <select
      class="input w-auto pr-8"
      v-bind="$attrs"
      :value="modelValue"
      @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
    >
      <slot/>
    </select>
    <div v-if="errors">
      <p class="mt-1 text-red-600">{{ errors }}</p>
    </div>
  </label>
</template>

<script lang="ts">
export default {
  inheritAttrs: false,
  props: ["label", "modelValue", "errors"]
};
</script>
