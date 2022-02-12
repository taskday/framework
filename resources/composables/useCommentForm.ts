import { useForm } from "@inertiajs/inertia-vue3";

export default function useCardForm() {
  const form = useForm({
    body: '',
  });

  function store(card: Card) {
    form.post(route('cards.comments.store', card), {
      onSuccess: () => {
        form.reset();
      }
    })
  }

  function update(card: Card) {
    form.post(route('cards.comments.update', card), {
      onSuccess: () => {
        form.reset();
      }
    })
  }

  function destroy(card: Card) {
    form.post(route('cards.comments.destroy', card), {
      onSuccess: () => {
        form.reset();
      }
    })
  }

  return {
    form,
    store,
    update,
    destroy
  };
}
