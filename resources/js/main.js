import axios from 'axios';
import 'jquery-mask-plugin';
import AWN from "awesome-notifications"
// Initialize instance of AWN
let notifier = new AWN()

// Call one of available functions

$('[placeholder*=Телефон]').mask('+7 000 000 00 00');

$('.contact-form').on('submit', function(e) {
    e.preventDefault();
    var formData = $(this).serializeArray().reduce(function(obj, item) {
        obj[item.name] = item.value;
        return obj;
    }, {});
    //formData["recaptcha_response"] = window.RECAPTCHA_KEY;

    let url = $(this).attr('action');
    return axios
        .post(url, formData)
        .then(function(res) {
            if(res.data.status=='ok'){
                notifier.success('Спасибо, ваше сообщение успешно отправлено!')
            }
            else{
                notifier.alert('Что-то пошло не так :( Попробуйте позже...')
            }
        })
        .catch(error => {
            notifier.alert('Что-то пошло не так :( Попробуйте позже...')

            console.error(error);
        });
})
let $list = $('.nav__menu-item');
$list.each((index, el) => {
    let $clone = $(el).clone(true);
    $clone
        .removeClass('nav__menu-item')
        .addClass('burger__menu-item')
    $clone
        .children('a')
        .addClass('burger__menu-link')
        .removeClass('nav__menu-link');
    $('.burger__menu').append($clone);
    $('.burger__menu-item .nav__submenu').each((index, el) => {
        $(el)
            .removeClass('nav__submenu')
            .addClass('burger__menu-dropdown');
    })
    $('.burger__menu-link+ul').prev().removeAttr('href');
});
// Контакты
let $contacts= $('.top-line__contacts');
$contacts = $contacts.clone(true);
$contacts= $contacts.removeClass().addClass('burger__contacts');
$('.burger__content').append($contacts);
// Глаз
let $eye = $('.top-line__eye');
$eye = $eye.clone(true);
$eye = $eye.removeClass().addClass('burger__eye');
$('.burger__features').append($eye);
// Поиск
let $search = $('.top-line__search');
$search = $search.clone(true);
$search = $search.removeClass().addClass('burger__search');
$('.burger__features').append($search);
$('.top-line__search-btn').on('click', function(){
    $(this).closest('form').trigger('submit');
});
// Бургер
$('.top-line__burger').on('click', (e) => {
    e.stopPropagation();
    $('.modal').removeClass('modal_opened');
    $('.burger__menu-wrapper').toggleClass('burger__menu-wrapper_opened');
});
$('.burger__closeBtn').on('click', (e) => {
    e.stopPropagation();
    $('.burger__menu-wrapper').toggleClass('burger__menu-wrapper_opened');
})
// Форма в футере
$('.footer__contactBtn, .contact__btn, .banner__contactBtn').on('click', (e) => {
    e.stopPropagation();
    $('.modal').removeClass('modal_opened');
    $('#form-modal').toggleClass('modal_opened');
});
$('.form__closeBtn').on('click', (e) => {
    e.stopPropagation();
    $('.modal').removeClass('modal_opened');
    if (!("ontouchstart" in document.documentElement)){
        $('body').mCustomScrollbar('update');
    }
})

// Закрытие по клику вне формы/меню в бургере
$(document).on('click', (e) => {
    let $target = $(e.target);
    if(!$target.closest('.burger__menu-wrapper_opened').length)
        $('.burger__menu-wrapper').removeClass('burger__menu-wrapper_opened');
    if(!$target.closest('.modal_opened').length){
        $('.modal').removeClass('modal_opened');
        if (!("ontouchstart" in document.documentElement)){
            $('body').mCustomScrollbar('update');
        }  }
});
$('.modal').on('mouseenter', () => {
    if (!("ontouchstart" in document.documentElement)){
        $('body').mCustomScrollbar('disable');
    }
}).on('mouseleave',() => {
    if (!("ontouchstart" in document.documentElement)){
        $('body').mCustomScrollbar('update');
    }
})
$('.accordion-header').children().hide();
$(".accordion-header").on('click', function (e) {
    e.stopPropagation();
    if($(this).is('ul')){
        if(e.target==this){
            $(this).children().slideToggle(400);
            $(this).toggleClass('accordion-header_active');
        }
    }
    else{
        $(this).next().slideToggle(400);
        $(this).toggleClass('accordion-header_active');
    }
})
