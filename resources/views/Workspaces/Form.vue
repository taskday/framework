<template>
  <div class="space-y-6">
    <VFormInput label="Title" v-model="form.title" />
    <div v-if="form.errors">
      <span v-for="error in Object.keys(form.errors)" :key="error">{{ form.errors[error] }}</span>
    </div>
    <div v-if="form.processing">Loading</div>
  </div>
</template>

<script lang="ts" setup>
defineProps<{
  form: {
    title: string,
    errors: object,
    processing: boolean
  }
}>()
</script>
