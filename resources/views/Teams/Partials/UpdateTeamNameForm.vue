<script setup>
import { useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
  team: Object,
  permissions: Object,
});

const form = useForm({
  name: props.team.name,
});

const updateTeamName = () => {
  form.put(route("teams.update", props.team), {
    errorBag: "updateTeamName",
    preserveScroll: true,
  });
};
</script>

<template>
  <VFormSection @submitted="updateTeamName">
    <template #title> Team Name </template>

    <template #description> The team's name and owner information. </template>

    <template #content>
      <!-- Team Owner Information -->
      <div class="col-span-6">
        <VFormLabel text="Team Owner" />

        <div class="flex items-center mt-2">
          <img class="w-12 h-12 rounded-full object-cover" :src="team.owner.profile_photo_url" :alt="team.owner.name" />

          <div class="ml-4 leading-tight">
            <div>{{ team.owner.name }}</div>
            <div class="text-gray-700 text-sm">
              {{ team.owner.email }}
            </div>
          </div>
        </div>
      </div>

      <!-- Team Name -->
      <div class="col-span-6 sm:col-span-4">
        <VFormInput
          label="Team Name"
          id="name"
          v-model="form.name"
          type="text"
          class="mt-1 block w-full"
          :disabled="!permissions.canUpdateTeam"
          :errors="form.errors.name"
        />
      </div>
    </template>

    <template v-if="permissions.canUpdateTeam" #actions>
      <VActionMessage :on="form.recentlySuccessful" class="mr-3"> Saved. </VActionMessage>

      <VButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing"> Save </VButton>
    </template>
  </VFormSection>
</template>
