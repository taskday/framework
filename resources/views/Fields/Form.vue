<template>
  <div class="space-y-6">
    <VFormInput label="Title" :errors="form.errors['title']" v-model="form.title" />
    <VFormInput label="Handle" class="text-gray-600" v-model="form.handle" />
    <VFormSelect label="Type" v-model="form.type">
      <option v-for="field in types" :key="field" :value="field">{{ field }}</option>
    </VFormSelect>
    <component :is="options" :form="form"></component>
    <div v-if="form.errors">
      <span v-for="error in Object.keys(form.errors)" :key="error">{{ form.errors[error] }}</span>
    </div>
    <div v-if="form.processing">Loading</div>
  </div>
</template>

<script lang="ts" setup>
import { computed } from 'vue';

const props = defineProps<{
  form: {
    title: string,
    handle: string,
    errors: object,
    type: string,
    processing: boolean
  },
  fields: string[]
}>()

const options = computed(() =>{
  //@ts-ignore
  return window.taskday.options[props.form.type];
})

const types = computed(() =>{
  //@ts-ignore
  return Object.keys(window.taskday.fields)
})
</script>
