import { useForm } from "@inertiajs/inertia-vue3";

export default function useProjectMembersForm(project: Project) {
  const form = useForm({
    members: Array<number>()
  });

  function submit() {
    console.log(form.members)
    //@ts-ignore
    form.post(route("projects.members.store", [project]), {
      preserveScroll: true,
      onSuccess: () => { },
    });
  }

  return { form, submit };
}
