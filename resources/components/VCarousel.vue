<script lang="ts" setup>
import { ref, reactive, onMounted, watch } from "vue";
</script>

<template>
  <div class="flex flex-col">
    <slot name="title"></slot>
    <div class="relative">
      <div class="overflow-hidden">
        <div class="overflow-x-auto snap-x snap-mandatory relative">
          <div class="w-full inline-flex align-top py-4 [&>*]:snap-start [&>*]:shrink-0">
            <slot></slot>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
