import _ from 'lodash';
import axios from "axios";
import { onMounted, reactive, ref, provide } from "vue";
import { useStorage } from '@vueuse/core';

export const useCards = () => {

  const cards = ref<Pagination<Card>>();

  const status = reactive<{
    isLoading: Boolean,
    isError: Boolean,
    isUpdating: string[],
  }>({
    isLoading: false,
    isError: false,
    isUpdating: [],
  })

  provide('status', status);

  const args = useStorage<{
    search: string, fields: number[], projects: number[], workspaces: number[]
  }>('filters', {
    search: "", fields: [], projects: [], workspaces: []
  });


  const fetch = () => {
    status.isLoading = true;
    axios.get(route('api.cards.index', {
      filters: filters.data.value
    })).then((res) => {
      cards.value = res.data;
      status.isLoading = false;
    }).catch(() => {
      status.isError = true;
      status.isLoading = false;
    })
  };

  const pagination = {
    loadMore: function () {
      if (cards.value?.next_page_url) {
        status.isLoading = true;
        axios.get(cards.value.next_page_url)
          .then((res) => {
            if (cards.value) {
              cards.value.data = [...(cards.value?.data ?? []), ...res.data.data];
              cards.value.to = res.data.to;
              cards.value.total = res.data.total;
            }
            status.isLoading = false;
          }).catch(() => {
            status.isError = true;
            status.isLoading = false;
          })
      }
    }
  };


  const filters = {
    data: args,
    toggle: (model: any, key: string) => {
      if ( args.value[key].includes(model.id) ) {
        args.value[key] = args.value[key].filter(id => id !== model.id);
      } else {
        args.value[key] = [...args.value[key], model.id];
      }

      fetch();
    }
  }

  onMounted(() => {
    window.Echo.private('cards.any').listen(".CardUpdatedEvent", function (e, data) {
      if (cards.value) {
        cards.value.data = cards.value?.data.map((card) => {
          if (e.cards.find(newCard => newCard.id === card.id)) {
            status.isUpdating.push(card.id);
            setTimeout(() => {
              status.isUpdating = status.isUpdating.filter(updatedCardId => updatedCardId != card.id);
            }, 2000)
          }
          return e.cards.find(newCard => newCard.id === card.id) ?? card;
        })
      }
    });
  })

  return { cards, fetch, status, filters, pagination };
};
