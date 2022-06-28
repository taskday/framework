<template>
  <VPageHeader title="Settings" />
  <div v-if="$page.props.jetstream.canUpdateProfileInformation">
    <UpdateProfileInformationForm :user="$page.props.user" />
  </div>
  <div v-if="$page.props.jetstream.canUpdatePassword">
    <UpdatePasswordForm class="mt-10 sm:mt-0" />
  </div>
  <div>
    <NotificationsSection />
  </div>
  <div>
    <DarkmodeSection />
  </div>
  <div v-if="$page.props.jetstream.canManageTwoFactorAuthentication">
    <TwoFactorAuthenticationForm class="mt-10 sm:mt-0" />
  </div>
  <LogoutOtherBrowserSessionsForm :sessions="sessions" class="mt-10 sm:mt-0" />
  <template v-if="$page.props.jetstream.hasAccountDeletionFeatures">
    <DeleteUserForm class="mt-10 sm:mt-0" />
  </template>
</template>

<script lang="ts">
import { defineComponent } from "vue";

import SettingsLayout from "@/layouts/SettingsLayout.vue";

import DeleteUserForm from "./DeleteUserForm.vue";
import LogoutOtherBrowserSessionsForm from "./LogoutOtherBrowserSessionsForm.vue";
import TwoFactorAuthenticationForm from "./TwoFactorAuthenticationForm.vue";
import UpdatePasswordForm from "./UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "./UpdateProfileInformationForm.vue";
import NotificationsSection from "./NotificationsSection.vue";
import DarkmodeSection from "./DarkmodeSection.vue";

export default defineComponent({
  props: ["sessions"],
  layout: SettingsLayout,
  components: {
    DeleteUserForm,
    LogoutOtherBrowserSessionsForm,
    TwoFactorAuthenticationForm,
    UpdatePasswordForm,
    UpdateProfileInformationForm,
    NotificationsSection,
    DarkmodeSection,
  },
});
</script>
