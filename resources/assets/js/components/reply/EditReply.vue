<template>
  <v-container>
    <v-form @submit.prevent="editReply">
      <vue-simplemde v-model="reply.reply" ref="markdownEditor" />
      <v-card-actions>
        <v-btn icon small @click="updateReply(reply.id)">
          <v-icon color="orange">update</v-icon>
        </v-btn>
        <v-btn icon small @click="cancelEditing">
          <v-icon color="red">cancel</v-icon>
        </v-btn>
      </v-card-actions>
    </v-form>
  </v-container>
</template>
<script>
import VueSimplemde from "vue-simplemde";
export default {
  props: ["reply", "questionSlug"],
  components: {
    VueSimplemde
  },
  methods: {
    updateReply(replyId) {
      console.log(replyId, this.questionSlug);
      axios
        .patch(`/api/questions/${this.questionSlug}/replies/${replyId}`, {
          body: this.reply.reply
        })
        .then(res => {
          swal({
            title: "Reply updated successfully",
            icon: "success"
          });
          this.cancelEditing();
        })
        .catch(err => {
          swal({
            title: "Incorrect credentials",
            icon: "error"
          });
        });
    },
    cancelEditing() {
      EventBus.$emit("cancelEditing");
    }
  }
};
</script>