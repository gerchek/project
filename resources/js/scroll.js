const Vivus = require('vivus');
require('jquery-mousewheel')($);
require('malihu-custom-scrollbar-plugin')($);
let allHeadImages = Array.from(document.querySelectorAll('.head__img'));


allHeadImages = allHeadImages.map((value) => value.id);
// Все картинки при заголовках
allHeadImages.forEach((el,index) => {
  allHeadImages[index] = new Vivus(el,{
    duration:200,
    file:`/images/content/${el}.svg`,
    type:"oneByOne",
    start:"manual"
  })
})
let scrollHeightAtStart = 0;
let currentHeight = 0;
// Инициализация кастомного скроллбара
$(window).on('load',function(){
  if (!("ontouchstart" in document.documentElement)){
    $('body').mCustomScrollbar({
      mouseWheelPixels: 500,
      scrollInertia:1000,
      theme:'my-theme',
      callbacks:{
        whileScrolling:function(){
          try{
            $('.section:mcsInSight(exact)').addClass('slideTop');
            scrollHeightAtStart = this.mcs.top;
          }
          catch(e){

          }
        }
      }
    });
    $('.burger__content').mCustomScrollbar({
      theme:'my-theme'
    })
  }
});
// Interval Который в зависимости от того попал ли в область видимости элемент дает ему класс.
const interval = setInterval(function() {
  if((currentHeight!=scrollHeightAtStart || currentHeight === 0) && !("ontouchstart" in document.documentElement)){
    try{
      $('.card:mcsInSight(exact):not(.popup3d)').first().addClass('popup3d');
      $('.about__collage-photo:mcsInSight(exact):not(.about__collage-photo_animate)').first().addClass('about__collage-photo_animate')
      if(!$('.about__collage-photo:not(.about__collage-photo_animate)').length && !$('.card:not(.popup3d)').length){
        clearInterval(interval);
      }
    }
    catch(e){
    }
  }
  else if (("ontouchstart" in document.documentElement)){
    $('.card').addClass('popup3d');
    $('.about__collage-photo').addClass('about__collage-photo_animate');
  }
},150);
// Интервал для стрелки "вверх" и для призаголовочных изображений
const arrowInterval = setInterval(function() {
  if (!("ontouchstart" in document.documentElement)){
    allHeadImages.forEach((el) => {
      try{
        if($(`#${el.parentEl.id}:mcsInSight(exact)`).length) { // находится ли заголовок на экране
          el.play(1.5);
        }
      }
      catch(e){
      }
    })
  }
  if (!("ontouchstart" in document.documentElement)){
    allHeadImages.forEach((el) => {
      el.play(1.5);
    });
  }
  if((currentHeight<scrollHeightAtStart && scrollHeightAtStart<-1200) || scrollHeightAtStart < -2000) $('.arrow-top').addClass('arrow-top_active');
  else $('.arrow-top_active').removeClass('arrow-top_active');
  currentHeight = scrollHeightAtStart;
},300);
$('.arrow-top').on('click', () => {
  if (!("ontouchstart" in document.documentElement))
    $('body').mCustomScrollbar("scrollTo","top");
  else $('body').animate({
    scrollTop: 0
  }, 800);
});
