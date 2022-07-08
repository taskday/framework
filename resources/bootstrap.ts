// @ts-nocheck
import _ from 'lodash';
window._ = _;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from "axios";

window.axios = axios;
window.client = axios; // alias
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from "laravel-echo";

import Pusher from "pusher-js";
window.Pusher = Pusher;

window.Echo = new Echo({
  broadcaster: "pusher",
  key: import.meta.env.VITE_PUSHER_APP_KEY,
  cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
  forceTLS: true
});

/**
 * For Taskday we also need to include some global components for
 * common use case in order to make easy make new the plugins.
 */
import * as Components from "@/taskday";
window.Components = Components;

/**
 * We'll load also the Vue module in the global scope in order to make
 * possible plugins to use Vue without bundle it again.
 */
import * as Vue from "vue";
window.Vue = Vue;

/**
 * Now we enable web push notifications throught a global Laravel object
 * that will contain all the keys regarding the protocol and needed.
 */
window.Laravel = {};
window.Laravel.vapidPublicKey = import.meta.env.VITE_VAPID_PUBLIC_KEY;

/**
 * Inertia Progress
 */
import { InertiaProgress } from "@inertiajs/progress";
InertiaProgress.init({
  // The delay after which the progress bar will
  // appear during navigation, in milliseconds.
  delay: 100,
  // The color of the progress bar.
  color: "#29d",
  // Whether to include the default NProgress styles.
  includeCSS: true,
  // Whether the NProgress spinner will be shown.
  showSpinner: false,
});

if ("serviceWorker" in navigator) {
  navigator.serviceWorker.register("/sw-notifications.js");
}
