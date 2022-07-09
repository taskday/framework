<template>
  <label class="block w-full">
    <VFormHtmlEditor
      v-bind="$attrs"
      v-model="modelValue"
      :toolbar="false"
    />
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
import VFormHtmlEditor from './VFormHtmlEditor.vue';

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
</script>
