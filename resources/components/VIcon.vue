<script lang="ts">
import { defineComponent, h } from 'vue';

export default defineComponent({
  props: {
    name: {
      type: String,
      required: true,
    },
  },
  data() {
    return { icon: null, placeholder: null }
  },
  mounted() {
    this.fetchSvgInline('/icons/outline/' + this.name + '.svg')
  },
  methods: {
    fetchSvgInline(url: any) {
      fetch(url)
        .then((response) => response.text())
        .then((response) => {
          const svgStr = response;

          if (svgStr.indexOf("<svg") === -1) {
            return;
          }

          let element = document.createElement('div');
          element.innerHTML = svgStr;

          this.$refs.placeholder.innerHTML = element.firstElementChild?.innerHTML;
        })
        .catch(() => {
          // image.classList.add("not-inline");
        });
    },
  }
});
</script>

<template>
  <svg ref="placeholder" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
  </svg>
</template>
