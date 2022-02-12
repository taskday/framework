import { useForm } from "@inertiajs/inertia-vue3";

export default function useProjectForm() {

  const form = useForm({
    handle: "",
    hidden: ""
  });

  function destroy(project: Project, field: Field) {
    form.delete(route("projects.fields.destroy", [project, field]), {
      preserveScroll: true,
      onSuccess: () => {
        form.reset();
      },
    });
  }

  function update(project: Project, field: Field) {
    form.put(route("projects.fields.update", [project, field]), {
      preserveScroll: true
    });
  }

  return {
    form,
    update,
    destroy,
  };
}
