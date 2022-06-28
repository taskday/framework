<template>
  <div ref="panel">
    <teleport to="body">
      <div ref="content">
        <transition
          enter-active-class="transition-transform duration-100 ease-out"
          enter-from-class="transform scale-95 opacity-0"
          enter-to-class="transform scale-100 opacity-100"
          leave-active-class="transition duration-75 ease-in"
          leave-from-class="transform scale-100 opacity-100"
          leave-to-class="transform scale-95 opacity-0">
          <PopoverPanel>
            <div
              class="mt-2 min-w-[12rem] max-w-xs rounded-md shadow-lg py-2 background-200 ring-1 ring-black ring-opacity-5 focus:outline-none max-h-[400px] overflow-auto">
              <slot></slot>
            </div>
          </PopoverPanel>
        </transition>
      </div>
    </teleport>
  </div>
</template>

<script setup lang="ts">
import { PopoverPanel } from "@headlessui/vue";
import { onMounted, ref, watch } from "vue";
import { createPopper, Instance } from "@popperjs/core";

const props = defineProps({ open: Boolean });
const content = ref(null);
const panel = ref(null);
const popper = ref<Instance | null>(null);

onMounted(() => {
  if (content.value && panel.value && !popper.value) {
    console.log(panel);
    popper.value = createPopper(panel.value, content.value, {
      placement: "bottom-end",
    });
  } else {
    setTimeout(() => {
      if (popper.value) {
        popper.value.destroy();
      }
    }, 100);
  }
});

watch(
  () => props.open,
  () => {}
);
</script>
