import '../css/search.scss';
import './main';
import './cursor';
import './scroll';
import 'slick-carousel/slick/slick';
import './special';
const response = {};
const urlParams = new URLSearchParams(window.location.search);
let data = [];
let total = 0;
let page = urlParams.get('page') || 1;
let query = urlParams.get('search_query');
if(query) $('[name=search_query]').val(query);
const refresh = () => {
    let html = '';
    const results = data;
    if($('.results__items').length){
        $('.results__items').remove();
        $('.results__pagination').remove();
    }
    html = '<div class="results__items">';
    results.data.forEach((result,index) => {
        html +=`<a class="results__item" href="${result.url}">
      <h2 class="results__item-title">${result.name}</h2>
      <p class="results__item-desc">${result.text}</p>
    </a>`;
    })
    html += '</div>';

    $('.results__inner').append(html);

    html = '<div class="results__pagination pagination">';
    results.links.forEach((page,index) => {
        const activeClass = page.active? " pagination__page_active" : "";
        if(index===0){
            if(results.links.length>=4) html +=`<a href="${page.url}" class="pagination__prev-btn slick-arrow"></a>`;
            html +=`<div class="pagination__pages">`;
        }
        else if(index===results.links.length-1){
            if(results.links.length>=4) html +=`</div><a href="${page.url}" class="pagination__next-btn slick-arrow">`;
        }
        else{
            html +=`<a href="${page.url}" class="pagination__page${activeClass}">${page.label}</a>`
        }
    });
    html +='</div>';
    $('.results__inner').append(html);
    $('.pagination a').on('click', function(e){
        e.preventDefault();
        page = $(this).attr('href').split('page=')[1];
        fetchData()
            .then((result) => {
                data = result.searchResults;
                refresh();
            });
    });
    $('.results__found').html(`Найдено ${total} результатов`);
    $('.banner__title-text').html(`Результаты поиска по запросу: ${query}`);
}

function fetchData() {
    // Заголовок "Accept" с запросом json данных необходим для того, чтобы не возвращалась 422 ошибка
    const configHeaders = {
        "Accept": "application/json"
    };

    let url = `/api/search?search_query=${query}&page=${page}`;
    return axios
        .get(url, {
            headers: configHeaders
        })
        .catch(error => {
            console.error(error);
        });
}
$('.results__search').on('submit', function(e){
    e.preventDefault();
    query = $('[name=search_query]').val();
    fetchData()
        .then((result) => {
            data = result.searchResults;
            total = result.searchResults.total;
            refresh();
        });
});


$(window).on('load', () => {
    fetchData()
        .then((result) => {
            data = result.searchResults;
            total = result.searchResults.total;
            refresh();
        });
})
