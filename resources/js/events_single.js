import '../css/events_single.scss';
import './main';
import './cursor';
import './scroll';
import './animateArrows';
import {Fancybox} from '@fancyapps/ui';
import '@fancyapps/ui/dist/fancybox.css';
import './special';

Fancybox.bind('[data-fancybox="video-gallery"]', {
  Html:{
    video:{
      autoplay:false
    }
  }
})