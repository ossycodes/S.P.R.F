<template>
  <v-container>
    <div v-if="loggedIn">
      <v-form @submit.prevent="createReply">
        <vue-simplemde v-model="body" ref="markdownEditor" />
        <v-btn color="green" type="submit">Drop reply</v-btn>
      </v-form>
    </div>
    <div v-else>
      <router-link to="/login">
        <v-btn color="blue">Login to drop reply</v-btn>
      </router-link>
    </div>
  </v-container>
</template>
<script>
import VueSimplemde from "vue-simplemde";
export default {
  props: ["questionSlug"],
  components: {
    VueSimplemde
  },
  data() {
    return {
      body: null,
      loggedIn: User.isLoggedIn()
    };
  },
  methods: {
    createReply() {
      console.log(this.questionSlug);
      axios
        .post(`/api/questions/${this.questionSlug}/replies`, {
          body: this.body
        })
        .then(res => {
          let reply = res.data.reply;
          EventBus.$emit("replyCreated", reply);
          this.body = "";
          swal({
            title: "Reply created successfully",
            icon: "success"
          });
        })
        .catch(err => {});
    }
  }
};
</script>