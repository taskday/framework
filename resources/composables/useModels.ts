import qs from 'qs';
import _ from "lodash";
import axios from "axios";
import { onMounted, onUnmounted, reactive, ref, provide } from "vue";
import { useStorage } from "@vueuse/core";

interface Status {
  isLoading: Boolean;
  isError: Boolean;
  isUpdating: number[];
}

export const useModels = <TModel, TFilter>(url: string) => {
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

  const args = useStorage<TFilter>("filters", {});

  const fetch = () => {
    status.isLoading = true;
    axios
      .get(url  + '?' + qs.stringify({
        filters: filters.data.value
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

  const filters = {
    data: args,
    toggle: (model: any, key: string) => {
      if (args.value[key]?.includes(model.id)) {
        args.value[key] = args.value[key].filter((id) => id !== model.id);
      } else {
        args.value[key] = [...(args.value[key] ?? []), model.id];
      }

      fetch();
    },
  };

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

  return { models, actions: { fetch, syncModels }, status, filters, pagination };
};
