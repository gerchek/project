import '../css/gallery.scss';
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
const btn = document.querySelector('.gallery__filter>.btn');
datepickerElement.addEventListener('changeDate', (data) => {
  let date = '';
  const dates = data.detail.date.sort((a,b) => a - b);
  dates.forEach((value) => {
    date+= Datepicker.formatDate(value,'dd.mm.yyyy','ru')+'-';
  });
  date = date.substring(0,date.length-1);
  if(date==='') return btn.textContent='Выберите дату';
  btn.textContent = date;
})
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
// Dynamic Content

import axios from 'axios';
const urlParams = new URLSearchParams(window.location.search);
let dates = urlParams.get('date_period[]');
let data = [];
const refresh = () => {
  let html = '';
  html+=`<div class="gallery__items">`;
  data.data.forEach((event) => {
    html+=`<a class="gallery__item-link gallery__item" href="${event.link}">`;
    html+=`<div class="gallery__thumbnail">`;
    html+=`<img class="gallery__thumbnail-img" src="${event.img}" alt="${event.title}">`;
    html+=`<div class="gallery__date">${event.date}</div></div>`;
    html+=`<h2 class="gallery__title">${event.title}</h2></a>`;
  });
  html+=`</div>`;
  if($('.gallery__items').length){
    $('.gallery__items').remove();
    $('.gallery__pagination').remove();
  }
  $('.gallery__page').append(html);
  html = '<div class="gallery__pagination pagination">';
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
  $('.gallery__inner').append(html);
}

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

  let url = `/api/gallery/filter`;
  if(dates!=null){
    url+='?';
    if(dates.length==1) url += `date=${dates[0]}`;
    else{
      dates.forEach((date) => url +=`date_period[]=${date}&`)
      url.substring(0,url.length-1);
    }
  }

  // return exampleRes;
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

    return btn.textContent='Выберите дату';
  }
  btn.textContent = date;

  fetchData()
    .then((result) => {
      data = result.data;
      refresh();
    });
})

// Dynamic content End
