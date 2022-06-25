<template>
  <div>
    <div class="flex items-center flex-wrap gap-2 w-full">
      <span class="text-sm block">{{ field.title }}</span>
      <VFormList
        :options="operators"
        :selected="operators[0]"
        @change=""
      >
        <template #trigger="{ item }">
          <span>{{ item.name }}</span>
        </template>
      </VFormList>
      <VFieldWrapper :field="field"></VFieldWrapper>
    </div>
  </div>
</template>

<script setup lang="ts">
import { PropType, ref } from "vue";

defineProps({
  field: {
    type: Object as PropType<Field>,
    required: true,
  },
  filters: {
    type: Object,
    required: true,
  }
});

const operators = ref([
  {name: 'contains' },
  {name: 'is_equal' },
  {name: 'no_equal' },
  {name: 'greater_than' },
  {name: 'less_than' },
  {name: 'not_contains' },
])
</script>
