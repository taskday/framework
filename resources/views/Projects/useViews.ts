import { computed, shallowRef } from 'vue';
import { useStorage } from '@vueuse/core';

export default function (project: Project) {

  const currentViewHandle = useStorage(project.id + '_current_view', null);

  const views = computed(() => {
    return window.taskday.views.filter(v => {
      if (v.needs) {
        return v.needs.some(n => project.fields.map(p => p.type).includes(n));
      }
      return true;
    })
  });

  const currentView = shallowRef(views.value[0]);

  function updateCurrentView(view) {
    currentViewHandle.value = view.type ?? view.id
    console.log(view);
    currentView.value = view
  }

  return { currentView, views, updateCurrentView }
}
