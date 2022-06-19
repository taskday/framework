import { computed } from 'vue';
import { useStorage } from '@vueuse/core';

export default function (project: Project) {

  const views = computed(() => {
    return window.taskday.views.filter(v => {
      if (v.needs) {
        return v.needs.some(n => project.fields.map(p => p.type).includes(n));
      }
      return true;
    })
  });

  const currentViewHandle = useStorage(project.id + '_current_view', null);

  const currentView = computed(() => {
    return views.value.find(v => v.id == currentViewHandle.value) ?? views.value[0];
  });

  function updateCurrentView(view) {
    currentViewHandle.value = view.id
  }

  return { currentView, views, updateCurrentView }
}
