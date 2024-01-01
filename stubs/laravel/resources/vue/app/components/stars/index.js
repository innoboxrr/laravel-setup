// import StarsComponent from './StarsComponent.vue';

// export default StarsComponent;

export const starsComponent = (rating) => {

    let html = '';

    for (let i = 1; i <= 5; i++) {
      if (i <= rating) {
        if (i - rating < 0.5) {
          // Estrella completa
          html += '<i class="fas fa-star text-yellow-400"></i>';
        } else {
          // Media estrella
          html += '<i class="fas fa-star-half-alt text-yellow-400"></i>';
        }
      } else {
        // Estrella vacía
        html += '<i class="far fa-star text-yellow-400"></i>';
      }
    }
  
    return html;

}