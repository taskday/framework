import { Inertia } from "@inertiajs/inertia";


export default function useSorter() {
  function ltrim(string: string, char: string) {
    const first = [...string].findIndex((a) => a !== char);
    return string.substring(first, string.length);
  }

  function isCurrent(field: Field) {
    const urlParams = new URLSearchParams(window.location.search);

    return ltrim(urlParams.get("sort") ?? '', '-') === field.handle;
  }

  function isDesc(field: Field) {
    const urlParams = new URLSearchParams(window.location.search);

    let handle = urlParams.get("sort") ?? '';

    return handle.includes("-");
  }

  function sortBy(field: Field) {
    const urlParams = new URLSearchParams(window.location.search);

    let current = urlParams.get("sort") ?? "";

    if (ltrim(current, "-") == field.handle) {
      if (current.startsWith("-")) {
        current = field.handle;
      } else {
        current = "-" + field.handle;
      }
    } else {
      current = field.handle;
    }

    Inertia.get(location.href, { sort: current }, { replace: true });
  }

  return { sortBy, isCurrent, isDesc };
}
