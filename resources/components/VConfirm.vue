<template>
  <VModal title="Are you sure?">
    <template #trigger>
      <slot></slot>
    </template>
    <template #content="{ closeModal }">
      <div class="p-4 space-y-6">
        <div class="flex items-center space-x-2">
          <VButton @click.stop="() => { closeModal(); runAction() }" variant="danger">Yes</VButton>
          <VButton @click.stop="closeModal" variant="secondary">Cancel</VButton>
        </div>
      </div>
    </template>
  </VModal>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  inheritAttrs: false,
  props: ["onClose", "onOpen", "onConfirm"],
  methods: {
    runAction() {
      this.onConfirm()
    }
  }
});
</script>
