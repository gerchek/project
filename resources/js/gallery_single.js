import '../css/gallery_single.scss';
import './main';
import './cursor';
import './scroll';
import './animateArrows';
import './special';

const imagesLoaded = require('imagesloaded');
imagesLoaded.makeJQueryPlugin($);
import {Fancybox} from '@fancyapps/ui/';
import '@fancyapps/ui/dist/fancybox.css';
const Masonry = require('masonry-layout');
if(window.innerWidth>800){
  const mix = document.querySelector('.gallery__items');
  $('.gallery__item:visible:nth-child(2)').addClass('gallery__second-item');
  const $msnry = new Masonry(mix,{
    itemSelector:'.gallery__item',
    columnWidth:'.gallery__item',
    gutter:20,
    horizontalOrder:true
  });
  imagesLoaded($msnry,function(instance){
    $msnry.reloadItems();
    $msnry.layout();
  });

}
