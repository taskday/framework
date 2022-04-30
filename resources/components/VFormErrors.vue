<script setup lang="ts">
import { ref } from "vue";

defineProps({
  errors: {
    type: String,
    default: null
  }
})
</script>

<template>
  <div v-if="errors">
    <p class="mt-1 text-red-600">{{ errors }}</p>
  </div>
</template>
