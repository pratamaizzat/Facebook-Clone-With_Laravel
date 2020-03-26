<template>
  <div class="bg-white rounded-lg shadow-sm w-2/3 p-4">
    <div class="flex justify-between items-center">
      <div>
        <div class="w-8">
          <img
            src="https://www.biography.com/.image/ar_8:10%2Cc_fill%2Ccs_srgb%2Cfl_progressive%2Cg_faces:center%2Cq_auto:good%2Cw_620/MTY4MzU0NDMzMjc5NzMxNjcw/julian-castro-sergio-floresbloomberg-via-getty-images-square.jpg"
            class="w-8 h-8 rounded-full object-cover overflow-hidden"
          />
        </div>
      </div>
      <div class="flex-1 mx-3">
        <input
          type="text"
          name="body"
          class="w-full pl-4 h-8 bg-gray-100 rounded-lg placeholder-black focus:outline-none focus:shadow-outline hover:bg-gray-200"
          placeholder="Add a post"
        />
      </div>
      <div>
        <button
          class="flex justify-center items-center bg-gray-100 rounded-full w-10 h-10 focus:outline-none focus:bg-gray-200"
        >
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-current w-5 h-5">
            <path
              d="M21.8 4H2.2c-.2 0-.3.2-.3.3v15.3c0 .3.1.4.3.4h19.6c.2 0 .3-.1.3-.3V4.3c0-.1-.1-.3-.3-.3zm-1.6 13.4l-4.4-4.6c0-.1-.1-.1-.2 0l-3.1 2.7-3.9-4.8h-.1s-.1 0-.1.1L3.8 17V6h16.4v11.4zm-4.9-6.8c.9 0 1.6-.7 1.6-1.6 0-.9-.7-1.6-1.6-1.6-.9 0-1.6.7-1.6 1.6.1.9.8 1.6 1.6 1.6z"
            />
          </svg>
        </button>
      </div>
    </div>
  </div>
</template>
 
<script>
export default {
  name: "NewPost"
};
</script>
 
<style>
</style>