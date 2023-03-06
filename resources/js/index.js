import '../css/index.scss';
import './main';
import './cursor';
import './scroll';
import 'slick-carousel/slick/slick';
import './special';
const Vivus = require('vivus');

jQuery($('.banner__info-slides').on('init',(slick) => {
  jQuery('<div>', {
    class: 'arrow__circle'
  }).prependTo('.slick-arrow');
  let arrows = $('.arrow__circle');
  arrows.each((index,el) => {
    arrows[index] = new Vivus(el,{
      duration:200,
      file:`/images/icons/circle.svg`,
      type:"oneByOne",
      start:"manual"
    })
    $(arrows[index].parentEl.parentElement).on('mouseover', () => {
      arrows[index].play(3);
    })
    $(arrows[index].parentEl.parentElement).on('mouseleave', () => {
      arrows[index].play(-3);
    })
  })
}))

$('.banner__info-slides').slick({
    asNavFor: '.banner__images',
    slide:'div',
    focusOnSelect: true,
    rows:0,
    arrows:true,
    appendArrows:'.banner__arrows',
    fade:true,
    focusOnSelect: true,
    speed:$('.banner__info-slides').data('delay'),
    autoplaySpeed:5000
});
$('.banner__images').slick({
    asNavFor: '.banner__info-slides',
    arrows:false,
    speed:$('.banner__images').data('delay'),
    fade:true
});
