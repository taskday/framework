export default {
  namespaced: true,
  state: () => ({
    isOpen: false,
  }),
  mutations: {
    toggle(state) {
      state.isOpen = !state.isOpen;
      console.log(state.isOpen);
    },
    open(state) {
      state.isOpen = true;
    },
    close(state) {
      state.isOpen = false;
    },
  }
}
