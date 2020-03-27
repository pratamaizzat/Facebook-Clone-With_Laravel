<template>
  <div>
    <div class="w-256 h-64 overflow-hidden">
      <img
        src="https://images.unsplash.com/photo-1506260408121-e353d10b87c7?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1400&q=80"
        alt="cover user"
        class="object-cover w-full"
      />
    </div>
  </div>
</template>
 
<script>
export default {
  name: "Show",

  data: () => {
    return {
      user: null,
      loading: true
    };
  },

  mounted() {
    axios
      .get("/api/users/" + this.$route.params.userId)
      .then(res => {
        this.user = res.data;
        this.loading = false;
      })
      .catch(error => {
        console.log("Unable to fetch the user from the server");
        this.loading = false;
      });
    axios
      .get("/api/posts" + this.$route.params.userId)
      .then(res => {
        this.posts = res.data;
        this.loading = false;
      })
      .catch(error => {
        console.log("Unable to fetch posts");
        this.loading = false;
      });
  }
};
</script>
 
<style scoped>
</style>