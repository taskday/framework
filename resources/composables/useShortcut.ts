import { onMounted } from 'vue';
import hotkeys from 'hotkeys-js';

export default function (shortcut: string, callback) {
  onMounted(() => {
    hotkeys(shortcut, callback);
  })
}
