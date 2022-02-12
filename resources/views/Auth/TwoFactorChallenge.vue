<template>
  <VCardAuth>
    <div class="mb-4 text-sm text-gray-600">
      <template v-if="!recovery">
        Please confirm access to your account by entering the authentication
        code provided by your authenticator application.
      </template>

      <template v-else>
        Please confirm access to your account by entering one of your emergency
        recovery codes.
      </template>
    </div>

    <VFormErrors class="mb-4" />

    <form @submit.prevent="submit">
      <div v-if="!recovery">
        <VFormInput
          label="Code"
          ref="code"
          id="code"
          type="text"
          inputmode="numeric"
          class="mt-1 block w-full"
          v-model="form.code"
          autofocus
          autocomplete="one-time-code"
        />
      </div>

      <div v-else>
        <VFormInput
          label="Recovery Code"
          ref="recovery_code"
          id="recovery_code"
          type="text"
          class="mt-1 block w-full"
          v-model="form.recovery_code"
          autocomplete="one-time-code"
        />
      </div>

      <div class="flex items-center justify-end mt-4">
        <button
          type="button"
          class="text-sm text-gray-600 hover:text-gray-900 underline cursor-pointer"
          @click.prevent="toggleRecovery"
        >
          <template v-if="!recovery">
            Use a recovery code
          </template>

          <template v-else>
            Use an authentication code
          </template>
        </button>

        <VButton
          class="ml-4"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Login
        </VButton>
      </div>
    </form>
  </VCardAuth>
</template>

<script lang="ts">
export default {
  data() {
    return {
      recovery: false,
      form: this.$inertia.form({
        code: "",
        recovery_code: "",
      }),
    };
  },

  methods: {
    toggleRecovery() {
      this.recovery ^= true;

      this.$nextTick(() => {
        if (this.recovery) {
          this.$refs.recovery_code.focus();
          this.form.code = "";
        } else {
          this.$refs.code.focus();
          this.form.recovery_code = "";
        }
      });
    },

    submit() {
      this.form.post(this.route("two-factor.login"));
    },
  },
};
</script>
