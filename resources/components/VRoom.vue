<template>
  <div class="flex items-center">
    <VAvatar v-for="user in users" :user="user" />
  </div>
</template>

<script lang="ts" setup>
import { onMounted, ref } from "vue";

const props = defineProps({
  name: {
    type: String,
    default: "",
  }
})

const users = ref<User[]>([]);

onMounted(() => {
  //@ts-ignore
  window.Echo.join(props.name)
    .here((currentUsers) => {
      users.value = currentUsers
    })
    .joining((user: any) => {
      users.value.push(user)
    })
    .leaving((user) => {
      users.value = users.value.slice(users.value.findIndex((u: any) => u.id == user.id), 1)
    });
});

</script>

<style lang="postcss">
.room > div + div {
  @apply ml-2;
}
</style>
