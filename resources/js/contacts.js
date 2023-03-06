import '../css/contacts.scss';
import './main';
import './cursor';
import './scroll';
import 'slick-carousel/slick/slick';
import '/images/icons/map-mark.svg';
import './animateArrows';
import './special';

import {Fancybox} from '@fancyapps/ui/';
import '@fancyapps/ui/dist/fancybox.css';
import ymaps from 'ymaps';
const mapContainer = document.querySelector('.contacts__map');
$('.contacts__map').on('mouseenter', () => {
    if (!("ontouchstart" in document.documentElement)){
        $('body').mCustomScrollbar('disable');
    }
})
$('.contacts__map').on('mouseleave', () => {
    if (!("ontouchstart" in document.documentElement)){
        $('body').mCustomScrollbar('update');
    }
})
ymaps
    .load('https://api-maps.yandex.ru/2.1/?apikey=8f8c0eb1-a67c-4a1a-867a-b57a8e5cee09&load=package.full&lang=ru_RU')
    .then(maps => {

        let center;
        let imageSize;
        if(window.innerWidth < 1000){
            center = [48.450884, 135.097821];
            imageSize =[104,104];
        }
        else {
            center = [48.450484, 135.095621];
            imageSize =  [187,187];
        }
        const map = new maps.Map(mapContainer, {
            center: center,
            zoom: 17
        });
        $(window).on('resize', ()=>{
            map.container.fitToViewport();
        })
        const mark = new maps.Placemark([48.450584, 135.098121],
            {
                hintContent:'г. Хабаровск, ул. Павла Леонтьевича Морозова, 138'
            },
            {
                preset:'islands#circleIcon',
                iconColor:'#2B2B2B',
                iconLayout: 'default#image',
                // Своё изображение иконки метки.
                iconImageHref: '/images/icons/map-mark.svg',
                // Размеры метки.
                iconImageSize: imageSize
            });
        map.geoObjects.add(mark);
        map.events.add('boundschange',function(e){
            setTimeout(() => {
                if (!("ontouchstart" in document.documentElement)){
                    $('body').mCustomScrollbar('disable');
                }
            },0)
        });
        map.events.add('actionbegin',function(e){
            setTimeout(() => {
                if (!("ontouchstart" in document.documentElement)){
                    $('body').mCustomScrollbar('disable');
                }
            },0)
        });
        // map.events.add('mouseleave',function(){
        //   if (!("ontouchstart" in document.documentElement)){
        //     $('body').mCustomScrollbar('update');
        //   }
        // });
    })
    .catch(error => console.log('Failed to load Yandex Maps', error));
