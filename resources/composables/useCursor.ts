import { Ref, ref } from 'vue';

interface CursorOptions {
  total: Ref<number>
}

export default function (options: CursorOptions) {
  const cursor = ref<number>(0);

  function increment() {
    cursor.value =  cursor.value + 1 > options.total.value ? cursor.value : (cursor.value + 1);
  }

  function decrement() {
    cursor.value =  cursor.value - 1 < 0 ? 0 :  cursor.value - 1;
  }

  return { cursor, increment, decrement };
}
