<template>
  <v-toolbar>
    <v-toolbar-title>S.P.R.F</v-toolbar-title>
    <v-spacer></v-spacer>
    <app-notification v-if="loggedIn"></app-notification>
    <div class="hidden-sm-and-down">
      <router-link v-for="item in items" :key="item.id" :to="item.to">
        <v-btn flat v-if="item.show">{{ item.title }}</v-btn>
      </router-link>
    </div>
  </v-toolbar>
</template>
<script>
import AppNotification from "./AppNotification";
export default {
  components: {
    AppNotification
  },
  data() {
    return {
      loggedIn: User.isLoggedIn(),
      items: [
        { title: "home", to: "/", show: true },
        { title: "profile", to: "/profile", show: User.isLoggedIn() },
        { title: "Forum", to: "/forum", show: true },
        {
          title: "Category",
          to: "/categories",
          show: User.isLoggedIn() && User.isAdmin(User.getId())
        },
        { title: "Ask a question", to: "/ask", show: User.isLoggedIn() },
        { title: "Login", to: "/login", show: !User.isLoggedIn() },
        { title: "Logout", to: "/logout", show: User.isLoggedIn() }
      ]
    };
  },
  created() {
    EventBus.$on("logout", () => {
      User.logout();
    });
  }
};
</script>