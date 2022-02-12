import { useForm } from "@inertiajs/inertia-vue3";
import { inject } from "vue";
import get from 'lodash/get';

export default function useField() {
  const field = inject<{ value: Field }>('field');
  const card = inject<{ value: Card }>('card');

  const form = useForm({
    value: get(card?.value, 'customFields[' + field?.value?.handle + '].pivot.value') ?? '',
  });

  const onChange = () => {
    form.put(route('cards.fields.update', [card?.value, field?.value]), {
      preserveState: true,
      preserveScroll: true,
      onError: (errors) => {
        console.error(errors);
      }
    });
  }

  return { state: form, options: field?.value?.options ?? [], onChange }
}
