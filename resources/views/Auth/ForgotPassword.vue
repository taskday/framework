<template>
  <VCardAuth titlw="Forgot Password">
    <div class="mb-4 text-sm text-gray-600">
      Forgot your password? No problem. Just let us know your email address and
      we will email you a password reset link that will allow you to choose a
      new one.
    </div>

    <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
      {{ status }}
    </div>

    <form @submit.prevent="submit">
      <div>
        <VFormInput
          label="Email"
          id="email"
          type="email"
          class="block w-full mt-1"
          v-model="form.email"
          required
          autofocus
        />
      </div>

      <div class="flex items-center justify-end mt-4">
        <VButton
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Email Password Reset Link
        </VButton>
      </div>
    </form>
  </VCardAuth>
</template>

<script lang="ts">
import GuestLayout from "@/layouts/GuestLayout.vue";

export default {
  props: {
    status: String,
  },

  layout: GuestLayout,

  data() {
    return {
      form: this.$inertia.form({
        email: "",
      }),
    };
  },

  methods: {
    submit() {
      this.form.post(this.route("password.email"));
    },
  },
};
</script>
