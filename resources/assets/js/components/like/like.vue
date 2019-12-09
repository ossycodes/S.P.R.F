<template>
  <div v-if="loggedIn">
    <v-btn icon @click="likeOrUnlikeReply">
      <v-icon :color="color">favorite</v-icon>
      {{ count }}
    </v-btn>
  </div>
  <div v-else>
    <router-link to="/login">
      <v-btn color="blue">Login to like reply</v-btn>
    </router-link>
  </div>
</template>
<script>
export default {
  props: ["reply", "questionSlug"],
  data() {
    return {
      loggedIn: User.isLoggedIn(),
      count: this.reply.likes_count,
      liked: this.reply.liked
    };
  },
  computed: {
    color() {
      return this.liked ? "red" : "red lighten-4";
    }
  },
  created() {
    Echo.channel("likeReplyChannel").listen("LikeReplyEvent", e => {
      if (this.reply.id === e.replyId) {
        e.type === 1 ? this.count++ : this.count--;
      }
    });
  },
  methods: {
    likeOrUnlikeReply() {
      return this.liked ? this.unLikeReply() : this.likeReply();
    },
    likeReply() {
      axios
        .post(`/api/replies/${this.reply.id}/likes`, {
          question_slug: this.questionSlug
        })
        .then(res => {
          this.count++;
          this.liked = !this.liked;
          swal({
            title: "Reply liked successfully",
            icon: "success"
          });
        })
        .catch(err => {
          swal({
            title: "Something went wrong",
            icon: "error"
          });
        });
    },
    unLikeReply() {
      axios
        .delete(`/api/replies/${this.reply.id}/likes`)
        .then(res => {
          this.count--;
          this.liked = !this.liked;
          swal({
            title: "Reply Unliked successfully",
            icon: "success"
          });
        })
        .catch(err => {
          swal({
            title: "Something went wrong",
            icon: "error"
          });
        });
    }
  }
};
</script>