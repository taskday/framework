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
  margin-right: 0.1rem;
  margin-left: 0.1rem;
  transform: translateY(10%);
  content: url('data:image/svg+xml,<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.172 12L9.34302 9.17199L10.757 7.75699L15 12L10.757 16.243L9.34302 14.828L12.172 12Z" fill="%23606a77"/></svg>');
  @apply text-gray-500 dark:text-gray-200;
}
.breadcrumbs ul > li + li {
  @apply flex;
}
</style>
