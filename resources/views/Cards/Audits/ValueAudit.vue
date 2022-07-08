<script lang="ts" setup>
import moment from 'moment';

defineProps<{
  old: string;
  name: string;
  audit: Audit;
}>();
</script>

<template>
  <p>
    {{ ' ' }}
    <span class="text-gray-200 dark:text-gray-400">set</span>
    {{ ' ' }}
    <span>{{ audit.auditable.field.title }}</span>
    {{ ' ' }}
    <span class="text-gray-200 dark:text-gray-400">from</span>
    {{ ' ' }}
    <span>
      <VFieldWrapper
        :readonly="true"
        :value="old"
        :field="audit.auditable.field"
      ></VFieldWrapper>
    </span>
    {{ ' ' }}
    <span class="text-gray-200 dark:text-gray-400">to</span>
    {{ ' ' }}
    <span>
      <VFieldWrapper
        :readonly="true"
        :value="audit.new_values[name]"
        :field="audit.auditable.field"
      ></VFieldWrapper>
    </span>
    {{ ' ' }}
    <span class="text-gray-200 dark:text-gray-400">{{ moment(audit.created_at).fromNow() }}</span>
  </p>
</template>
