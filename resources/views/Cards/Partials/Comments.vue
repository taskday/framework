<script lang="ts" setup>
import { ref, reactive, onMounted, watch } from "vue";



</script>

<template>
  <div>
    <form @submit.prevent="() => store(card)" class="space-y-8 w-full">
      <VCard>
        <VFormHtmlEditor placeholder="Add a comment..." :toolbar="false" v-model="comment.body"></VFormHtmlEditor>
      </VCard>
      <VButton type="submit">Submit</VButton>
    </form>
    <VCommentList :comments="card.comments" />
  </div>
</template>
