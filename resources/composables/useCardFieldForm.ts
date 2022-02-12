import { useForm } from "@inertiajs/inertia-vue3";

export default function useCardFieldForm() {
  const form = useForm({
    value: ''
  });

  function update(card: Card, field: Field) {
    form.put(route('cards.fields.update', [card, field]), {
      preserveState: true,
      preserveScroll: true,
    })
  }

  return {
    form,
    update
  };
}
