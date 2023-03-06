import '../css/thanks.scss';
import './main';
import './cursor';
import './scroll';
import 'slick-carousel/slick/slick';
import './special';
import Vivus from 'vivus';

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
    if (!("ontouchstart" in document.documentElement)){
      $('body').mCustomScrollbar('disable');
    }
});
var graduatesItems = $('.graduates__item').length;
if(graduatesItems > 3){
    graduatesItems = 4;
}
else{
    graduatesItems = graduatesItems;
}
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
  responsive:[
    {
      breakpoint: 1100,
      settings:{
        slidesToShow:1
      }
    }
  ]
});
jQuery($('.reviews__slider').on('breakpoint',(slick) => {
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

let data = [];
const refresh = () => {
  let html = '';
  // const page = exampleRes.data;
  fetchData()
      .then((result) => {
        data = result.data;
        const page = data.data;

        $('.reviews__slider').slick('unslick');
        if($('.reviews__slider').length){
          $('.reviews__slider').remove();
          $('.reviews__arrows').remove();
        }
        html = '<div class="reviews__slider">';
        page.forEach((review,index) => {
          html+=`<div class="reviews__item" data-review="${index}">`
          html+=`<div class="reviews__item-head">`
          html+=`<h2 class="reviews__item-title">${review.name}</h2>`
          html+=`<div class="reviews__linkImg slick-arrow"></div>`
          html+=`</div>`
          html+=`<div class="reviews__desc">${review.short_text} </div>`
          html+=`</div>`;
        })
        html += '</div><div class="reviews__arrows"></div>';

        $('.reviews__inner').append(html);
        if (!("ontouchstart" in document.documentElement)){
          $('#review-info').on('mouseenter', () => {
            $('body').mCustomScrollbar('disable');
          }).on('mouseleave',() => {
            $('body').mCustomScrollbar('update');
          })
        }
        $('.reviews__slider').on('click', '.slick-current', function(e) {
          const slide = $(this).find('.reviews__item');
          const index = parseInt($(slide).attr('data-review'));
          const review = data.data[index];
          $('.review__title').html(review.name);
          $('.review__collapsible').html(review.full_text);

          e.stopPropagation();
          $('.modal').removeClass('modal_opened');
          $('.burger__menu-wrapper').removeClass('burger__menu-wrapper_opened');
          $('#review-info').toggleClass('modal_opened');
          if (!("ontouchstart" in document.documentElement)){
            $('body').mCustomScrollbar('disable');
          }
        });
        $('.reviews__slider').slick({
          focusOnSelect: true,
          slidesToShow:2,
          slidesToScroll:1,
          arrows:true,
          appendArrows:'.reviews__arrows',
          responsive:[
            {
              breakpoint: 1100,
              settings:{
                slidesToShow:1
              }
            }
          ]
        });
        jQuery($('.reviews__slider').on('breakpoint',(slick) => {
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
      });
}

$(window).on('load', () => {
    fetchData()
        .then((result) => {
            data = result.data;
            refresh();
        });
})
function fetchData() {
  // Заголовок "Accept" с запросом json данных необходим для того, чтобы не возвращалась 422 ошибка
  const configHeaders = {
    "Accept": "application/json"
  };

  let url = `/api/thanks/`;
  return axios
      .get(url, {
        headers: configHeaders
      })
      .catch(error => {
        console.error(error);
      });
}
