import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

import Parallax from "../components/Parallax";
import Login from "../components/auth/Login";
import Register from "../components/auth/Register";
import Forum from "../components/forum/Forum";
import Logout from "../components/auth/Logout";
import Read from "../components/forum/Read";
import AskQuestion from "../components/forum/CreateQuestion";
import Category from "../components/category/CreateCategory";
import Profile from "../components/profile/Profile";
import NotFound from "../components/NotFound.vue";

const routes = [
  { path: "*", component: NotFound },
  { path: "/", name: "home", component: Parallax },
  { path: "/profile", component: Profile },
  { path: "/login", component: Login },
  { path: "/register", component: Register },
  { path: "/forum", name: "forum", component: Forum },
  { path: "/logout", component: Logout },
  { path: "/questions/:slug", name: "read", component: Read },
  { path: "/categories", component: Category },
  { path: "/ask", component: AskQuestion }
];

const router = new VueRouter({
  routes, //short for routes:routes
  hashbang: false,
  mode: "history"
});

export default router;
