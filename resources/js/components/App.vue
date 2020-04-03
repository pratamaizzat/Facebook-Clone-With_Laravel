<template>
  <div class="flex flex-col flex-1 h-screen overflow-y-hidden">
    <Nav />

    <div class="flex overflow-y-hidden flex-1">
      <Sidebar />
      <div class="overflow-x-hidden w-2/3">
        <router-view :key="$route.fullPath" />
      </div>
    </div>
  </div>
</template>

<script>
import Nav from "./Nav";
import Sidebar from "./Sidebar";
export default {
  name: "App",

  components: {
    Nav,
    Sidebar
  },

  mounted() {
    this.$store.dispatch("fetchAuthUser");
  },
  // menerima title dari title.js@actions
  created() {
    this.$store.dispatch("setPageTitle", this.$route.meta.title); //pada route.js terdapat meta dan title object
  },

  watch: {
    $route(to, from) {
      this.$store.dispatch("setPageTitle", to.meta.title); //pada route.js terdapat meta dan title object
    }
  }
  //akhir menerima title
};
</script>
