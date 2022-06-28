<template>
  <MenuItem v-slot="{ active }" v-bind="$attrs">
    <span
      :class="[
        active ?
          'background-200' : '',
        'group block text-sm rounded cursor-pointer',
      ]"
    >
      <VFormCheckbox :modelValue="checked">
        <slot></slot>
      </VFormCheckbox>
    </span>
  </MenuItem>
</template>

<script lang="ts">
import { MenuItems, MenuItem } from '@headlessui/vue'
import { defineComponent } from '@vue/runtime-core'

export default defineComponent({
  inheritAttrs: false,
  components: { MenuItems, MenuItem },
  props: {
    checked: Boolean
  }
})
</script>

<style lang="postcss" scoped>
div[role="menu"] > div > span > * {
  @apply p-1.5;
}
</style>
