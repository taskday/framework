<template>
  <li>
    <Link :href="href" class="text-gray-600 text-sm dark:text-gray-300 hover:text-gray-500 dark:hover:text-gray-200 hover:underline flex items-center text-left transition">
      <slot />
    </Link>
  </li>
</template>

<script setup lang="ts">
import { ref } from 'vue'

defineProps({
  href: {
    type: String
  }
})
</script>
