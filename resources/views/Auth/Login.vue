<template>
  <form action="#" @submit.prevent="submit">
    <VCardAuth :message="form.errors.message">
      <VFormInput :errors="form.errors.email" autocomplete="none" v-model="form.email" label="Email" type="email" />
      <VFormInput
        :errors="form.errors.password"
        autocomplete="none"
        v-model="form.password"
        label="Password"
        type="password" />
      <div class="flex flex-col items-start space-y-5 justify-between">
        <VFormCheckbox :errors="form.errors.rememberMe" v-model="form.rememberMe" label="Remember me" />
        <VLink class="flex-shirnk-0 whitespace-nowrap" :href="route('password.request')">Forgot password?</VLink>
      </div>
      <VButton type="submit" class="w-full">Sign In</VButton>
    </VCardAuth>
  </form>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import GuestLayout from "@/layouts/GuestLayout.vue";

export default defineComponent({
  layout: GuestLayout,

  data() {
    return {
      form: this.$inertia.form({
        email: "",
        password: "",
        remember: false,
        _token: this.$page.props.csrf_token,
      }),
    };
  },

  methods: {
    submit() {
      this.form
        .transform((data) => ({
          ...data,
          remember: this.form.remember ? "on" : "",
        }))
        .post(this.route("login"), {
          onFinish: () => this.form.reset("password"),
        });
    },
  },
});
</script>
