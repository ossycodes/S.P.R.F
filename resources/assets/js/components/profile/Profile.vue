<template>
  <v-container>
    <div v-if="updateProfileMode">
      <v-form @submit.prevent="update">
        <v-alert v-if="errors.name" type="error" :value="true">{{ errors.name[0] }}</v-alert>
        <v-text-field v-model="form.name" label="Name" type="text" required></v-text-field>
        <v-text-field label="E-mail" v-model="form.email" type="email" disabled></v-text-field>
        <v-btn color="green" type="submit">Update Profile</v-btn>
      </v-form>
      <v-btn color="blue" @click="changePasswordMode">Change Password</v-btn>
    </div>

    <div v-else>
      <v-form @submit.prevent="update">
        <v-alert v-if="errors.new_password" type="error" :value="true">{{ errors.new_password[0] }}</v-alert>
        <v-text-field
          v-model="passwordform.new_password"
          label="New Password"
          type="password"
          required
        ></v-text-field>
        <v-alert
          v-if="errors.new_password_confirmation"
          type="error"
          :value="true"
        >{{ errors.new_password_confirmation[0] }}</v-alert>
        <v-text-field
          v-model="passwordform.password_confirmation"
          label="Confirm New Password"
          type="password"
          required
        ></v-text-field>
        <v-btn color="green" type="submit">Update Password</v-btn>
      </v-form>
    </div>
  </v-container>
</template>
<script>
export default {
  data() {
    return {
      form: {
        name: null,
        email: null
      },
      passwordform: {
        new_password: null,
        new_password_confirmation: null
      },
      errors: {},
      updateProfileMode: true
    };
  },
  methods: {
    update() {
      this.updateProfileMode ? this.updateProfile() : this.updatePassword();
    },
    updateProfile() {
      axios
        .patch("/api/profile", { name: this.form.name })
        .then(res => {
          swal({
            title: "Profile updated successfully",
            icon: "success"
          });
          this.$router.push({ name: "forum" });
        })
        .catch(err => {
          (this.errors = err.response.data.errors),
            swal({
              title: "Something went wrong",
              icon: "error"
            });
        });
    },
    changePasswordMode() {
      this.updateProfileMode = false;
    },
    updatePassword() {
      axios
        .patch("/api/password", this.passwordform)
        .then(res => {
          console.log(res.data);
        })
        .catch(err => {
          this.errors = err.response.data.errors;
        });
    }
  },
  created() {
    if (!User.isLoggedIn()) {
      this.$router.push({ name: "home" });
    }
    axios
      .get("/api/auth/me")
      .then(res => {
        this.form.name = res.data.name;
        this.form.email = res.data.email;
      })
      .catch(err => {
        //
      });
  }
};
</script>