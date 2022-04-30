<template>
  <VFormSection>
    <template #title>Fields</template>
    <template #description
      >Gallia est omnis divisa in partes tres, quarum. Donec sed odio operae, eu vulputate felis rhoncus. Praeterea iter
      est quasdam res quas ex communi.</template
    >
    <template #content>
      <div>
        <draggable
          class="space-y-4"
          v-model="project.fields"
          :animation="200"
          ghost-class="opacity-50"
          group="tasks"
          itemKey="id">
          <template #item="{ element }">
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
          </template>
        </draggable>

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
import draggable from "vuedraggable";
import useProjectFieldsForm from "@/composables/useProjectFieldsForm";

defineProps<{ project: Project; fields: Field[]; }>();

const { form, update, destroy } = useProjectFieldsForm();
</script>
