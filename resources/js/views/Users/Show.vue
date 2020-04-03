<template>
  <div class="flex flex-col items-center mb-12">
    <div class="relative mb-12">
      <div class="w-256 h-64 overflow-hidden">
        <img
          src="https://images.unsplash.com/photo-1506260408121-e353d10b87c7?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1400&q=80"
          alt="cover user"
          class="object-cover w-full"
        />
      </div>
      <div class="absolute flex items-center bottom-0 left-0 -mb-8 ml-12 z-20">
        <div class="w-32">
          <img
            src="https://www.biography.com/.image/ar_8:10%2Cc_fill%2Ccs_srgb%2Cfl_progressive%2Cg_faces:center%2Cq_auto:good%2Cw_620/MTY4MzU0NDMzMjc5NzMxNjcw/julian-castro-sergio-floresbloomberg-via-getty-images-square.jpg"
            alt="user profile image"
            class="object-cover w-32 h-32 border-4 border-gray-200 rounded-full shadow-lg"
          />
        </div>
        <p
          class="ml-4 text-3xl font-semibold text-white shadow-sm tracking-tight"
        >{{user.data.attributes.name}}</p>
      </div>

      <div class="absolute flex items-center bottom-0 right-0 mb-4 mr-12 z-20">
        <button
          v-if="friendButtonText"
          class="py-1 px-3 bg-gray-400 rounded"
          @click="$store.dispatch('sendFriendRequest' , $route.params.userId)"
        >{{friendButtonText}}</button>
      </div>
    </div>
    <p v-if="postLoading">Loading Posts...</p>
    <Post v-else v-for="post in posts.data" :key="post.data.post_id" :post="post" />

    <p v-if="!postLoading && posts.data.length < 1">Make New Your Post!. Get started...</p>
  </div>
</template>
 
<script>
import { mapGetters } from "vuex";
import Post from "../../components/Post";

export default {
  name: "Show",

  components: {
    Post
  },

  data: () => {
    return {
      posts: null,
      postLoading: true
    };
  },

  mounted() {
    this.$store.dispatch("fetchUser", this.$route.params.userId);

    axios
      .get("/api/users/" + this.$route.params.userId + "/posts")
      .then(res => {
        this.posts = res.data;
        this.postLoading = false;
      })
      .catch(error => {
        console.log("Unable to fetch posts");
        this.postLoading = false;
      });
  },

  computed: {
    ...mapGetters({
      user: "user",
      friendButtonText: "friendButtonText"
    })
  }
};
</script>
 
<style scoped>
</style>