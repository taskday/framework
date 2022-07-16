import qs from 'qs';
import _ from "lodash";
import axios from "axios";
import { onMounted, reactive, ref, provide } from "vue";
import { useStorage } from "@vueuse/core";
import useFilter from './useFilters2';

interface Status {
  isLoading: Boolean;
  isError: Boolean;
  isUpdating: number[];
}

export const useModels = <TModel, TFilter>(url: string, key: string = 'filters') => {
  const models = ref<Pagination<TModel & { id: number }>>();

  const status = reactive<Status>({
    isLoading: false,
    isError: false,
    isUpdating: [],
  });

  provide("status", status);

  onMounted(() => {
    fetch();
  });

  const args = useStorage<TFilter>(key, {});

  const fetch = () => {
    status.isLoading = true;
    status.isError = false;
    axios
      .get(url  + '?' + qs.stringify({
        filters: params.params.rules.map((filter) => {
          let copy =  { ...filter };
          delete copy.options
          delete copy.operators
          delete copy.columns
          copy.column = copy.column ?? '';
          copy.value = copy.value ?? '';
          copy.operator = copy.operator ?? '=';
          return copy;
        })
      }))
      .then((res) => {
        models.value = res.data;
        status.isLoading = false;
      })
      .catch(() => {
        status.isError = true;
        status.isLoading = false;
      });
  };

  const pagination = {
    loadMore: function () {
      if (models.value?.next_page_url) {
        status.isLoading = true;
        axios
          .get(models.value.next_page_url, {
            params: {
              filters: filters.data.value
            }
          })
          .then((res) => {
            if (models.value) {
              let data = _.uniq([...(models.value?.data ?? []), ...res.data.data], 'id');
              models.value = res.data;
              models.value.data = data;
            }
            status.isLoading = false;
          })
          .catch(() => {
            status.isError = true;
            status.isLoading = false;
          });
      }
    },
  };

  const params = useFilter();

  function setIsUpdating(id) {
    status.isUpdating.push(id);
    setTimeout(() => {
      status.isUpdating = status.isUpdating.filter((updatedModelId) => updatedModelId != id);
    }, 2000);
  }

  function syncModels(newModels) {
    if (models.value) {
      models.value.data = models.value?.data.map((model) => {
        if (newModels.find((newModel) => newModel.id === model.id)) {
          setIsUpdating(model.id);
        }
        return newModels.find((newModel) => newModel.id === model.id) ?? model;
      });
    }
  }

  return { models, actions: { fetch, syncModels }, status, params, pagination };
};
