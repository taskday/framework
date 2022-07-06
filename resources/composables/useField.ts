import { useForm } from "@inertiajs/inertia-vue3";
import { inject } from "vue";
import axios from 'axios';
import get from 'lodash/get';

export default function useField() {
  const field = inject<{ value: Field }>('field');
  const card = inject<{ value: Card }>('card');

  const form = useForm({
    value: get(card?.value, 'customFields[' + field?.value?.handle + '].pivot.value') ?? '',
  });

  const onChange = () => {
    axios.put(route('api.cards.fields.update', [card?.value, field?.value]), {
      ...form.data()
    });
  }

  return { state: form, options: field?.value?.options ?? [], onChange }
}
