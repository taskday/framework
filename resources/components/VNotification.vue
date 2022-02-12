<template>
  <div class="flex flex-col w-full ml-2 text-sm space-y-2">
    <div class="flex space-x-3">
      <VAvatar :user="notification.user" />
      <div class="flex flex-col">
        <strong>{{ notification.user?.name ?? 'Unkown' }}</strong>
        <small class="timestamp">{{ moment(notification.created).from(moment(), true) }}</small>
      </div>
    </div>
    <span class="line-clamp-2">{{ notification.title }}: {{ notification.body }}</span>
    <div class="flex space-x-3">
      <VLink :href="notification.url ?? '#'">View</VLink>
      <button
        class="hover:underline flex items-center text-sm text-left transition text-blue-600 dark:text-blue-300 hover:text-blue-500 dark:hover:text-blue-200"
        title="Mark as read"
        @click.stop="markAsRead"
      >Mark as read</button>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import moment from 'moment';

export default defineComponent({
  emits: ["read"],
  props: {
    notification: {
      type: Object,
      required: true,
    },
  },
  setup() {
    return { moment };
  },
  methods: {
    markAsRead() {
      this.$store.dispatch('notifications/markAsRead', this.notification);
    },
  }
});
</script>
