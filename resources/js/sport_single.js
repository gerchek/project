import '../css/sport_single.scss';
import './main';
import './cursor';
import './scroll';
import 'slick-carousel/slick/slick'; 
import './special';
import Vivus from 'vivus';
import Swiper, {Navigation, Scrollbar} from 'swiper';

import {Fancybox} from '@fancyapps/ui/';
import '@fancyapps/ui/dist/fancybox.css';


$('.treners__slider').slick.prototype.cleanUpRows = function() {
  var _ = this, originalSlides;
  if(_.options.rows > 1) {
      originalSlides = _.$slides.children().children().clone(true);
      originalSlides.removeAttr('style');
      _.$slider.empty().append(originalSlides);
  }
};
const swiper = new Swiper('.photos__slider', {
  modules:[Navigation, Scrollbar],
  autoHeight:true,
  rewind:true,
  navigation:{
    nextEl:'.slick-next',
    prevEl:'.slick-prev',
  },
  scrollbar:{
    el:'.swiper-scrollbar',
    draggable:true,
    dragClass:'scroll'
  },    
  threshold:20,
  spaceBetween:20,
  scrollbar:{
    el:'.swiper-scrollbar',
    draggable:true,
    dragClass:'scroll'
  },
  breakpoints:{
    1000: {
      slidesPerGroup:3,
      slidesPerView: 3,
    },
    600: {
      slidesPerGroup:2,
      slidesPerView: 2,
    },
    320:{
      slidesPerGroup:1,
      slidesPerView: 1,
    }
  }
})
Fancybox.bind("[data-fancybox]", {
  Image: {
    Panzoom: {
      zoomFriction: 0.7,
      maxScale: function () {
        return 5;
      },
    },
  },
});


jQuery($('.treners__slider').on('init',function(slick) {
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
var slidesToShow = 3;
var childElements = $('.treners__slider').children().length;
// Check if we can fulfill the preferred slidesToShow
if( slidesToShow > (childElements) ) {
  // Otherwise, make slidesToShow the number of slides - 1
  // Has to be -1 otherwise there is nothing to scroll for - all the slides would already be visible
  slidesToShow = (childElements);
}
$('.treners__slider').slick({
  focusOnSelect: true,
  slidesToShow:slidesToShow,
  slidesToScroll:3,
  arrows:true,
  appendArrows:'.treners__arrows',
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
      breakpoint:600,
      settings:{
        slidesToShow:1,
        slidesToScroll:1
      }
    },
  ]
});
jQuery($('.treners__slider').on('breakpoint', (slick) => {
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