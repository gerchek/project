import '../css/prices.scss';
import './main';
import './cursor';
import './scroll';
import 'slick-carousel/slick/slick'; 
import Vivus from 'vivus';
import './special';

$('.review__slider').slick.prototype.cleanUpRows = function() {
  var _ = this, originalSlides;
  if(_.options.rows > 1) {
      originalSlides = _.$slides.children().children().clone(true);
      originalSlides.removeAttr('style');
      _.$slider.empty().append(originalSlides);
  }
};
jQuery($('.review__slider').on('init',(slick) => {
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
}));
$('.reviews__slider').on('click', '.slick-current', function(e) {
    e.stopPropagation();
    $('.modal').removeClass('modal_opened');
    $('.burger__menu-wrapper').removeClass('burger__menu-wrapper_opened');
    $('#review-info').toggleClass('modal_opened');
})
$('.graduates__slider').slick({
  focusOnSelect: true,
  slidesToShow:4,
  slidesToScroll:4,
  arrows:true,
  appendArrows:'.graduates__arrows',
  responsive:[
    {
      breakpoint:1050,
      settings:{
        slidesToShow:3,
        slidesToScroll:3
      }
    },
    {
      breakpoint:800,
      settings:{
        slidesToShow:2,
        slidesToScroll:2
      }
    },
    {
      breakpoint:500,
      settings:{
        slidesToShow:1,
        slidesToScroll:1
      }
    },
  ]
});
$('.reviews__slider').slick({
  focusOnSelect: true,
  slidesToShow:2,
  slidesToScroll:1,
  arrows:true,
  appendArrows:'.reviews__arrows',
  asNavFor: '.review__slider',
  responsive:[
    {
      breakpoint: 1100,
      settings:{
        slidesToShow:1
      }
    }
  ]
});
$('.review__slider').slick({
  focusOnSelect: true,
  slidesToShow:1,
  slidesToScroll:1,
  arrows:true,
  appendArrows:'.review__arrows',
  asNavFor: '.reviews__slider',
})
jQuery($('.review__slider').on('breakpoint',(slick) => {
  $('.arrow__circle').remove();
  jQuery('<div>', {
    class: 'arrow__circle'
  }).prependTo('.slick-arrow, .arrow');
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
}));