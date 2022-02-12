import { useForm } from "@inertiajs/inertia-vue3";
import { watch } from "vue";

export default function useFieldForm() {
  const form = useForm({
    title: "",
    handle: "",
    type: "",
    options: {}
  });

  function destroy(field: Field) {
    form.delete(route("fields.destroy", field), {
      preserveScroll: true,
      onSuccess: () => {
        form.reset();
      },
    });
  }

  function store() {
    form.post(route("fields.store"), {
      preserveScroll: true,
      onSuccess: () => {
        form.reset();
      },
    });
  }

  function update(field: Field) {
    form.put(route("fields.update", field), {
      preserveScroll: true,
      onSuccess: () => {

      },
    });
  }

  return { form, destroy, store, update };
}
