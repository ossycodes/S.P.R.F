<template>
  <div>
    <edit-question v-if="editing" :single-question="question"></edit-question>
    <div v-else>
      <show-question v-if="question" :single-question="question"></show-question>
      <replies v-if="question" :replies="replies" :questionSlug="question.slug"></replies>
      <create-reply :questionSlug="questionSlug"></create-reply>
    </div>
  </div>
</template>
<script>
import ShowQuestion from "./ShowQuestion";
import EditQuestion from "./EditQuestion";
import createReply from "../reply/CreateReply";
import Replies from "../reply/Replies";
export default {
  data() {
    return {
      question: null,
      editing: false,
      replies: [],
      questionSlug: null
    };
  },
  components: {
    ShowQuestion,
    EditQuestion,
    createReply,
    Replies
  },
  created() {
    this.listen(), this.getQuestion();
  },
  methods: {
    isLoggedIn() {
      return User.isLoggedIn();
    },
    listen() {
      EventBus.$on("editQuestion", () => {
        this.editing = true;
      });
      EventBus.$on("cancelEditing", () => {
        this.editing = false;
      });
    },
    getQuestion() {
      axios
        .get(`/api/questions/${this.$route.params.slug}`)
        .then(res => {
          this.question = res.data.data;
          this.replies = res.data.data.replies;
          this.questionSlug = res.data.data.slug;
        })
        .catch(error => {
          console.log(error.response);
        });
    }
  }
};
</script>