import _ from 'lodash';
import { reactive, onMounted, watch, ref } from 'vue';
import { useStorage } from "@vueuse/core";
import { useAxios } from "@vueuse/integrations/useAxios";

export default function (route: string) {
  const filters = useStorage<{
    workspaces: number[],
    projects: number[],
    fields: number[],
    search: string;
  }>('filters', {
    workspaces: [],
    projects: [],
    fields: [],
    search: '',
  });

  const pagination = reactive({
    page: 1,
  })

  const { data, isLoading, isFinished, execute } = useAxios<Pagination<Project>>();

  const load = _.throttle(() => {
    execute(window.route(route, {
      filters: filters.value,
      page: pagination.page,
    }));
  });

  onMounted(() => load());
  watch(filters, () => load(), { deep: true })
  watch(pagination, () => load(), { deep: true });

  function toggleFilter(model: any, key: string) {
    if ( filters.value[key].includes(model.id) ) {
      filters.value[key] = filters.value[key].filter(id => id !== model.id);
    } else {
      filters.value[key] = [...filters.value[key], model.id];
    }
  }

  return { data, isLoading, isFinished, execute, toggleFilter, filters, pagination }
}
