<template>
  <VFormSection>
    <template #title>
      Delete Account
    </template>

    <template #description>
      Permanently delete your account.
    </template>

    <template #content>
      <div class="max-w-xl text-sm">
        Once your account is deleted, all of its resources and data will be
        permanently deleted. Before deleting your account, please download any
        data or information that you wish to retain.
      </div>

      <div class="mt-5">
        <VButton variant="danger" @click="confirmUserDeletion">
          Delete Account
        </VButton>
      </div>

      <!-- Delete Account Confirmation Modal -->
      <VModal :show="confirmingUserDeletion" @close="closeModal">
        <template #title>
          Delete Account
        </template>

        <template #content>
          Are you sure you want to delete your account? Once your account is
          deleted, all of its resources and data will be permanently deleted.
          Please enter your password to confirm you would like to permanently
          delete your account.

          <div class="mt-4">
            <VFormInput
              type="password"
              class="mt-1 block w-3/4"
              placeholder="Password"
              ref="password"
              v-model="form.password"
              @keyup.enter="deleteUser"
            />
          </div>
        </template>

        <template #footer>
          <VButton variant="secondary" @click="closeModal">
            Nevermind
          </VButton>

          <VButton
            variant="danger"
            class="ml-2"
            @click="deleteUser"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Delete Account
          </VButton>
        </template>
      </VModal>
    </template>
  </VFormSection>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  data() {
    return {
      confirmingUserDeletion: false,

      form: this.$inertia.form({
        password: "",
      }),
    };
  },

  methods: {
    confirmUserDeletion() {
      this.confirmingUserDeletion = true;

      setTimeout(() => this.$refs.password.focus(), 250);
    },

    deleteUser() {
      this.form.delete(route("current-user.destroy"), {
        preserveScroll: true,
        onSuccess: () => this.closeModal(),
        onError: () => this.$refs.password.focus(),
        onFinish: () => this.form.reset(),
      });
    },

    closeModal() {
      this.confirmingUserDeletion = false;

      this.form.reset();
    },
  },
});
</script>
