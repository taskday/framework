import { useForm } from "@inertiajs/inertia-vue3";

export default function useProjectForm() {

  const form = useForm({
    title: "",
    description: "",
    field: null,
  });

  function destroy(project: Project) {
    form.delete(route("projects.destroy", project), {
      preserveScroll: true,
      onSuccess: () => {
        form.reset();
      },
    });
  }

  function store(workspace: Workspace) {
    form.post(route("workspaces.projects.store", workspace), {
      preserveScroll: true,
      onSuccess: () => {
        form.reset();
      },
    });
  }

  function update(project: Project) {
    form.put(route("projects.update", project), {
      preserveScroll: true,
      onSuccess: () => {

      },
    });
  }

  return {
    form,
    store,
    update,
    destroy,
  };
}
