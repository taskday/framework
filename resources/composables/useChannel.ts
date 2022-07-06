import { Channel } from 'laravel-echo';
import { onMounted, ref, onUnmounted } from 'vue';

interface ChannelEvent {
  [key: string]: (event: any) => void,
}

export const useChannel = (name: string, events: ChannelEvent) => {
  const channel = ref<Channel|null>(null);

  onMounted(() => {
    channel.value = window.Echo.private(name);
    Object.keys(events).map((key) => {
      channel.value?.listen(key, (e) => {
        events[key](e)
      });
    })
  })

  onUnmounted(() => {
    Object.keys(events).map((key) => {
      channel.value?.stopListening(key);
    })
    window.Echo.leave(name);
  })
}
