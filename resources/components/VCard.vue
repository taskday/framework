<template>
  <div class="rounded-lg shadow overflow-hidden background-300">
    <div v-if="$slots.header">
      <slot name="header"></slot>
    </div>
    <div class="px-4 py-5 sm:p-6">
      <slot></slot>
    </div>
    <div v-if="$slots.footer">
      <div class="px-4 py-3 sm:px-6">
        <slot name="footer"></slot>
      </div>
    </div>
  </div>
</template>
