import { useForm } from "@inertiajs/inertia-vue3";

export default function useWorkspaceForm(data = {}) {
  const form = useForm<Workspace>({ ...data });

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
      ...options,
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
