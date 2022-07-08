import { useForm } from "@inertiajs/inertia-vue3";
import axios from "axios";

export default function useCardForm() {
  const form = useForm<{
    title: string;
    content: string;
    fields: { [key: string]: string };
  }>({
    title: '',
    content: '',
    fields: {},
  });

  function store(project: Project) {
    form.post(route('projects.cards.store', project), {
      onSuccess: () => {
        form.reset();
      }
    })
  }

  function update(card: Card) {
    form.put(route('cards.update', card))
  }

  function destroy(card: Card) {
    form.delete(route('cards.destroy', card), {
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
