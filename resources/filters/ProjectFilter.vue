<script lang="ts" setup>
import { onMounted, ref} from 'vue';
import { useModels } from '@/composables/useModels';

const props = defineProps({
  value: {
    type: String,
    default: '',
  },
  filter: {
    type: Object,
    required: true,
  },
  column: {
    type: String,
    required: true,
  },
})

onMounted(() => {

})

const { models } = useModels<Project, any>(route('api.projects.index'), 'projects');
</script>

<template>
  <div>
    <VPopover class="relative">
      <VPopoverButton class="whitespace-nowrap">{{ models?.data.find(p => p.id == filter.value)?.title }}</VPopoverButton>
      <VPopoverPanel align="right-start">
        <div
          class="px-4 py-1.5 background-200 whitespace-nowrap"
          v-for="project in models?.data"
          @click="$emit('update:value', project.id)"
        >
          {{ project.title }}
        </div>
      </VPopoverPanel>
    </VPopover>
  </div>
</template>
