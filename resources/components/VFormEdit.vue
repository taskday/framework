<template>
  <label class="block w-full">
    <template v-if="isEditing">
      <input
        class="w-full relative z-10 h-9 px-2 placeholder-gray-300 transition rounded dark:border-gray-800 focus:outline-none focus:border-transparent focus:ring-1 focus:ring-offset-blue-400 dark:focus:ring-offset-blue-700 focus:shadow-sm dark:ring-opacity-10 dark:bg-gray-700 dark:text-gray-100"
        v-bind="$attrs"
        :value="modelValue"
        @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
      />
      <div class="fixed inset-0 w-full h-full" @click="stopEditing"></div>
    </template>
    <span v-else>
      <div @click="startEditing">
        <slot></slot>
      </div>
    </span>
  </label>
</template>

<script lang="ts">
export default {
  inheritAttrs: false,
  customOptions: {}
}
</script>

<script lang="ts" setup>
import { ref } from 'vue';

defineProps({
  label: {
    type: String,
    default: null
  },
  errors: {
    type: String,
    default: null
  },
  modelValue: String,
});

const isEditing = ref(false);

function startEditing() {
  console.log('start editing');
  isEditing.value = true;
}
function stopEditing() {
  console.log('stop editing');
  isEditing.value = false;
}

</script>
