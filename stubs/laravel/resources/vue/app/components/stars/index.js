// import StarsComponent from './StarsComponent.vue';

// export default StarsComponent;

export const starsComponent = (rating) => {
  let html = '';

  for (let i = 1; i <= 5; i++) {
      if (i <= Math.floor(rating)) {
          // Estrella completa
          html += '<i class="fas fa-star text-yellow-400"></i>';
      } else if (i === Math.ceil(rating) && rating % 1 >= 0.5) {
          // Media estrella (solo cuando la parte fraccional de rating es 0.5 o más)
          html += '<i class="fas fa-star-half-alt text-yellow-400"></i>';
      } else {
          // Estrella vacía
          html += '<i class="far fa-star text-yellow-400"></i>';
      }
  }

  return html;
}
