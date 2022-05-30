<template>
  <div>
    <div class="w-full" @click.stop="openModal">
      <slot name="trigger"></slot>
    </div>
    <teleport to="body">
      <TransitionRoot appear :show="isOpen ?? false" as="template">
        <Dialog as="div" static :open="isOpen ?? false" @close="closeModal">
          <div class="fixed z-40 inset-0 overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
              <TransitionChild
                as="template"
                enter="ease-in-out duration-500"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="ease-in-out duration-500"
                leave-from="opacity-100"
                leave-to="opacity-0"
              >
                <DialogOverlay
                  @click="closeModal"
                  class="absolute inset-0 bg-gray-400 bg-opacity-20 dark:bg-gray-800 dark:bg-opacity-50 transition-opacity"
                />
              </TransitionChild>
              <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
                <TransitionChild
                  as="template"
                  enter="transform transition ease-in-out duration-500 sm:duration-700"
                  enter-from="translate-x-full"
                  enter-to="translate-x-0"
                  leave="transform transition ease-in-out duration-500 sm:duration-700"
                  leave-from="translate-x-0"
                  leave-to="translate-x-full"
                >
                  <div class="relative w-screen max-w-2xl md:max-w-3xl xl:max-w-4xl">
                    <TransitionChild
                      as="template"
                      enter="ease-in-out duration-500"
                      enter-from="opacity-0"
                      enter-to="opacity-100"
                      leave="ease-in-out duration-500"
                      leave-from="opacity-100"
                      leave-to="opacity-0"
                    >
                      <div class="absolute top-0 left-0 -ml-8 pt-4 pr-2 flex sm:-ml-10 sm:pr-4">
                        <button
                          @click="closeModal"
                          class="rounded-md text-gray-800 hover:text-gray-600 dark:hover:text-white focus:outline-none focus:ring-1 focus:ring-gray-800 dark:focus:ring-white"
                        >
                          <span class="sr-only">Close panel</span>
                          <!-- Heroicon name: outline/x -->
                          <svg
                            class="h-6 w-6"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            aria-hidden="true"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"
                            />
                          </svg>
                        </button>
                      </div>
                    </TransitionChild>

                    <div
                      class="h-full flex flex-col bg-gray-100 dark:bg-gray-900 shadow-xl overflow-y-scroll"
                    >
                      <div v-if="title" class="px-4 sm:px-6">
                        <VPageTitle class="text-lg font-medium" id="slide-over-title">{{ title }}</VPageTitle>
                      </div>
                      <div class="relative flex-1 w-full">
                        <!-- Replace with your content -->
                        <slot></slot>
                        <!-- /End replace -->
                      </div>
                    </div>
                  </div>
                </TransitionChild>
              </div>
            </div>
          </div>
        </Dialog>
      </TransitionRoot>
    </teleport>
  </div>
</template>

<script lang="ts">
import { TransitionRoot, TransitionChild, Dialog, DialogOverlay, DialogTitle } from "@headlessui/vue";
import { ref } from "vue";

export default {
  components: {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogOverlay,
    DialogTitle
  },
  props: ["title", 'isOpen', 'onClose'],
  setup(props) {
    const isOpen = ref(props.isOpen);

    function closeModal() {
      isOpen.value = false;
      props.onClose();
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
