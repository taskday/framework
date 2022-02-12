import { onUnmounted } from 'vue';

export default function (callback, message = "There are unsaved changes. Are you sure you want to leave?") {
  let beforeEventListener = (event) => {
    if (callback()) {
      if (!confirm(message)) {
        event.preventDefault()
      }
    }
  };

  let beforeUnload = (event) => {
    if (!callback()) {
      return undefined;
    }
    return message;
  }

  onUnmounted(() => {
    document.addEventListener('inertia:success', () => {
      document.removeEventListener('inertia:before', beforeEventListener);
    });
  })

  return {
    disable: () => {
      window.removeEventListener("beforeunload", beforeUnload);
      document.removeEventListener('inertia:before', beforeEventListener)
    },
    enable: () => {
      window.addEventListener("beforeunload", beforeUnload);
      document.addEventListener('inertia:before', beforeEventListener)
    }
  }
}
