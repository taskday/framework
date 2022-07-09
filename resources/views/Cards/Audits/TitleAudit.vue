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
    <span class="text-gray-200 dark:text-gray-400">{{ audit.event }}</span>
    {{ ' ' }}
    <span>{{ name }}</span>
    {{ ' ' }}
    <span class="text-gray-200 dark:text-gray-400">from</span>
    {{ ' ' }}
    <span>{{ audit.old_values[name] }}</span>
    {{ ' ' }}
    <span class="text-gray-200 dark:text-gray-400">to</span>
    {{ ' ' }}
    <span>{{ old }}</span>
    {{ ' ' }}
    <span class="text-gray-200 dark:text-gray-400">{{ moment(audit.created_at).fromNow() }}</span>
  </span>
</template>
