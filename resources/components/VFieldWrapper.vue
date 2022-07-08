<template>
  <component
    :is="getTaskdayField(field?.type)"
    :page="$page"
    :field="field"
    :key="field.pivot?.value"
    :card="card"
  />
</template>

<script lang="ts">
import { defineComponent, PropType, computed, provide } from 'vue'

export default defineComponent({
  props: {
    field: {
      type: Object as PropType<Field>,
      required: true
    },
    card: {
      type: Object as PropType<Card>,
      required: true
    },
  },
  setup(props) {
    const field = computed(() => {
      return props.field;
    });

    const card = computed(() => {
      return props.card;
    });

    provide('field', field);
    provide('card', card);
  }
})
</script>
