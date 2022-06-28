<template>
  <label class="block w-full">
    <span v-if="label" class="block mb-1">{{ label }}</span>
    <input
      class="input"
      v-bind="$attrs"
      :value="modelValue"
      @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)" />
    <div v-if="errors">
      <p class="mt-1 text-red-500 text-sm tracking-wide">{{ errors }}</p>
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
