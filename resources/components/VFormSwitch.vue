<script lang="ts" setup>
import { Switch } from '@headlessui/vue';
import { ref, watch } from 'vue';

const props = defineProps({
  modelValue: [Boolean]
})

const emit = defineEmits(['update:modelValue'])

const value = ref(props.modelValue);

watch(value, (value) => {
  emit('update:modelValue', value);
})
</script>

<template>
  <div class="flex items-center justify-center">
    <Switch
      v-model="value"
      :class="value ? 'bg-green-500' : 'bg-blue-500'"
      class="relative inline-flex flex-shrink-0 h-5 w-9 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75">
      <span class="sr-only">Use setting</span>
      <span
        aria-hidden="true"
        :class="value ? 'translate-x-4' : 'translate-x-0'"
        class="pointer-events-none inline-block h-4 w-4 rounded-full bg-white shadow-lg transform ring-0 transition ease-in-out duration-200" />
    </Switch>
  </div>
</template>
