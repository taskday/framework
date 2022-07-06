<script lang="ts" setup>
import { PropType } from 'vue';

defineProps({
  status: {
    type: Object as PropType<any>,
    required: true
  },
  models: {
    type: Object as PropType<any>,
    required: true
  },
  pagination: {
    type: Object as PropType<any>,
    required: true
  },
})
</script>

<template>
  <div class="px-6 mt-8">
    <VText v-if="status.isLoading && !status.isError">
      Loading...
    </VText>
    <VText v-if="!status.isLoading && status.isError">
      Error. Try reload the page.
    </VText>
    <VText v-if="!status.isLoading && !status.isError && models">
      Showing {{ models?.data?.length }} results of {{ models?.total }}. <button v-if="models?.total > models?.data?.length" class="underline" @click="pagination.loadMore()">
        Load more...
      </button>
    </VText>
  </div>
</template>
