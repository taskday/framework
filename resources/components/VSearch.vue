<template>
  <div>
    <VFormInput placeholder="Search..." readonly @click="open"/>
    <teleport to="body">
      <div
        v-show="state.isOpen"
        class="fixed h-screen w-screen z-[200] inset-0 flex flex-col p-6 bg-gray-900 bg-opacity-20 backdrop-blur-sm"
      >
        <div @click="state.isOpen = false" class="absolute inset-0"></div>
        <VCard
          class="w-full max-w-2xl mx-auto p-4 bg-white dark:bg-gray-800 relative max-h-[calc(100vh-8rem)]"
        >
          <div ref="root">
            <VFormInput label="" errors="" placeholder="Search..." v-model="state.search" />
          </div>
          <div class="overflow-auto max-h-[calc(100vh-12rem)]">
            <div v-for="(item, i) in state.results" :key="item.name">
              <h3 class="text-gray-600 mb-2 mt-4 dark:gray-800 dark:text-gray-400">{{ item.name }}</h3>
              <div class="space-y-2">
                <div v-for="(object, j) in item.items"
                  :class="{ 'bg-gray-100 dark:bg-gray-700': current.link == object.link }"
                  class="flex flex-col w-full p-1 rounded-md hover:bg-gray-100 dark:hover:bg-gray-600"
                >
                  <p class="text-xs">{{ object.label }}</p>
                  <Link
                    :key="object.title"
                    :href="object.link"
                    class="block"
                    @click="close"
                  >{{ object.title }}</Link>
                </div>
              </div>
            </div>
          </div>
        </VCard>
      </div>
    </teleport>
  </div>
</template>

<script setup lang="ts">
import { onMounted, ref, watch, computed, reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia';
import axios from 'axios';

import useCursor from '@/composables/useCursor';
import useShortcut from '@/composables/useShortcut';

const state = reactive<{
  search: string,
  isOpen: boolean,
  results: {
    name: string,
    items: {
      link: string,
      title: string,
      label: string
    }[]
  }[]
}>({
  search: '',
  isOpen: false,
  results: []
})

const root = ref<HTMLElement | null>(null);

const total = computed(() => {
  return state.results.reduce((acc, o) => acc + (o.items.length), 0) - 1;
})

const cursor = ref<number>(0);

function increment() {
  cursor.value =  cursor.value + 1 > total.value ? cursor.value : (cursor.value + 1);
}

function decrement() {
  cursor.value =  cursor.value - 1 < 0 ? 0 :  cursor.value - 1;
}

const current = computed(() => {
  let all = state.results.reduce((acc: any, cat: any) => [...acc, ...cat.items], []);
  return all[cursor.value];
})

useShortcut('cmd+k', open);

watch(() => state.search, (value) => {
  if (value != "") {
    axios.get("/api/search", { params: { query: value } }).then((res) => {
      state.results = res.data.filter((i) => i.items.length > 0);
      state.isOpen = true;
    });
  } else {
    state.results = [];
  }
})

onMounted(() => {
  if (root.value) {
    let input = root.value.getElementsByTagName('input')[0]
    setTimeout(function () {
      input.addEventListener('keydown', (e) => {
        if (e.code == 'ArrowUp') {
          e.preventDefault();
          decrement()
        } else if (e.code == 'ArrowDown') {
          e.preventDefault();
          increment()
        } else if (e.code == 'Escape') {
          e.preventDefault();
          close();
        } else if (e.code == 'Enter') {
          e.preventDefault();
          state.isOpen = false;
          Inertia.visit(current.value.link)
        }
      })
    }, 0)
  }
})

function open() {
  state.isOpen = !state.isOpen;
  if (state.isOpen && root.value) {
    let input = root.value.getElementsByTagName('input')[0]
    setTimeout(() => input.focus(), 0)
  }
}

function close() {
  state.isOpen = false;
  state.search = "";
}
</script>
