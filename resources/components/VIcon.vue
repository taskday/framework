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
          //@ts-ignore
          span.innerHTML = svgStr;
          //@ts-ignore
          const inlineSvg = span.getElementsByTagName("svg")[0];
          // inlineSvg.setAttribute("aria-label", image.alt || "");
          if (this.size == "sm") {
            inlineSvg.setAttribute("class", 'h-3 w-3 fill-current'); // IE doesn't support classList on SVGs
          } else {
            inlineSvg.setAttribute("class", 'h-5 w-5 fill-current'); // IE doesn't support classList on SVGs
          }
          // inlineSvg.setAttribute("focusable", 'false');
          // inlineSvg.setAttribute("role", "img");
          // if (image.height) {
          //   inlineSvg.setAttribute("height", image.height);
          // }
          // if (image.width) {
          //   inlineSvg.setAttribute("width", image.width);
          // }
          // image.parentNode.replaceChild(inlineSvg, image);
        })
        .catch(() => {
          // image.classList.add("not-inline");
        });
    },
  },
});
</script>
