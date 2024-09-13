<template>
    <div v-if="showLightbox" class="fixed inset-0 z-50 flex items-center justify-center">
      <div class="absolute inset-0 bg-black opacity-75" @click="closeLightbox"></div>
  
      <div class="relative max-w-3xl w-full bg-white rounded-lg shadow-lg overflow-hidden">
        <button @click="closeLightbox" class="absolute top-2 right-2 z-10 text-gray-500 hover:text-gray-700">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
  
        <video 
            :src="src" 
            controls 
            autoplay 
            loop
            class="w-full"></video>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      showLightbox: {
        type: Boolean,
        required: true,
      },
      src: {
        type: String,
        required: true,
      },
    },
    methods: {
      closeLightbox() {
        this.$emit('close');
      },
    },
  };
  </script>
  