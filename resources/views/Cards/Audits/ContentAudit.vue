<script lang="ts" setup>
import moment from 'moment';

defineProps<{
  old: string;
  name: string;
  audit: Audit;
}>();
</script>

<template>
  <span>
    {{ ' ' }}
    <span class="text-gray-200 dark:text-gray-400">{{ audit.event }} the {{ name }} of the card.</span>
  </span>
</template>
