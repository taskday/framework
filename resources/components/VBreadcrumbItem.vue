<template>
  <li>
    <Link :href="href" class="text-sm hover:underline flex items-center text-left transition">
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
