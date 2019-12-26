<template>
  <v-container>
    <div v-for="(reply, index) in content" :key="reply.id">
      <single-reply
        :reply="reply"
        :index="index"
        :questionSlug="questionSlug"
      ></single-reply>
    </div>
  </v-container>
</template>
<script>
import SingleReply from "./SingleReply";
import Users from "../../../../../resources/assets/js/helpers/Users";
export default {
  props: ["replies", "questionSlug"],
  data() {
    return {
      content: this.replies
    };
  },
  components: {
    SingleReply
  },
  created() {
    this.replyCreated();
    this.replyDeleted();
    this.listenForReplyDeletedBroadcastEvent();
    this.listenForBroadcastEvent();
  },
  methods: {
    replyCreated() {
      EventBus.$on("replyCreated", reply => {
        this.idOfCreatedReply = reply;
        this.content.unshift(reply);
        window.scroll(0, 0);
      });
    },
    replyDeleted() {
      EventBus.$on("replyDeleted", replyIndex => {
        this.replies.splice(replyIndex, 1);
        swal({
          title: "Reply deleted successfully",
          icon: "success"
        });
      });
    },
    listenForBroadcastEvent() {
      Echo.private(`App.User.${Users.getId()}`).notification(notification => {
        this.content.unshift(notification.reply);
      });
    },
    listenForReplyDeletedBroadcastEvent() {
      Echo.channel("deleteReplyChannel").listen("DeleteReplyEvent", e => {
        this.content.forEach((el, index) => {
          if (el.id === e.replyId) {
            this.replies.splice(index, 1);
          }
        });
      });
    }
  }
};
</script>
