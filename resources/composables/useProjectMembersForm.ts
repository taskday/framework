import { PropType } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";

export default function useProjectMembersForm() {
  const form = useForm({
    members: [] as PropType<Member[]>
  });

  function update(project: Project) {
    form.put(route("projects.members.update", [project]), {
      preserveScroll: true,
      onSuccess: () => { },
    });
  }

  return { form, update };
}
