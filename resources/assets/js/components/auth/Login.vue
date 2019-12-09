<template>
  <v-container>
    <v-form @submit.prevent="login">
      <v-alert v-if="errors.email" type="error" :value="true">{{ errors.email[0] }}</v-alert>
      <v-text-field v-model="form.email" label="E-mail" type="email" required></v-text-field>
      <v-alert v-if="errors.password" type="error" :value="true">{{ errors.password[0] }}</v-alert>
      <v-text-field v-model="form.password" label="Password" type="password" required></v-text-field>
      <v-btn color="green" type="submit">Login</v-btn>
      <router-link to="/register">
        <v-btn color="blue">Register</v-btn>
      </router-link>
    </v-form>
  </v-container>
</template>
<script>
import swal from "sweetalert";
export default {
  data() {
    return {
      errors: {},
      form: {
        email: null,
        password: null
      }
    };
  },
  methods: {
    login() {
      axios
        .post("/api/auth/login", this.form)
        .then(res => {
          swal({
            title: "Logged in successfully",
            icon: "success"
          });
          setTimeout(() => {
            User.responseAfterLogin(res);
          }, 3000);
        })
        .catch(err => {
          this.errors = err.response.data.errors;
          swal({
            title: "Incorrect credentials",
            icon: "error"
          });
        });
    }
  },
  beforeRouteEnter(to, from, next) {
    if (User.isLoggedIn()) {
      next("/forum");
    }
    next();
  }
};
</script>