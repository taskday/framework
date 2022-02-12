<template>
  <div class="py-6 bg-white dark:bg-gray-800 shadow">
    <VContainer>
      <div class="flex items-end justify-between">
        <div>
          <Link
            v-for="breadcrumb in breadcrumbs"
            :href="breadcrumb.href"
          >
            <h3 class="font-semibold">{{ breadcrumb.title }}</h3>
          </Link>
          <VPageTitle>{{ title }}</VPageTitle>
        </div>
      </div>
    </VContainer>
  </div>
  <VContainer>
    <div class="py-6 space-y-8">
      <div class="flex flex-col w-full space-y-16">
        <VFormSection @submitted="() => store(workspace)">
          <template #title>Title</template>
          <template #description></template>
          <template #content>
            <VFormInput label="Title" v-model="form.title"></VFormInput>
            <VFormInput label="Description" v-model="form.description"></VFormInput>
          </template>
          <template #actions>
            <VButton type="submit">Save</VButton>
          </template>
        </VFormSection>
      </div>
    </div>
  </VContainer>
</template>
<script lang="ts" setup>
import { onMounted } from "vue";
import useProjectForm from "@/composables/useProjectForm";

const { form, store } = useProjectForm();

const props = defineProps<{
  title: string,
  breadcrumbs: {
    title: string,
    href: string,
  }[],
  workspace: Workspace
}>();

onMounted(() => {
  form.title = '';
  form.description = '';
})

</script>
