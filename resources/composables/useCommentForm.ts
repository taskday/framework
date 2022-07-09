import { useForm } from "@inertiajs/inertia-vue3";

export default function useCardForm() {
  const form = useForm({
    body: '',
    attachments: []
  });

  function store(card: Card) {
    form.post(route('cards.comments.store', card), {
      onSuccess: () => {
        form.reset();
      }
    })
  }

  function update(card: Card, comment: Comment) {
    form.put(route('cards.comments.update', [card, comment]), {
      onSuccess: () => {
        form.reset();
      }
    })
  }

  function destroy(card: Card, comment: Comment) {
    form.delete(route('cards.comments.destroy', [card, comment]), {
      preserveScroll: true,
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
