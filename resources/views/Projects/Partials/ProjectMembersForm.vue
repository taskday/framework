<template>
  <VFormSection @submitted="submit">
    <template #title>Member</template>
    <template #description>All members of this project</template>
    <template #content>
      <div v-for="user in users">
        <div class="flex items-center justify-between" :class="{'text-blue-600': form.members.includes(user.id) }">
          {{ user.name }}
          <VButton type="button" @click.prevent="toggle(user)">
            Toggle
          </VButton>
        </div>
      </div>
    </template>
    <template #actions>
      <VButton type="submit">Save</VButton>
    </template>
  </VFormSection>
</template>

<script setup lang="ts">
import useProjectMembersForm from '@/composables/useProjectMembersForm';
import { onMounted } from 'vue';

let props = defineProps<{ project: Project; users: User[]; }>();

const { form, update } = useProjectMembersForm();

onMounted(() => {
  form.members = props.project.members.map(m => m.user.id)
})

function toggle(user: User) {
  if (form.members.includes(user.id)) {
    form.members = form.members.filter(id => id !== user.id);
  } else {
    form.members.push(user.id);
  }
}

function submit() {
  update(props.project);
}
</script>
