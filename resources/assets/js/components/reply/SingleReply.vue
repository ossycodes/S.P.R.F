<template>
  <div class="mt-3">
    <v-card>
      <v-card-title>
        <div class="headline">{{ reply.user }}</div>
        <div class="mL-2">said {{ reply.created_at }}</div>
        <v-spacer></v-spacer>
        <like :reply="reply" :questionSlug="questionSlug"></like>
      </v-card-title>
      <v-divider></v-divider>
      <v-card-text v-if="!editing" v-html="parsedReply"></v-card-text>
    </v-card>
    <v-divider></v-divider>
    <edit-reply v-if="editing" :reply="reply" :questionSlug="questionSlug"></edit-reply>
    <v-card-actions v-else>
      <v-btn icon small v-if="replyOwner(reply.user_id)" @click="editReply(reply.id)">
        <v-icon color="orange">edit</v-icon>
      </v-btn>
      <v-btn icon small v-if="replyOwner(reply.user_id)" @click="deleteReply(reply.id, index)">
        <v-icon color="red">delete</v-icon>
      </v-btn>
    </v-card-actions>
  </div>
</template>
<script>
import editReply from "./EditReply";
import like from "../like/like";
export default {
  props: ["reply", "questionSlug", "index"],
  components: {
    editReply,
    like
  },
  data() {
    return {
      editing: false
      // reply: null,
    };
  },
  computed: {
    parsedReply() {
      return md.parse(this.reply.reply);
    }
  },
  created() {
    EventBus.$on("cancelEditing", () => {
      this.editing = false;
    });
  },
  methods: {
    replyOwner(replyId) {
      return User.replyOwner(replyId);
    },
    deleteReply(replyId, replyIndex) {
      axios
        .delete(`/api/questions/${this.questionSlug}/replies/${replyId}`)
        .then(res => {
          EventBus.$emit("replyDeleted", replyIndex);
        })
        .catch(err => {
          swal({
            title: "Incorrect credentials",
            icon: "error"
          });
        });
    },
    editReply() {
      this.editing = true;
    }
  }
};
</script>