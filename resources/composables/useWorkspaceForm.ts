import { useForm } from "@inertiajs/inertia-vue3";

export default function useWorkspaceForm() {
  const form = useForm({
    title: "",
    description: "",
  });

  function destroy(workspace: Workspace) {
    form.delete(route("workspaces.destroy", workspace), {
      preserveScroll: true,
      onSuccess: () => {
        form.reset();
      },
    });
  }

  function update(workspace: Workspace, options = {}) {
    form.put(route("workspaces.update", workspace), {
      preserveScroll: true,
    });
  }

  function store() {
    console.log(form);
    form.post(route("workspaces.store"), {
      preserveScroll: true,
      onSuccess: () => {
        form.reset();
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
