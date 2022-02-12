<template>
  <div
    class="flex flex-col items-center justify-center min-h-screen px-4 py-12 bg-blue-50 sm:px-6 lg:px-8"
  >
    <div class="w-full max-w-md p-8 space-y-8 bg-white rounded shadow">
      <div class="mb-6 text-lg font-bold text-center text-blue-600">Task Day</div>

      <VFormErrors class="mb-4" />

      <form @submit.prevent="submit">
        <div>
          <VFormInput
            label="Name"
            id="name"
            type="text"
            class="block w-full mt-1"
            v-model="form.name"
            :errors="form.errors.name"
            required
            autofocus
            autocomplete="fullname"
          />
        </div>

        <div class="mt-4">
          <VFormInput
            label="Email"
            id="email"
            type="email"
            class="block w-full mt-1"
            v-model="form.email"
            :errors="form.errors.email"
            autocomplete="email"
            required
          />
        </div>

        <div class="mt-4">
          <VFormInput
            label="Password"
            id="password"
            type="password"
            class="block w-full mt-1"
            v-model="form.password"
            :errors="form.errors.password"
            required
            autocomplete="new-password"
          />
        </div>

        <div class="mt-4">
          <VFormInput
            label="Confirm Password"
            id="password_confirmation"
            type="password"
            class="block w-full mt-1"
            v-model="form.password_confirmation"
            :errors="form.errors.password_confirmation"
            required
            autocomplete="confirm-password"
          />
        </div>

        <div class="mt-4" v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature">
          <label for="terms">
            <div class="flex items-center">
              <VFormCheckbox name="terms" id="terms" v-model="form.terms" :errors="form.errors.terms" />

              <div class="ml-2">
                I agree to the
                <a
                  target="_blank"
                  :href="route('terms.show')"
                  class="text-sm text-gray-600 underline hover:text-gray-900"
                >Terms of Service</a>
                and
                <a
                  target="_blank"
                  :href="route('policy.show')"
                  class="text-sm text-gray-600 underline hover:text-gray-900"
                >Privacy Policy</a>
              </div>
            </div>
          </label>
        </div>

        <div class="flex items-center justify-end mt-4">
          <Link
            :href="route('login')"
            class="text-sm text-gray-600 underline hover:text-gray-900"
          >Already registered?</Link>

          <VButton
            class="ml-4"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >Register</VButton>
        </div>
      </form>
    </div>
  </div>
</template>

<script lang="ts">
import LayoutGuestVue from '@/layouts/GuestLayout.vue';

export default {
  layout: LayoutGuestVue,

  data() {
    return {
      form: this.$inertia.form({
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
        terms: false,
      }),
    };
  },

  methods: {
    submit() {
      this.form.post(this.route("register"), {
        onFinish: () => this.form.reset("password", "password_confirmation"),
      });
    },
  },
};
</script>
