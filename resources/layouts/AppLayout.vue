<template>
  <Head>
    <title>{{ $page.props.title }}</title>
  </Head>
  <div class="flex justify-center w-full md:flex-row antialiased">
    <div
      v-show="$store.state.sidebar.isOpen"
      class="md:hidden bg-gray-900 bg-opacity-25 fixed inset-0 z-10"
      @click.prevent="() => $store.commit('sidebar/close')"
    ></div>
    <TheSidebar
      class="transform md:transform-none md:hidden top-0 left-0 bg-white fixed md:static w-full max-w-[16rem] h-full overflow-auto ease-in-out transition-all duration-300 z-30 flex-shrink-0 border-r"
      :class="{ '-translate-x-full': !$store.state.sidebar.isOpen, 'translate-x-0': $store.state.sidebar.isOpen }"
    />
    <div class="flex-1 w-full">
      <TheHeader />
      <VFlashMessages />
      <slot></slot>
    </div>
  </div>
</template>
