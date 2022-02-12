<template>
  <div class="flex flex-col space-y-10">
    <VComment v-for="comment in comments" :comment="comment" />
  </div>
</template>

<script setup lang="ts">
defineProps<{
  comments: Comment[]
}>()
</script>
