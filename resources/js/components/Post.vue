<template>
  <div class="bg-white rounded-md shadow-sm w-2/3 mt-6 overflow-hidden">
    <div class="flex flex-col p-4">
      <div class="flex items-center">
        <div class="h-8">
          <img
            src="https://www.biography.com/.image/ar_8:10%2Cc_fill%2Ccs_srgb%2Cfl_progressive%2Cg_faces:center%2Cq_auto:good%2Cw_620/MTY4MzU0NDMzMjc5NzMxNjcw/julian-castro-sergio-floresbloomberg-via-getty-images-square.jpg"
            class="w-8 h-8 rounded-full object-cover overflow-hidden"
          />
        </div>
        <div class="ml-3 leading-4">
          <div class="text-sm font-bold">{{post.data.attributes.posted_by.data.attributes.name}}</div>
          <div class="flex items-end text-xs font-base text-gray-600">
            {{post.data.attributes.posted_at}}
            <span class="block px-1">&bull;</span>
          </div>
        </div>
      </div>
      <div class="mt-6">
        <p>{{ post.data.attributes.body }}</p>
      </div>
    </div>
    <div v-if="post.data.attributes.image" class="w-full bg-cover">
      <img :src="post.data.attributes.image" class="w-full" />
    </div>

    <div class="px-4 pt-2 flex justify-between items-center text-gray-600 text-sm">
      <div>
        <p>Jon Doe and 231 others</p>
      </div>

      <div>
        <p>298 comments</p>
      </div>
    </div>

    <div class="flex justify-center items-center border-gray-300 m-4 p-4">
      <button
        class="flex items-center justify-center py-2 rounded-lg text-sm text-gray-600 w-full hover:bg-gray-200 hover:text-gray-700"
      >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-current w-5 h-5">
          <path
            d="M20.8 15.6c.4-.5.6-1.1.6-1.7 0-.6-.3-1.1-.5-1.4.3-.7.4-1.7-.5-2.6-.7-.6-1.8-.9-3.4-.8-1.1.1-2 .3-2.1.3-.2 0-.4.1-.7.1 0-.3 0-.9.5-2.4.6-1.8.6-3.1-.1-4.1-.7-1-1.8-1-2.1-1-.3 0-.6.1-.8.4-.5.5-.4 1.5-.4 2-.4 1.5-2 5.1-3.3 6.1l-.1.1c-.4.4-.6.8-.8 1.2-.2-.1-.5-.2-.8-.2H3.7c-1 0-1.7.8-1.7 1.7v6.8c0 1 .8 1.7 1.7 1.7h2.5c.4 0 .7-.1 1-.3l1 .1c.2 0 2.8.4 5.6.3.5 0 1 .1 1.4.1.7 0 1.4-.1 1.9-.2 1.3-.3 2.2-.8 2.6-1.6.3-.6.3-1.2.3-1.6.8-.8 1-1.6.9-2.2.1-.3 0-.6-.1-.8zM3.7 20.7c-.3 0-.6-.3-.6-.6v-6.8c0-.3.3-.6.6-.6h2.5c.3 0 .6.3.6.6v6.8c0 .3-.3.6-.6.6H3.7zm16.1-5.6c-.2.2-.2.5-.1.7 0 0 .2.3.2.7 0 .5-.2 1-.8 1.4-.2.2-.3.4-.2.6 0 0 .2.6-.1 1.1-.3.5-.9.9-1.8 1.1-.8.2-1.8.2-3 .1h-.1c-2.7.1-5.4-.3-5.4-.3H8v-7.2c0-.2 0-.4-.1-.5.1-.3.3-.9.8-1.4 1.9-1.5 3.7-6.5 3.8-6.7v-.3c-.1-.5 0-1 .1-1.2.2 0 .8.1 1.2.6.4.6.4 1.6-.1 3-.7 2.1-.7 3.2-.2 3.7.3.2.6.3.9.2.3-.1.5-.1.7-.1h.1c1.3-.3 3.6-.5 4.4.3.7.6.2 1.4.1 1.5-.2.2-.1.5.1.7 0 0 .4.4.5 1 0 .3-.2.6-.5 1z"
          />
        </svg>
        <p class="mx-2">Like</p>
      </button>
      <button
        class="ml-32 flex items-center justify-center py-2 rounded-lg text-sm text-gray-600 w-full hover:bg-gray-200 hover:text-gray-700"
      >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-current w-5 h-5">
          <path
            d="M20.3 2H3.7C2 2 .6 3.4.6 5.2v10.1c0 1.7 1.4 3.1 3.1 3.1V23l6.6-4.6h9.9c1.7 0 3.1-1.4 3.1-3.1V5.2c.1-1.8-1.3-3.2-3-3.2zm1.8 13.3c0 1-.8 1.8-1.8 1.8H9.9L5 20.4V17H3.7c-1 0-1.8-.8-1.8-1.8v-10c0-1 .8-1.8 1.8-1.8h16.5c1 0 1.8.8 1.8 1.8v10.1zM6.7 6.7h10.6V8H6.7V6.7zm0 2.9h10.6v1.3H6.7V9.6zm0 2.8h10.6v1.3H6.7v-1.3z"
          />
        </svg>
        <p class="mx-2">Comment</p>
      </button>
    </div>
  </div>
</template>
 
<script>
export default {
  name: "Post",
  props: ["post"]
};
</script>
 
<style>
</style>