<template>
  <div>
    <Listbox v-model="selectedPerson">
      <div class="relative" ref="button">
        <ListboxButton
          class="button button-secondary relative pr-10"
        >
          <slot :item="{ title: selectedPerson?.title ?? selectedPerson?.name ?? 'Select...' }"></slot>
          <slot name="trigger" :item="{ title: selectedPerson?.title ?? selectedPerson?.name ?? 'Select...' }"></slot>
          <span
            class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"
          >
            <SelectorIcon class="h-5 w-5" aria-hidden="true" />
          </span>
        </ListboxButton>

        <teleport to="body">
          <div ref="panel" class="z-50 min-w-[240px]">
            <transition
              leave-active-class="transition duration-100 ease-in"
              leave-from-class="opacity-100"
              leave-to-class="opacity-0"
            >
              <ListboxOptions
                class="mt-1 max-h-60 w-full overflow-auto rounded-md background-200 py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
              >
                <ListboxOption
                  v-slot="{ active, selected }"
                  v-for="person in options"
                  :key="person.id"
                  :value="person"
                  as="template"
                >
                  <li
                    :class="[
                      active ? 'background-100' : '',
                      selected && !active ? 'background-200' : '',
                      'relative cursor-default select-none py-2 pl-10 pr-4',
                    ]"
                  >
                    <span
                      :class="[
                        selected ? 'font-medium' : 'font-normal',
                        'block truncate',
                      ]"
                      >{{ person.title ?? person.name  }}</span
                    >
                    <span
                      v-if="selected"
                      class="absolute inset-y-0 left-0 flex items-center pl-3 text-blue-300"
                    >
                      <CheckIcon class="h-5 w-5" aria-hidden="true" />
                    </span>
                  </li>
                </ListboxOption>
              </ListboxOptions>
            </transition>
          </div>
        </teleport>
      </div>

    </Listbox>
  </div>
</template>

<script setup lang="ts">
import { createPopper } from "@popperjs/core";
import { ref, PropType, watch, onMounted } from "vue";
import { Listbox, ListboxButton, ListboxOptions, ListboxOption } from "@headlessui/vue";
import { CheckIcon, SelectorIcon } from "@heroicons/vue/solid";

let props = defineProps({
  selected: Object as PropType<{ id: number, title: string }>,
  options: Array as PropType<{ id: number, title: string }[]>,
});

let emit = defineEmits<{
  (e: 'change', selected: any): void
}>()

const panel = ref(null);
const button = ref(null);
const popper = ref<any>(null);
const selectedPerson = ref(props.selected);

watch(() => selectedPerson.value, () => {
  emit('change', selectedPerson.value);
});

onMounted(() => {
  if (button.value != null && panel.value != null) {
    popper.value = createPopper(button.value, panel.value, {
      placement: "bottom-start"
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
