export default {
  namespaced: true,
  state: () => {
    if ((localStorage.getItem('dark') ?? '') === 'true') {
      document.querySelector('html')?.classList.add('dark');
    } else {
      document.querySelector('html')?.classList.remove('dark');
    }

    return {
      enabled: (localStorage.getItem('dark') ?? '') === 'true',
    }
  },
  mutations: {
    toggle(state: any) {
      state.enabled = !state.enabled;
      localStorage.setItem('dark', state.enabled ? 'true' : 'false');
      document.querySelector('html')?.classList.toggle('dark');
    }
  },
  actions: {},
  getters: {},
};
