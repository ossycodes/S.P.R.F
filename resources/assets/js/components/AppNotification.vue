<template>
  <div class="text-xs-center">
    <v-menu offset-y>
      <v-btn icon slot="activator">
        <v-icon :color="color">add_alert</v-icon>
        {{ unreadCount}}
      </v-btn>

      <v-list>
        <v-list-tile>Un Read</v-list-tile>
        <v-list-tile v-for="notification in unreadNotification" :key="notification.id">
          <router-link :to="notification.path">
            <v-spacer></v-spacer>
            <v-list-tile-title
              @click="markNotificationAsRead(notification)"
            >{{ notification.message }}</v-list-tile-title>
            <v-spacer></v-spacer>
          </router-link>
        </v-list-tile>
      </v-list>

      <v-list>
        <v-list-tile>Read</v-list-tile>
        <v-list-tile v-for="readnotification in readNotification" :key="readnotification.id">
          <v-list-tile-title>{{ readnotification.message }}</v-list-tile-title>
        </v-list-tile>
      </v-list>
    </v-menu>
  </div>
</template>
<script>
export default {
  data() {
    return {
      readNotification: {},
      unreadNotification: [],
      unreadCount: 0
    };
  },
  computed: {
    color() {
      return this.unreadCount > 0 ? "red" : "red lighten-4";
    }
  },
  created() {
    if (User.isLoggedIn()) {
      this.getUnreadNotification();
      // this.listenForBroadcastEvent();
    }
  },
  methods: {
    getUnreadNotification() {
      axios
        .get("/api/notifications")
        .then(res => {
          this.unreadNotification = res.data.unread;
          this.readNotification = res.data.read;
          this.unreadCount = res.data.unread.length;
        })
        .catch(err => {
          Exception.handle(err);
        });
    },
    markNotificationAsRead(notification) {
      axios
        .patch("/api/notifications", { id: notification.id })
        .then(res => {
          this.unreadNotification.splice(notification, 1);
          this.readNotification.push(notification);
          this.unreadCount--;
        })
        .catch(err => {
          Exception.handle(err);
        });
    },
    listenForBroadcastEvent() {
      Echo.private("App.User." + User.getId()).notification(notification => {
        console.log(notification);
        // this.unreadNotification.unshift(notification);
        //this.unreadCount++;
      });
    }
  }
};
</script>