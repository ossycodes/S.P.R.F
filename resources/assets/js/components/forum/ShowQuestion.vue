<template>
  <v-card>
    <v-container fluid>
      <v-card-title primary-title>
        <div>
          <div class="headline">{{ singleQuestion.title }}</div>
          <span class="grey--text">{{ singleQuestion.user }} said {{ singleQuestion.created_at }}</span>
        </div>
        <v-spacer></v-spacer>
        <v-btn color="teal">{{ replyCount }} {{ singleQuestion.reply_count_string }}</v-btn>
      </v-card-title>
      <v-card-text v-html="singleQuestionBody"></v-card-text>
      <v-card-actions v-if="ownQuestion">
        <v-btn icon small @click="editQuestion">
          <v-icon color="teal">edit</v-icon>
        </v-btn>

        <v-btn icon small @click="deleteQuestion">
          <v-icon color="orange">delete</v-icon>
        </v-btn>
      </v-card-actions>
    </v-container>
  </v-card>
</template>
<script>
export default {
  props: ["singleQuestion"],
  data() {
    return {
      ownQuestion: User.ownQuestion(this.singleQuestion.user_id),
      replyCount: this.singleQuestion.replies_count
    };
  },
  computed: {
    singleQuestionBody() {
      return md.parse(this.singleQuestion.body);
    }
  },
  created() {
    EventBus.$on("replyCreated", () => {
      this.replyCount++;
    });
    EventBus.$on("replyDeleted", () => {
      this.replyCount--;
    });
    Echo.channel("deleteReplyChannel").listen("DeleteReplyEvent", e => {
      this.replyCount--;
    });
  },
  methods: {
    deleteQuestion() {
      axios
        .delete(`/api/questions/${this.singleQuestion.slug}`)
        .then(res => {
          this.$router.push({ name: "forum" });
          swal({
            title: "Question deleted successfully",
            icon: "success"
          });
        })
        .catch(error => {
          swal({
            title: "Something went wrong",
            icon: "error"
          });
        });
    },
    editQuestion() {
      EventBus.$emit("editQuestion");
    }
  }
};
</script>