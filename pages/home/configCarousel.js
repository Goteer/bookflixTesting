var mySwiper = new Swiper ('.swiper-container', {
  // Optional parameters
  direction: 'horizontal',
  loop: false,
slidesPerView: 7,
  spaceBetween: 20,
breakpoints:{
'@0.50': {
    slidesPerView: 1,
    spaceBetween: 10
  },
'@0.75': {
    slidesPerView: 2,
    spaceBetween: 10
  },
  '@1.00': {
    slidesPerView: 4,
    spaceBetween: 10
  },
  '@1.50': {
    slidesPerView: 4,
    spaceBetween: 10
  },
'@1.75': {
    slidesPerView: 7,
  spaceBetween: 10
  },
},

  // If we need pagination
  pagination: {
    el: '.swiper-pagination',
  },

  // Navigation arrows
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },

  // And if we need scrollbar
  scrollbar: {
    el: '.swiper-scrollbar',
  snapOnRelease: false,
  },



})
