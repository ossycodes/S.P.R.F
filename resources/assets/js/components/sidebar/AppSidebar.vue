<template>
  <v-card>
    <v-toolbar color="cyan" dark dence mt-2>
      <v-toolbar-title>Categories</v-toolbar-title>
    </v-toolbar>
    <v-list>
      <v-list-tile v-for="category in categories" :key="category.id">
        <v-list-tile-content>
          <v-list-tile-title>{{ category.name }}</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
    </v-list>
  </v-card>
</template>
<script>
export default {
  data() {
    return {
      show: false,
      categories: {}
    };
  },
  created() {
    axios
      .get("api/categories")
      .then(res => {
        this.categories = res.data.data;
      })
      .catch(error => {
        console.log(error.response.data);
      });
  }
};
</script>
<style>
[v-cloak] {
  display: none;
}
</style>