export default {
  namespaced: true,
  state: () => {
    if (parseInt(localStorage.getItem('dark') ?? '') === 1) {
      document.querySelector('html')?.classList.add('dark');
    } else {
      document.querySelector('html')?.classList.remove('dark');
    }

    return {
      enabled: parseInt(localStorage.getItem('dark') ?? '') === 1,
    }
  },
  mutations: {
    toggle(state: any) {
      state.enabled = !state.enabled;
      localStorage.setItem('dark', state.enabled ? '1' : '0');
      document.querySelector('html')?.classList.toggle('dark');
    }
  },
  actions: {},
  getters: {},
};
