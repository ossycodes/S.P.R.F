<template>
  <v-container>
    <v-card>
      <v-form @submit.prevent="updateQuestion">
        <v-text-field v-model="form.title" label="Title" type="text" required></v-text-field>
        <vue-simplemde v-model="form.body" ref="markdownEditor" />
        <!-- <v-btn color="green" type="submit" @click="updateQuestion">Update</v-btn> -->
        <v-card-actions>
          <v-btn color="teal" type="submit">Update</v-btn>

          <v-btn color="teal" @click="cancelEditing">cancel</v-btn>
        </v-card-actions>
      </v-form>
    </v-card>
  </v-container>
</template>
<script>
import VueSimplemde from "vue-simplemde";
export default {
  props: ["singleQuestion"],
  components: {
    VueSimplemde
  },
  data() {
    return {
      form: {
        title: null,
        body: null
      }
    };
  },
  created() {
    this.form = this.singleQuestion;
  },
  methods: {
    updateQuestion() {
      axios
        .patch(`/api/questions/${this.form.slug}`, this.form)
        .then(res => {
          swal({
            title: "Question updated successfully",
            icon: "success"
          });
          this.cancelEditing();
        })
        .catch(err => {
          console.log(err.response.data);
        });
    },
    cancelEditing() {
      EventBus.$emit("cancelEditing");
    }
  }
};
</script>