<template>
  <MenuItem v-slot="{ active  }">
    <span
      :class="[
        active ? 'background-100' : '',
        selected && !active ? 'background-200' : '',
        'group block text-sm rounded cursor-pointer p-2',
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
  props: {
    selected: {
      type: Boolean
    }
  }
})
</script>
