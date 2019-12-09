<template v-cloak>
  <v-container fluid grid-list-md>
    <v-layout row-wrap>
      <v-flex xs8>
        <question v-for="question in questions" :key="question.id" :question="question"></question>
      </v-flex>
      <v-flex xs4>
        <app-sidebar></app-sidebar>
      </v-flex>
    </v-layout>
  </v-container>
</template>
<script>
import Question from "./Question";
import AppSidebar from "../sidebar/AppSidebar";
export default {
  data() {
    return {
      questions: []
    };
  },
  components: {
    Question,
    AppSidebar
  },
  created() {
    axios
      .get("/api/questions")
      .then(res => {
        this.questions = res.data.data;
      })
      .catch(err => {
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