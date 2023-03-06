import '../css/partners.scss';
import './main';
import './cursor';
import './scroll';
import 'slick-carousel/slick/slick'; 
import './animateArrows';
import './special';
import Swiper, {Navigation, Scrollbar} from 'swiper';

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