<script setup lang="ts">
import { PropType, computed, onMounted, ref, watch } from "vue";
import ProjectView from "../Projects/Partials/ProjectView.vue";
import { useModels } from "@/composables/useModels";
import { useChannel } from "@/composables/useChannel";

const props = defineProps({
  title: String,
  breadcrumbs: {
    type: Object as PropType<Breadcrumb[]>,
  },
  fields: {
    type: Array as PropType<Field[]>,
    required: true,
  },
  filters: {
    type: Array as PropType<Filter[]>
  }
});

const { models, status, params, pagination, actions } = useModels<Card, Filter>(route("api.cards.index"));

useChannel("cards.any", {
  ".CardUpdatedEvent": (e) => actions.syncModels(e.cards),
});

watch(() => params.params.rules, () => {
  actions.fetch();
}, { deep: true })

const fakeProject = computed(() => {
  return {
    id: null,
    title: null,
    description: null,
    fields: props.fields.filter(f => params.params.rules.map(crit => crit.column).includes(f.handle)),
    cards: status.isLoading || status.isError ? [] : models?.value?.data ?? [],
  };
});
</script>

<template>
  <VPageHeader />

  <div class="px-6">
    <VPopover>
      <VPopoverButton>
        <VIcon name="filters"></VIcon>
        <span>Filters</span>
      </VPopoverButton>
      <VPopoverPanel align="bottom-start">
        <div class="py-1">
          <div v-for="filter in filters" class="px-4 py-2 hover:background-100" @click="params.add(filter)">
            {{ filter.name }}
          </div>
        </div>
      </VPopoverPanel>
    </VPopover>

    <div class="flex flex-wrap gap-2 mt-4">
      <VFilter
        v-for="filter in params.params.rules"
        :filter="filter"
        @remove="params.remove(filter.id)"
      />
    </div>
  </div>

  <VFetchStatus :status="status" :models="models" :pagination="pagination" />

  <div class="h-full" v-if="!status.isError">
    <div class="grid grid-cols-1 gap-8 py-8">
      <ProjectView :key="status.isLoading" :project="fakeProject" />
    </div>
  </div>
</template>
