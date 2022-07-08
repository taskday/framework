<template>
  <div class="flex items-center gap-2">
    <div
      :title="user?.name"
      class="ring-1 ring-white dark:ring-gray-700 dark:bg-gray-600 dark:text-gray-100 flex items-center justify-center overflow-hidden text-sm text-gray-800 font-medium bg-gray-200 rounded-full"
      :class="{
        'w-8 h-8': size == '',
        'w-5 h-5': size == 'sm'
      }"
    >
      <img class="text-xs text-center align-middle" v-if="user?.profile_photo_url" :src="user?.profile_photo_url" />
      <span v-else class="text-xs text-center align-middle">{{ user?.name.split(' ').map(word => word.substr(0, 1)).join('') }}</span>
    </div>
  </div>
</template>

<script lang="ts" setup>
defineProps({
  user: {
    type: Object,
    required: true
  },
  size: {
    type: String,
    default: ''
  }
})
</script>

