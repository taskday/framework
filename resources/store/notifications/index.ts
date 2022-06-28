import { usePage } from "@inertiajs/inertia-vue3";
import axios from "axios";

export default {
  namespaced: true,
  state: () => ({
    total: 0,
    notifications: [],
  }),
  getters: {
    hasUnread(state) {
      return state.total > 0;
    },
  },
  mutations: {
    setTotal(state, total) {
      state.total = total;
    },
    setNotifications(state, notifications) {
      state.notifications = notifications;
    },
    resetState(state) {
      state.total = 0;
      state.notifications = [];
    }
  },
  actions: {
    /**
     * Fetch notifications.
     *
     * @param {Number} limit
     */
    fetch(state, limit = 20) {
      console.log('Fetching notifications...');
      axios
        .get("/api/notifications", { params: { limit } })
        .then(({ data: { total, notifications } }) => {
          console.log(notifications);
          state.commit('setTotal', total);
          state.commit(
            "setNotifications",
            notifications.map(({ id, data, created }) => {
              return {
                id: id,
                title: data.title,
                body: data.body,
                created: created,
                user: data.user,
                url: data.url,
              };
            })
          );
        });
    },
    /**
     * Mark the given notification as read.
     *
     * @param {Object} notification
     */
    markAsRead(store, { id }) {
      const index = store.state.notifications.findIndex((n) => n.id === id);
      if (index > -1) {
        store.commit('setTotal', store.state.total - 1);
        store.commit('setNotifications', store.state.notifications.filter((n) => n.id !== id));
        axios.patch(`/api/notifications/${id}/read`).then(() => {
          store.dispatch('fetch');
        });
      }
    },
    /**
     * Mark all notifications as read.
     */
    markAllRead(store) {
      store.commit("resetState");
      axios.post("/api/notifications/mark-all-read");
    },
    /**
     * Listen for Echo push notifications.
     */
    listen(store) {
      let page = usePage();
      //@ts-ignore
      window.Echo.private(`App.Models.User.${page.props.value.user.id}`)
        .notification((notification) => {
          console.log(notification);
          store.commit('setTotal', store.state.total + 1);
          store.commit('setNotifications', store.state.notifications.unshift(notification));
        })
        .listen("NotificationRead", ({ notificationId }) => {
          store.commit('setTotal', store.state.total - 1);
          const index = store.state.notifications.findIndex((n) => n?.id === notificationId);
          if (index > -1) {
            store.commit('setNotifications', store.state.notifications.slice(index));
          }
        })
        .listen("NotificationReadAll", () => {
          store.commit('resetState');
        });
    },
  },
};
