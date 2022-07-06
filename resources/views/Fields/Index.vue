<template>
  <VPageHeader>
    <VButton :href="route('fields.create')">Add field</VButton>
  </VPageHeader>
  <VContainer class="mt-6">
    <table class="w-full">
      <thead>
        <tr class="border-b">
          <th class="p-2 text-xs uppercase tracking-wide text-gray-600 dark:text-gray-300 text-left">
            Name
          </th>
          <th class="p-2 text-xs uppercase tracking-wide text-gray-600 dark:text-gray-300 text-left">
            Head
          </th>
        </tr>
      </thead>
      <tbody class="divide-y">
        <tr v-for="field in fields" :key="field.id">
          <td class="p-2">
            <VLink :href="route('fields.edit', field)">{{field.title}}</VLink>
          </td>
          <td class="p-2">
            <span class>handle: {{ field.handle }}</span>,
            <span class="mt-1">type: {{ field.type }}</span>
          </td>
        </tr>
      </tbody>
    </table>
  </VContainer>
</template>

<script lang="ts" setup>
import { useForm } from "@inertiajs/inertia-vue3";

defineProps<{
  title: string,
  breadcrumbs: Breadcrumb[]
  fields: Field[]
}>()

const form = useForm({
  title: "",
  handle: "",
  type: null,
  options: {}
});

function submit() {
  form.post(route("fields.store"), {
    preserveScroll: true,
    onSuccess: () => { form.reset() },
  });
}
</script>
