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
    <span class="text-gray-200 dark:text-gray-400">set</span>
    {{ ' ' }}
    <span>{{ audit.auditable.field.title }}</span>
    {{ ' ' }}
    <template v-if="audit.old_values[name]">
      <span class="text-gray-200 dark:text-gray-400">from</span>
      {{ ' ' }}
      <span>
        <VFieldWrapper
          :readonly="true"
          :value="audit.old_values[name]"
          :field="audit.auditable.field"
        ></VFieldWrapper>
      </span>
      {{ ' ' }}
    </template>
    <span class="text-gray-200 dark:text-gray-400">to</span>
    {{ ' ' }}
    <span>
      <VFieldWrapper
        :readonly="true"
        :value="old"
        :field="audit.auditable.field"
      ></VFieldWrapper>
    </span>
    {{ ' ' }}
    <span class="text-gray-200 dark:text-gray-400">{{ moment(audit.created_at).fromNow() }}</span>
  </span>
</template>
