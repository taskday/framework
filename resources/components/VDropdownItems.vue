<template>
  <teleport to="body">
    <div ref="panel">
      <transition
        enter-active-class="transition-transform duration-100 ease-out"
        enter-from-class="transform scale-95 opacity-0"
        enter-to-class="transform scale-100 opacity-100"
        leave-active-class="transition duration-75 ease-in"
        leave-from-class="transform scale-100 opacity-100"
        leave-to-class="transform scale-95 opacity-0"
      >
        <MenuItems v-slot="{ active }">
          <div ref="items" :active="active" class="rounded bg-white shadow dark:bg-gray-700 w-64 px-2 py-2 mt-2 max-h-[400px] overflow-auto">
            <slot :active="active" />
          </div>
        </MenuItems>
      </transition>
    </div>
  </teleport>
</template>

<script setup lang="ts">
import { MenuItems } from '@headlessui/vue'
import { createPopper } from "@popperjs/core";
import { inject, ref, Ref, onMounted, watch, HtmlHTMLAttributes } from 'vue';
const dropdown = inject<Ref<HTMLDivElement>>('dropdown');
const panel = ref<any>(null);
const popper = ref<any>(null);
const items = ref<any>(null);

watch(items, () => {
  if (items.value != null ) {
    const button = dropdown.value.querySelector('[data-dropdown-button]');

    popper.value = createPopper(button, panel.value, {
      placement: "bottom-end"
    });
  } else {
    setTimeout(() => {
      if (popper.value) {
        popper.value.destroy();
      }
    }, 100);
  }
})
</script>
