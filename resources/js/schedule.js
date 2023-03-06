import '../css/schedule.scss';
import './main';
import './cursor';
import './scroll';
import 'slick-carousel/slick/slick'; 
import './animateArrows';
import './special';

import {Fancybox} from '@fancyapps/ui/';
import '@fancyapps/ui/dist/fancybox.css';
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
