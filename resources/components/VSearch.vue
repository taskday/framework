<template>
  <div>
    <div class="bg-white dark:bg-slate-900 relative pointer-events-auto">
      <button
        type="button"
        @click="open"
        class="w-full flex items-center text-sm leading-6 text-gray-400 rounded-md ring-1 ring-gray-900/10 shadow-sm py-1 pl-2 pr-3 hover:ring-gray-200 dark:hover:ring-gray-600 dark:bg-gray-700 dark:highlight-white/5">
        <svg width="24" height="24" fill="none" aria-hidden="true" class="mr-3 flex-none hidden sm:block">
          <path
            d="m19 19-3.5-3.5"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"></path>
          <circle
            cx="11"
            cy="11"
            r="6"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"></circle></svg
        >Quick search...<span class="ml-auto pl-3 flex-none text-xs font-semibold">⌘K</span>
      </button>
    </div>
    <teleport to="body">
      <div
        v-show="state.isOpen"
        class="fixed h-screen w-screen z-[200] inset-0 flex flex-col bg-gray-900 bg-opacity-20 backdrop-blur-sm p-10 md:p-[10vh]">
        <div @click="state.isOpen = false" class="absolute inset-0"></div>
        <div class="flex flex-col text-gray-900 bg-white overflow-hidden rounded-md shadow-md dark:bg-gray-800 dark:text-gray-200 dark:border dark:border-gray-700 w-full max-w-2xl mx-auto relative max-h-[calc(100vh-8rem)]">
          <div ref="root" class="px-3 border-b border-gray-300 dark:border-gray-700 md:text-sm">
            <input type="text" class="border-none bg-transparent w-full h-12 outline-none focus:outline-none focus:ring-0 p-0" placeholder="Search..." v-model="state.search">
          </div>
          <div class="overflow-auto max-h-[calc(100vh-12rem)]">
            <div v-for="(item, i) in state.results" :key="item.name">
              <h3 class="font-bold mt-6 text-gray-800 mb-2 px-4 dark:text-gray-200">{{ item.name }}</h3>
              <div class="space-y-2">
                <div
                  v-for="(object, j) in item.items"
                  :class="{ 'bg-gray-100 dark:bg-gray-700': current.link == object.link }"
                  class="flex flex-col w-full py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 truncate">
                  <VBreadcrumb>
                    <VBreadcrumbItem v-for="breadcrumb in object.breadcrumbs" :href="breadcrumb.url">
                      {{ breadcrumb.title }}
                    </VBreadcrumbItem>
                  </VBreadcrumb>
                  <Link :key="object.title" :href="object.link" class="block md:text-sm text-gray-800 dark:text-gray-300" @click="close">{{ object.title }}</Link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </teleport>
  </div>
</template>

<script setup lang="ts">
import { onMounted, ref, watch, computed, reactive } from "vue";
import { Inertia } from "@inertiajs/inertia";
import axios from "axios";

import useCursor from "@/composables/useCursor";
import useShortcut from "@/composables/useShortcut";

const state = reactive<{
  search: string;
  isOpen: boolean;
  results: {
    name: string;
    items: {
      link: string;
      title: string;
      label: string;
    }[];
  }[];
}>({
  search: "",
  isOpen: false,
  results: [],
});

const root = ref<HTMLElement | null>(null);

const total = computed(() => {
  return state.results.reduce((acc, o) => acc + o.items.length, 0) - 1;
});

const cursor = ref<number>(0);

function increment() {
  cursor.value = cursor.value + 1 > total.value ? cursor.value : cursor.value + 1;
}

function decrement() {
  cursor.value = cursor.value - 1 < 0 ? 0 : cursor.value - 1;
}

const current = computed(() => {
  let all = state.results.reduce((acc: any, cat: any) => [...acc, ...cat.items], []);
  return all[cursor.value];
});

useShortcut("cmd+k", open);

watch(
  () => state.search,
  (value) => {
    if (value != "") {
      axios.get("/api/search", { params: { query: value } }).then((res) => {
        state.results = res.data.filter((i) => i.items.length > 0);
        state.isOpen = true;
      });
    } else {
      state.results = [];
    }
  }
);

onMounted(() => {
  if (root.value) {
    let input = root.value.getElementsByTagName("input")[0];
    setTimeout(function () {
      input.addEventListener("keydown", (e) => {
        if (e.code == "ArrowUp") {
          e.preventDefault();
          decrement();
        } else if (e.code == "ArrowDown") {
          e.preventDefault();
          increment();
        } else if (e.code == "Escape") {
          e.preventDefault();
          close();
        } else if (e.code == "Enter") {
          e.preventDefault();
          state.isOpen = false;
          Inertia.visit(current.value.link);
        }
      });
    }, 0);
  }
});

function open() {
  state.isOpen = !state.isOpen;
  if (state.isOpen && root.value) {
    let input = root.value.getElementsByTagName("input")[0];
    setTimeout(() => input.focus(), 0);
  }
}

function close() {
  state.isOpen = false;
  state.search = "";
}
</script>
