<template>
  <div class="flex flex-col">
    <div class="-mx-4 -my-2 overflow-x-auto">
      <div class="px-4 inline-block min-w-full align-middle">
        <VCard class="overflow-hidden">
          <table v-bind="$attrs" class="min-w-full">
            <slot></slot>
          </table>
        </VCard>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  inheritAttrs: false
});
</script>
