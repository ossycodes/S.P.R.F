<template>
  <v-container>
    <v-form @submit.prevent="askQuestion">
      <v-alert v-if="errors.title" type="error" :value="true">{{ errors.title[0] }}</v-alert>
      <v-text-field v-model="form.title" label="Title" type="text" required></v-text-field>

      <v-alert v-if="errors.category_id" type="error" :value="true">{{ errors.category_id[0] }}</v-alert>
      <v-select
        :items="categories"
        item-text="name"
        item-value="id"
        v-model="form.category_id"
        label="category"
      ></v-select>
      <v-alert v-if="errors.body" type="error" :value="true">{{ errors.body[0] }}</v-alert>
      <vue-simplemde v-model="form.body" ref="markdownEditor" />
      <v-btn color="green" type="submit" :disabled="disabled">Ask</v-btn>
    </v-form>
  </v-container>
</template>
<script>
import VueSimplemde from "vue-simplemde";
export default {
  data() {
    return {
      categories: [],
      errors: {},
      form: {
        title: null,
        category_id: null,
        body: null
      }
    };
  },
  components: {
    VueSimplemde
  },
  computed: {
    disabled() {
      return !(this.form.title && this.form.body && this.form.category_id);
    }
  },
  methods: {
    formFIsFilled() {
      return !!(this.form.title && this.form.body && this.form.category_id);
    },
    askQuestion() {
      axios
        .post("api/questions", this.form)
        .then(res => {
          let path = res.data.path;
          this.$router.push(path);
          swal({
            title: "Question created successfully!",
            icon: "success"
          });
        })
        .catch(error => {
          this.errors = error.response.data.errors;
          swal({
            title: "Something went wrong",
            icon: "error"
          });
        });
    }
  },
  created() {
    if (!User.isLoggedIn()) {
      window.location = "/forum";
    }
    axios
      .get("/api/categories")
      .then(res => {
        this.categories = res.data.data;
      })
      .catch(error => {
        //  swal({
        //     title: "Something went wrong",
        //     icon: "error"
        //   });
      });
  }
};
</script>
