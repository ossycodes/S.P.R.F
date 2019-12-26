<template>
  <v-card class="mt-2">
    <v-card-title primary-title>
      <div>
        <h3 headline mb-0>
          <router-link :to="path">{{ title }}</router-link>
        </h3>
        <div class="grey--text">said {{ createdAt }} by {{ user }}</div>
      </div>
    </v-card-title>
    <v-card-text v-html="body"></v-card-text>
  </v-card>
</template>
<script>
export default {
  props: ["question"],
  data() {
    return {
      title: this.question.title,
      body: this.question.body,
      createdAt: this.question.created_at,
      user: this.question.user,
      path: this.question.path
    };
  }
};
</script>