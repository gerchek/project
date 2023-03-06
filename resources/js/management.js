import '../css/leaders.scss';
import './main';
import './cursor';
import './scroll';
import 'slick-carousel/slick/slick';
import './animateArrows';
import './special';
import Vivus from 'vivus';


import { Select2 } from 'select2';

const Masonry = require('masonry-layout');
import axios from 'axios';
const urlParams = new URLSearchParams(window.location.search);
let group = urlParams.get('group') || 0;
let data = [];
let page = urlParams.get('page') || 1;
const refresh = () => {
    let html = '';
    fetchData()
        .then((result) => {
            data = result.data;
            const management = data.data;
            // const team = data;
            if($('.leaders__items').length){
                $('.leaders__items').remove();
                $('.leaders__pagination').remove();
            }
            html = '<div class="leaders__items">';
            management.forEach((leader,index) => {
                html += `<div class="leaders__item mix ${leader.filter_name}" data-leader="${index}">`;
                html += `<img class="leaders__img" src="${leader.photo}">`;
                html += `<h2 class="leaders__title">${leader.name}</h2>`;
                html += `<span class="leaders__type">${leader.post}</span>`;
                html += `${leader.short_text}`;
                html += `</div>`;
            })
            html += '</div>';

            $('.leaders__inner').append(html);
            if(window.innerWidth>800){
                // $('.leaders__item:visible:nth-child(2)').addClass('mix__second');
                // const mix = document.querySelector('.leaders__items');
                // const msnry = new Masonry(mix,{
                //   itemSelector:'.leaders__item',
                //   columnWidth:550,
                //   gutter:20,
                //   horizontalOrder:true
                // });
                // function masonryGrid(){
                //   msnry.reloadItems();
                //   msnry.layout();
                // }
                // masonryGrid();
            }


            $('.leaders__item').on('click', function(e)  {
                const index = parseInt($(this).attr('data-leader'));
                const leader = data.data[index];
                e.stopPropagation();
                $('.modal').removeClass('modal_opened');
                $('.burger__menu-wrapper').removeClass('burger__menu-wrapper_opened');
                $('.leader__img').attr("src", leader.photo);
                $('.leader__title').html(leader.name);
                $('.leader__type').html(leader.post);
                $('.leader__desc').html(leader.full_text);
                $('#leader-info').toggleClass('modal_opened');
                if (!("ontouchstart" in document.documentElement)){
                    $('body').mCustomScrollbar('disable');
                }
                $('body').mCustomScrollbar('disable');
            });
            html = '<div class="leaders__pagination pagination">';
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
            $('.leaders__inner').append(html);
            $('.pagination a').on('click', function(e){
                e.preventDefault();
                page = $(this).attr('href').split('page=')[1];
                fetchData()
                    .then((result) => {
                        data = result.data;
                        refresh();
                    });
            })
        });
}

function fetchData() {
    // Заголовок "Accept" с запросом json данных необходим для того, чтобы не возвращалась 422 ошибка
    const configHeaders = {
        "Accept": "application/json"
    };

  let url = `/api/employees?type=management&group=${group}&page=${page}`;
  return axios
      .get(url, {
        headers: configHeaders
      })
      .catch(error => {
        console.error(error);
      });
}

$(window).on('load', () => {
    fetchData()
        .then((result) => {
            data = result.data;
            refresh();
        });
})

$('.leaders__control').on('click', function() {
    group = $(this).data('group');
    page=1;
    var queryParams = new URLSearchParams(window.location.search);

    // Set new or modify existing parameter value.
    queryParams.set("group", group);
    window.location.search = queryParams.toString();

    fetchData()
        .then((result) => {
            data = result.data;
            refresh();

        });
})
// $('.pagination a').on('click', function(e){
//     page = $(this).attr('href').split('page=')[1];
//     fetchData()
//         .then((result) => {
//             data = result.data;
//             refresh();
//         });})
// $('#leader-info').on('mouseenter', () => {
//     $('body').mCustomScrollbar('disable');
// }).on('mouseleave',() => {
//     $('body').mCustomScrollbar('update');
// })

if (!("ontouchstart" in document.documentElement)){
    $('#leader-info').on('mouseenter', () => {
        $('body').mCustomScrollbar('disable');
    }).on('mouseleave',() => {
        $('body').mCustomScrollbar('update');
    })
}

$('#groups').select2({
    width:'resolve',
    minimumResultsForSearch:Infinity
});
$('#groups').on('select2:opening', () => {
    $('.leaders__arrow').addClass('rotate');
}).on('select2:closing', () => {
    $('.leaders__arrow').removeClass('rotate');
}).on('select2:select', function(e) {
    group = e.params.data.id;
    page = 1;
    fetchData()
        .then((result) => {
            data = result.data;
            refresh();
        });
});

let arrows = $('.arrow__circle_no-pointer');
arrows.each((index,el) => {
    arrows[index] = new Vivus(el,{
        duration:200,
        file:`/images/icons/circle.svg`,
        type:"oneByOne",
        start:"manual"
    })
    $(arrows[index].parentEl.parentElement.parentElement).on('mouseover', () => {
        arrows[index].play(3);
    })
    $(arrows[index].parentEl.parentElement.parentElement).on('mouseleave', () => {
        arrows[index].play(-3);
    })
})
