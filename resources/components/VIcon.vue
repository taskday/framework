<template>
  <span ref="span"></span>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  props: {
    name: {
      type: String,
      required: true
    },
    size: {
      default: "normal",
    },
    modifier: {
      default: null,
    },
    fixAlign: {
      default: true,
    },
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

          const span = this.$refs.span as HTMLElement;

          span.innerHTML = svgStr;

          const inlineSvg = span.getElementsByTagName("svg")[0];

          if (this.size == "sm") {
            inlineSvg.setAttribute("class", 'h-3 w-3 fill-current'); // IE doesn't support classList on SVGs
          } else {
            inlineSvg.setAttribute("class", 'h-4 w-4 fill-current'); // IE doesn't support classList on SVGs
          }
        })
        .catch(() => {
          // image.classList.add("not-inline");
        });
    },
  },
});
</script>
