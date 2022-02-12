import { createStore } from "vuex";
// import auth from "./auth";
// import cards from "./cards";
// import comments from "./comments";
// import page from "./page";
import darkmode from "./darkmode";
import notifications from "./notifications";
import sidebar from "./sidebar";
// import search from "./search";
// import projects from "./projects";
// import workspaces from "./workspaces";

const store = createStore({
  modules: {
    // auth,
    // cards,
    // comments,
    // page,
    // search,
    sidebar,
    notifications,
    darkmode,
    // projects,
    // workspaces,
  },
});

export default store;
