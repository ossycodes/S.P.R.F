<template></template>
<script>
import swal from "sweetalert";
export default {
  created() {
    swal({ title: "Successfully logged out!", icon: "success" }).then(value => {
      EventBus.$emit("logout");
    });
  }
};
</script>