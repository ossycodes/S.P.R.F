<template>
  <v-container>
    <v-form @submit.prevent="signUp ">
      <v-alert v-if="errors.name" type="error" :value="true">{{ errors.name[0] }}</v-alert>
      <v-text-field v-model="form.name" label="Name" type="text" required></v-text-field>
      <v-alert v-if="errors.email" type="error" :value="true">{{ errors.email[0] }}</v-alert>
      <v-text-field v-model="form.email" label="E-mail" type="email" required></v-text-field>
      <v-alert v-if="errors.password" type="error" :value="true">{{ errors.password[0] }}</v-alert>
      <v-text-field v-model="form.password" label="Password" type="password" required></v-text-field>
      <v-alert
        v-if="errors.password_confirmation"
        type="error"
        :value="true"
      >{{ errors.password_confirmation[0] }}</v-alert>
      <v-text-field
        v-model="form.password_confirmation"
        label="Confirm Password"
        type="password"
        required
      ></v-text-field>
      <v-btn color="green" type="submit">Register</v-btn>
      <router-link to="/login">
        <v-btn color="blue">Login</v-btn>
      </router-link>
    </v-form>
  </v-container>
</template>
<script>
export default {
  data() {
    return {
      form: {
        name: null,
        email: null,
        password: null,
        password_confirmation: null
      },
      errors: {}
    };
  },
  methods: {
    signUp() {
      axios
        .post("/api/auth/signup", this.form)
        .then(res => {
          swal({
            title: "Registered successfully",
            icon: "success"
          });
          setTimeout(() => {
            User.responseAfterLogin(res);
          }, 3000);
        })
        .catch(err => {
          (this.errors = err.response.data.errors),
            swal({
              title: "Something went wrong",
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