<script lang="ts">
export default {
  inheritAttrs: false
}
</script>

<script lang="ts" setup>
defineProps({
  form: {
    type: Object,
    required: true,
  }
})
</script>

<template>
  <div>
    <div v-show="form.recentlySuccessful">Saved.</div>
    <VButton :disabled="!form.isDirty || form.processing" v-bind="$attrs">Save</VButton>
  </div>
</template>
