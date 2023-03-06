import '../css/vacancy.scss';
import './main';
import './cursor';
import './scroll';
import 'slick-carousel/slick/slick';
import './animateArrows';
import './special';

let data = [];
const refresh = () => {
  let html = '';
  // const page = exampleRes.data;
  fetchData()
      .then((result) => {
        data = result.data;
        const page = data.data;

        if($('.vacancies__items').length){
          $('.vacancies__items').remove();
        }
        html = '<div class="vacancies__items">';
        page.forEach((vacancy,index) => {
          html += `<div class="vacancies__item" data-vacancy="${index}">`;
          html += `<div class="vacancies__head">`;
          html += `<h2 class="vacancies__title">${vacancy.post}</h2>`;
          html += `<img class="vacancies__arrow mCS_img_loaded" src="/images/icons/arrow.svg" alt="">`;
          html += `</div>`;
          html += `<div class="vacancies__desc">${vacancy.short_text}</div>`;
          html += `<img class="vacancies__arrow mCS_img_loaded" src="/images/icons/arrow.svg" alt=""></div>`;
        })
        html += '</div>';

        $('.vacancies__inner').append(html);

        $('.vacancies__item').on('click', function(e) {
          e.stopPropagation();
          const index = parseInt($(this).attr('data-vacancy'));
          console.log(data);
          console.log(page);
          const vacancy = data.data[index];
          $('.vacancy__title').html(vacancy.post);
          $('.vacancy__collapsible').html(vacancy.full_text);

          $('.modal').removeClass('modal_opened');
          $('.burger__menu-wrapper').removeClass('burger__menu-wrapper_opened');
          $('#vacancy-info').toggleClass('modal_opened');
          if (!("ontouchstart" in document.documentElement)){
              $('body').mCustomScrollbar('disable');
          }
        });
        if (!("ontouchstart" in document.documentElement)){
          $('#vacancy-info').on('mouseenter', () => {
              $('body').mCustomScrollbar('disable');
          }).on('mouseleave',() => {
              $('body').mCustomScrollbar('update');
          })
        }
      });
}

$(window).on('load', () => {
  refresh();
})
function fetchData() {
  // Заголовок "Accept" с запросом json данных необходим для того, чтобы не возвращалась 422 ошибка
  const configHeaders = {
    "Accept": "application/json"
  };

  let url = `/api/vacancy/`;
  return axios
      .get(url, {
        headers: configHeaders
      })
      .catch(error => {
        console.error(error);
      });
}
