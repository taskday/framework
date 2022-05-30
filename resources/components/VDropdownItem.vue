<template>
  <MenuItem v-slot="{ active }">
    <span
      :class="[
        active ? 'text-black bg-gray-100 dark:bg-gray-600 dark:text-gray-100' : 'text-gray-600 dark:text-gray-200',
        'group block text-sm rounded cursor-pointer',
      ]"
      v-bind="$attrs"
    >
      <slot :active="active" />
    </span>
  </MenuItem>
</template>

<script lang="ts">
import { MenuItems, MenuItem } from '@headlessui/vue'
import { defineComponent } from '@vue/runtime-core'

export default defineComponent({
  inheritAttrs: false,
  components: { MenuItems, MenuItem },
})
</script>

<style lang="postcss">
div[role="menu"] > div > span > * {
  @apply p-1.5;
}
</style>
