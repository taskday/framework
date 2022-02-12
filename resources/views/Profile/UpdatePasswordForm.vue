<template>
  <VFormSection @submitted="updatePassword">
    <template #title>
      Update Password
    </template>

    <template #description>
      Ensure your account is using a long, random password to stay secure.
    </template>

    <template #content>
      <div class="col-span-6 sm:col-span-4">
        <VFormInput
          label="Current Password"
          id="current_password"
          type="password"
          class="mt-1 block w-full"
          v-model="form.current_password"
          ref="current_password"
          autocomplete="current-password"
        />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <VFormInput
          label="New Password"
          id="password"
          type="password"
          class="mt-1 block w-full"
          v-model="form.password"
          ref="password"
          autocomplete="new-password"
        />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <VFormInput
          label="Confirm Password"
          id="password_confirmation"
          type="password"
          class="mt-1 block w-full"
          v-model="form.password_confirmation"
          autocomplete="new-password"
        />
      </div>
    </template>

    <template #actions>
      <span :on="form.recentlySuccessful" class="mr-3">
        Saved.
      </span>

      <VButton
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Save
      </VButton>
    </template>
  </VFormSection>
</template>

<script lang="ts" >
import { defineComponent } from "vue";

export default defineComponent({
  data() {
    return {
      form: this.$inertia.form({
        current_password: "",
        password: "",
        password_confirmation: "",
      }),
    };
  },

  methods: {
    updatePassword() {
      this.form.put(route("user-password.update"), {
        errorBag: "updatePassword",
        preserveScroll: true,
        onSuccess: () => this.form.reset(),
        onError: () => {
          if (this.form.errors.password) {
            this.form.reset("password", "password_confirmation");
            this.$refs.password.focus();
          }

          if (this.form.errors.current_password) {
            this.form.reset("current_password");
            this.$refs.current_password.focus();
          }
        },
      });
    },
  },
});
</script>
