<template>
  <div>
    <div class="w-full" @click.stop="openModal">
      <slot name="trigger"></slot>
    </div>
    <teleport to="body">
      <TransitionRoot appear :show="isOpen" as="template">
        <Dialog as="div" static :open="isOpen ?? false">
          <div class="fixed inset-0 z-40 overflow-y-auto overflow-x-hidden">
            <div class="min-h-screen px-4 text-center">
              <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
              >
                <DialogOverlay @click="closeModal" class="bg-opacity-20 fixed inset-0 bg-gray-500/[.50]" />
              </TransitionChild>
              <span class="inline-block h-screen align-middle" aria-hidden="true">&#8203;</span>
              <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0 scale-95"
                enter-to="opacity-100 scale-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100 scale-100"
                leave-to="opacity-0 scale-95"
              >
                  <div
                    class="inline-block w-full max-w-xl mt-20 overflow-hidden text-left align-top transition-all transform"
                  >
                <VCard>
                    <DialogTitle
                      v-if="title"
                      as="h3"
                      class="px-4 pt-4 mb-2 text-lg font-medium leading-6 "
                    >{{ title }}</DialogTitle>
                    <div class="dark:text-gray-300">
                      <slot name="content" :openModal="openModal" :closeModal="closeModal"></slot>
                    </div>
                </VCard>
                  </div>
              </TransitionChild>
            </div>
          </div>
        </Dialog>
      </TransitionRoot>
    </teleport>
  </div>
</template>

<script lang="ts">
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogOverlay,
  DialogTitle,
} from "@headlessui/vue";
import {
  onMounted,
  onUnmounted,
  ref,
  toRefs,
  watch,
} from "vue";
import hotkeys from "hotkeys-js";

export default {
  components: {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogOverlay,
    DialogTitle,
  },
  props: ["title", 'isOpen'],
  setup(props) {
    const isOpenProp = toRefs(props).isOpen;
    const isOpen = ref(false);

    watch(isOpenProp, () => {
      isOpen.value = isOpenProp.value
    })

    onMounted(() => {
      hotkeys("esc", (e) => {
        e.preventDefault();
        closeModal();
      });
    });

    onUnmounted(() => {
      hotkeys.unbind("esc");
    });

    function closeModal() {
      isOpen.value = false;
    }

    function openModal() {
      isOpen.value = true;
    }

    return {
      isOpen,
      closeModal,
      openModal,
    };
  },
};
</script>
