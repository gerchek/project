const Masonry = require("masonry-layout");
const mixitup = require("mixitup");

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

function postData(classes) {
  // Заголовок "Accept" с запросом json данных необходим для того, чтобы не возвращалась 422 ошибка
  const configHeaders = {
    "Accept": "application/json"
  };

  let data = {'classes': classes};

  axios
      .post('/special', data, configHeaders)
      .catch(error => {
        console.error(error);
      });
}

$('.top-line__eye-img').on('click',() => {
  $('body').toggleClass('special');
  if (!("ontouchstart" in document.documentElement)){
    $('body').mCustomScrollbar('destroy');
  }
  $('.card').addClass('popup3d');
  if($('.photos__slide').length){
    const swiper = document.querySelector('.photos__slider').swiper;
    swiper.destroy();
  }
  if($('.leaders__items').length){
    let masonry = Masonry.data(document.querySelector('.leaders__items'));
    masonry.reloadItems();
    masonry.layout();
  }
  let masonry = Masonry.data(document.querySelector('.gallery__items'));
  if(masonry){
    masonry.reloadItems();
    masonry.layout();
  }
  $('.swiper-scrollbar, .photos__arrows').remove();
  $('.reviews__slider').on('click', (e) => {
    e.stopImmediatePropagation();
    $('.modal').removeClass('modal_opened');
    $('.burger__menu-wrapper').removeClass('burger__menu-wrapper_opened');
    $('#review-info').toggleClass('modal_opened');
  })
  if(!$('body').hasClass('special')){
    $('body').removeClass();
  }

  postData($('body').attr('class'));
})
$('.special-controls>*').on('click', () => {
  if($('.leaders__items').length){
    const masonry = Masonry.data(document.querySelector('.leaders__items'));
    masonry.reloadItems();
    masonry.layout();
  }
})
$('.special__bw').on('click', () => {
  $('body').addClass('bw');
  $('body').removeClass('wb');
  $('body').removeClass('green');
  $('body').removeClass('darkblue');

  postData($('body').attr('class'));
})
$('.special__wb').on('click', () => {
  $('body').addClass('wb');
  $('body').removeClass('bw');
  $('body').removeClass('green');
  $('body').removeClass('darkblue');

  postData($('body').attr('class'));
})
$('.special__darkblue').on('click', () => {
  $('body').addClass('darkblue');
  $('body').removeClass('wb');
  $('body').removeClass('green');
  $('body').removeClass('bw');

  postData($('body').attr('class'));
})
$('.special__green').on('click', () => {
  $('body').addClass('green');
  $('body').removeClass('wb');
  $('body').removeClass('bw');
  $('body').removeClass('darkblue');

  postData($('body').attr('class'));
})
$('.special__100fz').on('click', () => {
  $('body').removeClass('fz120');
  $('body').removeClass('fz150');

  postData($('body').attr('class'));
})
$('.special__120fz').on('click', () => {
  $('body').addClass('fz120');
  $('body').removeClass('fz150');

  postData($('body').attr('class'));
})
$('.special__150fz').on('click', () => {
  $('body').addClass('fz150');
  $('body').removeClass('fz120');

  postData($('body').attr('class'));
})
$('.special__normalls').on('click', () => {
  $('body').removeClass('ls2');
  $('body').removeClass('ls4');

  postData($('body').attr('class'));
})
$('.special__2ls').on('click', () => {
  $('body').addClass('ls2');
  $('body').removeClass('ls4');

  postData($('body').attr('class'));
})
$('.special__4ls').on('click', () => {
  $('body').addClass('ls4');
  $('body').removeClass('ls2');

  postData($('body').attr('class'));
})
$('.special__images').on('click', () => {
  $('body').removeClass('noimages');

  postData($('body').attr('class'));
})
$('.special__noimages').on('click', () => {
  $('body').addClass('noimages');
  let sliders = $('.slick-slider');
  sliders = Array.from(sliders);
  const sliderClasses = sliders.map(slider => {
    let classname = $(slider).attr('class');
    classname = classname.split(' ');
    classname = classname[0];
    return classname;
  });
  sliderClasses.forEach((slider) => {
    $('.'+slider).slick('unslick');
  });
  $( ".accordion-header" ).off();
  $(".accordion-header").on('click', function (e) {
    e.stopPropagation();
    if($(this).is('ul')){
      if(e.target==this){
        $(this).children().slideToggle(400);
        $(this).toggleClass('accordion-header_active');
      }
    }
    else{
      $(this).next().slideToggle(400);
      $(this).toggleClass('accordion-header_active');
    }
  })

  postData($('body').attr('class'));
})
