<template>
    <!-- Pending: This component is not tested -->
    <div class="flex items-center">
      <span v-for="star in stars" :key="star.id">
        <font-awesome-icon :icon="getStarIcon(star.value)" class="text-yellow-400 w-5 h-5" />
      </span>
      <span class="ml-1 text-gray-500 dark:text-gray-400">{{ rating }}</span>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      rating: {
        type: Number,
        required: true
      }
    },
    computed: {
      stars() {
        let stars = [];
        for (let i = 1; i <= 5; i++) {
          stars.push({
            id: i,
            value: i <= this.rating ? (i - this.rating < 0.5 ? 1 : 0.5) : 0
          });
        }
        return stars;
      }
    },
    methods: {
      getStarIcon(value) {
        if (value === 1) {
          return 'fa-star';
        } else if (value === 0.5) {
          return 'fa-star-half-alt';
        } else {
          return ['far', 'fa-star'];
        }
      }
    }
  };
  </script>
  