<script lang="ts">
export default {
  inheritAttrs: false,
  data() {
    return {
      flash: this.$page.props.flash,
      show: true,
    }
  },
  mounted() {
    this.falsh = this.$page.props.flash;
    setInterval(() => {
      this.show = false;
    }, 3000)
  },
  watch: {
    '$page.props.flash': {
      handler() {
        this.flash = this.$page.props.flash;
      },
      deep: true,
    },
  }
};
</script>

<template>
  <div v-if="flash" class="flex items-center justify-center text-center">
    <div
      v-show="show"
      class="fixed mt-2 top-0 w-full max-w-xs p-2 z-10"
      :class="{
        'bg-red-100 dark:bg-red-400 text-red-600 dark:text-red-400 dark:bg-opacity-20': flash.type == 'danger',
        'bg-gren-100 dark:bg-gren-400 text-gren-600 dark:text-gren-400 dark:bg-opacity-20': flash.type == 'success',
      }"
    >
    {{ flash.message }}
    </div>
  </div>
</template>
