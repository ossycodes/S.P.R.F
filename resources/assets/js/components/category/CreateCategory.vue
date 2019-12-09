<template>
  <v-container>
    <v-alert v-if="errors.name" type="error" :value="true">{{ errors.name[0] }}</v-alert>
    <div>
      <v-form @submit.prevent="submit">
        <v-text-field v-model="form.name" label="Category Name" type="text" required></v-text-field>
        <v-card-actions>
          <v-btn color="teal" type="submit" v-if="!editSlug" :disabled="disabled">Create</v-btn>
          <template v-else>
            <v-btn color="pink" type="submit" :disabled="disabled">Update</v-btn>
            <v-btn color="orange" @click="cancel(form.name)">Cancel</v-btn>
          </template>
        </v-card-actions>
      </v-form>
    </div>

    <v-card>
      <v-toolbar color="indigo" dark dense>
        <v-toolbar-title>Categories</v-toolbar-title>
      </v-toolbar>

      <v-list>
        <div v-for="(category, index) in categories" :key="category.id">
          <v-list-tile>
            <v-list-tile-action>
              <v-btn icon small @click="editCategory(index)">
                <v-icon color="orange">edit</v-icon>
              </v-btn>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title>{{ category.name }}</v-list-tile-title>
            </v-list-tile-content>
            <v-list-tile-action>
              <v-btn icon small @click="deleteCategory(category.slug, index)">
                <v-icon color="red">delete</v-icon>
              </v-btn>
            </v-list-tile-action>
          </v-list-tile>
          <v-divider></v-divider>
        </div>
      </v-list>
    </v-card>
  </v-container>
</template>
<script>
export default {
  data() {
    return {
      editSlug: null,
      categories: {},
      bc: {},
      errors: {},
      form: {
        name: null
      }
    };
  },
  computed: {
    disabled() {
      return !this.form.name;
    }
  },
  created() {
    console.log(!User.isLoggedIn() && !User.isAdmin());
    axios
      .get("api/categories")
      .then(res => {
        this.categories = res.data.data;
      })
      .catch(err => {
        console.log(err.response.data.errors);
      });
  },
  methods: {
    submit() {
      !this.editSlug ? this.createCategory() : this.updateCategory();
    },
    createCategory() {
      axios
        .post("/api/categories", this.form)
        .then(res => {
          this.categories.unshift(res.data);
          this.form.name = "";
          swal({
            title: "Category created successfully",
            icon: "success"
          });
        })
        .catch(err => {
          swal({
            title: "Something went wrong",
            icon: "error"
          });
          this.errors = err.response.data.errors;
        });
    },
    editCategory(index) {
      this.form.name = this.categories[index].name;
      this.editSlug = this.categories[index].slug;
      this.categories.splice(index, 1);
    },
    updateCategory() {
      axios
        .put(`/api/categories/${this.editSlug}`, this.form)
        .then(res => {
          this.categories.unshift(res.data);
          swal({
            title: "Category updated successfully",
            icon: "success"
          });
        })
        .catch(err => {
          this.errors = err.response.data.errors;
          swal({
            title: "Something went wrong",
            icon: "error"
          });
        });
    },
    deleteCategory(categorySlug, index) {
      axios
        .delete(`/api/categories/${categorySlug}`)
        .then(res => {
          this.categories.splice(index, 1);
          swal({
            title: "Category deleted successfully",
            icon: "success"
          });
        })
        .catch(err => {
          swal({
            title: "Something went wrong",
            icon: "error"
          });
        });
    },
    // fi(element) {
    //   this.bc.forEach((el) => {
    //     el.name = this.form.name
    //   });
    //   // console.log(element);
    //   // return element === this.form.name;
    // },
    cancel(x) {
      // console.log(this.bc.findIndex(this.fi));
      this.editSlug = null;
      this.form.name = "";
    }
  },
  beforeRouteEnter(to, from, next) {
    console.log(User.isLoggedIn());
    if (!User.isLoggedIn() && !User.isAdmin()) {
      next("/login");
    }
    next();
  }
};
</script>