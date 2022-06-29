<template>
  <div class="flex flex-col w-full ml-2 text-sm space-y-2">
    <div class="flex items-start gap-3">
      <VAvatar :user="notification.user" class="mt-2"/>
      <div class="flex flex-col">
        <p>
          <span>{{ notification.title }}</span>:
          <Link v-if="notification.url" class="hover:underline transition text-blue-600 dark:text-blue-300 hover:text-blue-500 dark:hover:text-blue-200 " :href="notification.url ?? '#'">{{ notification.body }}</Link>
          <span v-else>{{ notification.body }}</span>
        </p>
        <span> {{ moment(notification.created).from(moment(), true) }}</span>
        <div class="flex items-center text-sm gap-2 mt-2">
          <button
            class="hover:underline flex items-center text-sm text-left transition text-blue-600 dark:text-blue-300 hover:text-blue-500 dark:hover:text-blue-200"
            title="Mark as read"
            @click.stop="markAsRead"
          >Mark as read</button>
        </div>
      </div>
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
