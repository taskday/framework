<template>
  <VFormSection>
    <template #title>Fields</template>
    <template #description>
      Add any created field to this project.
    </template>
    <template #content>
      <div>
        <div
          class="space-y-4"
          v-for="element in project.fields"
          :animation="200"
          ghost-class="opacity-50"
          group="tasks"
          itemKey="id">

            <div class="space-y-3">
              <div class="flex rounded items-center justify-between space-x-2 p-2 border">
                <div>
                  <div class="text-sm font-semibold">{{ element.title }}</div>
                  <div class="text-sm">{{ element.handle }}</div>
                </div>
                <VButton
                  variant="base"
                  class="w-5 h-5 rounded bg-gray-200 dark:bg-gray-700"
                  type="button"
                  @click="() => destroy(project, element)"
                  >&times;</VButton
                >
              </div>
            </div>

        </div>

        <form @submit.prevent="() => update(project, form.field)" class="space-y-6 mt-8">
          <VFormSelect label="Type" v-model="form.field">
            <option :value="field.id" v-for="field in fields" :key="field.title">{{ field.title }}</option>
          </VFormSelect>
          <div v-if="form.errors">
            <span v-for="error in Object.keys(form.errors)" :key="error">{{ form.errors[error] }}</span>
          </div>
          <div v-if="form.processing">Loading</div>
          <VButton type="submit" class="px-4">Add</VButton>
        </form>
      </div>
    </template>
  </VFormSection>
</template>

<script setup lang="ts">
import useProjectFieldsForm from "@/composables/useProjectFieldsForm";

defineProps<{ project: Project; fields: Field[]; }>();

const { form, update, destroy } = useProjectFieldsForm();
</script>
