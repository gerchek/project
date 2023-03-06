import '../css/events.scss';
import './main';
import './cursor';
import './scroll';
import './animateArrows';
import './special';

import { Datepicker, DateRangePicker } from 'vanillajs-datepicker';
import ru from 'vanillajs-datepicker/locales/ru';

Object.assign(Datepicker.locales,ru);
const datepickerElement = document.querySelector('.filter__input');
const datepicker = new Datepicker(datepickerElement,{
  clearBtn:true,
  format:'dd.mm.yyyy',
  language:'ru',
  dateDelimiter:'-',
  maxNumberOfDates:2,
  orientation: 'bottom',
  container:'.datepicker-wrapper',
});
let currentDate = 'Фильтр по дате';
const btn = document.querySelector('.events__filter>.btn');

// Dynamic Content

import axios from 'axios';
const urlParams = new URLSearchParams(window.location.search);
let group = urlParams.get('group');
let dates = urlParams.get('date_period[]');
let data = [];

const refresh = () => {
  let html = '';
  const page = data.data;
  html+=`<ul class="events__list">`;
  data.data.forEach((event) => {
    // let type;
    // switch(event.type){
    //   case 'Мероприятия':{type='event'; break;}
    //   case 'Статьи':{type='article'; break;}
    //   case 'Новости':{type='news'; break;}
    // }
    html+=`<li class="events__item card popup3d">`;
    html+=`<a class="events__item-link item-link" href="${event.link}">`;
    html+=`<span></span></a>`;
    html+=`<div class="events__img-wrapper">`;
    html+=`<a class="events__item-tag type_${event.type}" href="${event.tagLink}">${event.tag}</a>`;
    html+=`<img class="events__item-img" src="${event.img}" alt="${event.title}">`;
    html+=`</div><div class="events__date">${event.date}</div>`;
    html+=`<div class="events__desc">${event.title}</div></li>`
  });
  html+=`</ul>`;
  if($('.events__list').length){
    $('.events__list').remove();
    $('.events__pagination').remove();
  }
  $('.events__inner').append(html);
  html = '<div class="events__pagination pagination">';
  data.links.forEach((page,index) => {
    const activeClass = page.active? " pagination__page_active" : "";
    if(index===0){
      html +=`<a href="${page.url}" class="pagination__prev-btn slick-arrow"></a>`
      html +=`<div class="pagination__pages">`;
    }
    else if(index===data.links.length-1){
      html +=`</div><a href="${page.url}" class="pagination__next-btn slick-arrow">`;
    }
    else{
      html +=`<a href="${page.url}" class="pagination__page${activeClass}">${page.label}</a>`
    }
  });
  html +='</div>';
  $('.events__inner').append(html);
}

group = '0';
fetchData()
    .then((result) => {
      data = result.data;
      refresh();
    });

function fetchData() {
  // Заголовок "Accept" с запросом json данных необходим для того, чтобы не возвращалась 422 ошибка
  const configHeaders = {
    "Accept": "application/json"
  };

  let url = `/api/events/filter?group=${group}`;
  if(dates!=null){
    if(dates.length==1) url += `&date=${dates[0]}`;
    else{
      dates.forEach((date) => url +=`&date_period[]=${date}`)
    }
  }

  return axios
      .get(url, {
        headers: configHeaders
      })
      .catch(error => {
        console.error(error);
      });
}

datepickerElement.addEventListener('changeDate', (data) => {
  let date = '';
  const DatepickerDates = data.detail.date.sort((a,b) => a - b);
  DatepickerDates.forEach((value) => {
    date+= Datepicker.formatDate(value,'dd.mm.yyyy','ru')+'-';
  });
  date = date.substring(0,date.length-1);
  let queryDates = [];
  DatepickerDates.forEach((value) => {
    queryDates.push(Datepicker.formatDate(value,'yyyy-mm-dd','ru'));
  });
  dates = queryDates;
  if(date==='') {
    queryDates=[];
    fetchData()
        .then((result) => {
          data = result.data;
          refresh();
        });
    return btn.textContent='Выберите дату';}
  btn.textContent = date;

  fetchData()
    .then((result) => {
      data = result.data;
      refresh();
    });
})

// Фильтр по группе
$('.events__control').on('click', function() {
  group = $(this).data('group');
  fetchData()
      .then((result) => {
        data = result.data;
        refresh();
      });
})

// Dynamic content End

datepickerElement.addEventListener('hide', (data) => {
  if(btn.textContent=='Выберите дату') btn.textContent = 'Фильтр по дате';
})
$(btn).on('mousedown', function(e) {
  e.stopPropagation();
  currentDate = btn.textContent;
  if(!datepicker.active){
    if(currentDate=='Фильтр по дате'){
      btn.textContent = 'Выберите дату';
    }
    datepicker.show();
  }
  else datepicker.hide();
})
$('.events__global-filter').on('click', function(e) {
  $('.events__head').slideToggle(200);
})