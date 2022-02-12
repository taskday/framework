<template>
  <li>
    <Link :href="href" class="text-blue-600 dark:text-blue-300 hover:text-blue-500 dark:hover:text-blue-200 hover:underline flex items-center text-sm text-left transition">
      <h3 class="font-semibold">
        <slot />
      </h3>
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
