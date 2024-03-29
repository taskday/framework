<template>
  <VFormSection @submitted="updateProfileInformation">
    <template #title>
      Profile Information
    </template>

    <template #description>
      Update your account's profile information and email address.
    </template>

    <template #content>
      <!-- Profile Photo -->
      <div
        class="col-span-6 sm:col-span-4"
        v-if="$page.props.jetstream.managesProfilePhotos"
      >
        <!-- Profile Photo File Input -->
        <VFormInput
          type="file"
          class="hidden"
          ref="photo"
          @change="updatePhotoPreview"
          :errors="form.errors.photo"
        />

        <!-- Current Profile Photo -->
        <div class="mt-2" v-show="!photoPreview">
          <img
            :src="user.profile_photo_url"
            class="rounded-full h-20 w-20 object-cover"
          />
        </div>

        <!-- New Profile Photo Preview -->
        <div class="mt-2" v-show="photoPreview">
          <span
            class="block rounded-full w-20 h-20"
            :style="
              'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' +
              photoPreview +
              '\');'
            "
          >
          </span>
        </div>

        <VButton
          variant="secondary"
          class="mt-2 mr-2"
          type="button"
          @click.prevent="selectNewPhoto"
        >
          Select A New Photo
        </VButton>

        <VButton
          variant="secondary"
          type="button"
          class="mt-2"
          @click.prevent="deletePhoto"
          v-if="user.profile_photo_path"
        >
          Remove Photo
        </VButton>
      </div>

      <!-- Name -->
      <div class="col-span-6 sm:col-span-4">
        <VFormInput
          label="Name"
          id="name"
          type="text"
          class="mt-1 block w-full"
          v-model="form.name"
          autocomplete="name"
          :errors="form.errors.name"
        />
      </div>

      <!-- Email -->
      <div class="col-span-6 sm:col-span-4">
        <VFormInput
          label="Email"
          id="email"
          type="email"
          class="mt-1 block w-full"
          v-model="form.email"
          :errors="form.errors.email"
        />
      </div>
    </template>

    <template #actions>
      <VButton
        type="submit"
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Save
      </VButton>

      <span v-show="form.recentlySuccessful" class="mr-3">
        Done.
      </span>
    </template>
  </VFormSection>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  props: ["user"],

  data() {
    return {
        //@ts-ignore
      form: this.$inertia.form({
        _method: "PUT",
        name: this.user.name,
        email: this.user.email,
        photo: null,
      }),

      photoPreview: null,
    };
  },

  methods: {
    updateProfileInformation() {
      if (this.$refs.photo && this.$refs.photo.files && this.$refs.photo.files.length > 0) {
        this.form.photo = this.$refs.photo.files[0];
      }
//@ts-ignore
      this.form.post(route("user-profile-information.update"), {
        errorBag: "updateProfileInformation",
        preserveScroll: true,
      });
    },

    selectNewPhoto() {
      console.log('new photo');
      this.$refs.photo.click();
    },

    updatePhotoPreview() {
      const reader = new FileReader();

      reader.onload = (e) => {
        this.photoPreview = e.target.result;
      };

      reader.readAsDataURL(this.$refs.photo.files[0]);
    },

    deletePhoto() {
        //@ts-ignore
      this.$inertia.delete(route("current-user-photo.destroy"), {
        preserveScroll: true,
        onSuccess: () => (this.photoPreview = null),
      });
    },
  },
});
</script>
