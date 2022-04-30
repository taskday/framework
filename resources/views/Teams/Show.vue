<script setup>
import DeleteTeamForm from "./Partials/DeleteTeamForm.vue";
import TeamMemberManager from "./Partials/TeamMemberManager.vue";
import UpdateTeamNameForm from "./Partials/UpdateTeamNameForm.vue";

defineProps({
  team: Object,
  availableRoles: Array,
  permissions: Object,
});
</script>

<template>
  <div>
    <VPageHeader>
      <VContainer>
        <div class="flex items-center justify-between">
          <VPageTitle>Team Settings</VPageTitle>
        </div>
      </VContainer>
    </VPageHeader>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-8">
      <UpdateTeamNameForm :team="team" :permissions="permissions" />

      <TeamMemberManager
        class="mt-10 sm:mt-0"
        :team="team"
        :available-roles="availableRoles"
        :user-permissions="permissions" />

      <template v-if="permissions.canDeleteTeam && !team.personal_team">
        <DeleteTeamForm class="mt-10 sm:mt-0" :team="team" />
      </template>
    </div>
  </div>
</template>
