import Glider from 'glider-js';

window.addEventListener('load', function(){
    new Glider(document.querySelector('.classroom-image-gallery'), {
        slidesToShow: 1,
        slidesToScroll: 1,
        draggable: false,
        // arrows: {
        //     prev: document.querySelector(`.glider-prev[data-glider-id="${gliderId}"]`),
        //     next: document.querySelector(`.glider-next[data-glider-id="${gliderId}"]`)
        // }
    })
  })
