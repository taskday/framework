<script setup>
import CreateTeamForm from "./Partials/CreateTeamForm.vue";
</script>

<template>
  <div>
    <VPageHeader>
      <VContainer>
        <div class="flex items-center justify-between">
          <VPageTitle>Create New Team</VPageTitle>
        </div>
      </VContainer>
    </VPageHeader>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
      <CreateTeamForm />
    </div>
  </div>
</template>
