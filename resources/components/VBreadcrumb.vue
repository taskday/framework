<template>
  <nav class="breadcrumbs">
    <ul class="flex items-center font-medium text-gray-700 dark:text-gray-200 whitespace-nowrap">
      <slot />
    </ul>
  </nav>
</template>

<style lang="postcss">
.breadcrumbs ul > li + li::before {
  display: inline-block;
  margin-right: 0.5rem;
  margin-left: 0.5rem;
  content: "/";
  @apply text-gray-700 dark:text-gray-200;
}
.breadcrumbs ul > li + li {
  @apply flex;
}
</style>
