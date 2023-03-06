/*
 * Видимость полей на странице редактирования меню
 */
document.addEventListener('DOMContentLoaded', function () {
    let select = $('.js-menu-type-select');
    if (select.length) {
        let route = $('.js-menu-route-select').parents('.form-group');
        let url = $('.js-menu-url').parents('.form-group');
        let simplePage = $('.js-menu-simple-page-select').parents('.form-group');
        let newsItemPage = $('.js-menu-news-item-select').parents('.form-group');
        let sportSchoolPage = $('.js-menu-sport-school-select').parents('.form-group');

        function typeCheck() {
            let val = select.val();

            route.hide();
            url.hide();
            simplePage.hide();
            newsItemPage.hide();
            sportSchoolPage.hide();

            if (val === 'default') {
                route.show();
            } else if (val === 'custom_url') {
                url.show();
            } else {
                if (val === 'simple_page') simplePage.show();
                if (val === 'news_item_page') newsItemPage.show();
                if (val === 'sport_school_page') sportSchoolPage.show();
            }

        }

        select.on('change', function () {
            typeCheck();
        });

        typeCheck();
    }
})

/*
 * Копирование в буфер обмена из .copy-me
 */
document.addEventListener('DOMContentLoaded', function () {
    let selectText = function(element) {
        let range;
        if (document.selection) {
            // IE
            range = document.body.createTextRange();
            range.moveToElementText(element);
            range.select();
        } else if (window.getSelection) {
            range = document.createRange();
            range.selectNode(element);
            window.getSelection().removeAllRanges();
            window.getSelection().addRange(range);
        }
    };
    let copyThisToClipboard = function(event) {
        try {
            selectText(event.currentTarget);
            if (document.execCommand('copy')) {
                Admin.Messages.success('Текст скопирован в буфер обмена')
                if (window.getSelection) {
                    window.getSelection().removeAllRanges();
                }
            } else {
                Admin.Messages.error('Ошибка, не удается получить доступ к вашему буферу обмена :(');
            }
        } catch (err) {
            Admin.Messages.error('Извините, ваш браузер не поддерживает копирование в буфер обмена :(');
            console.log(err)
        }
    };
    //$('.copy-me').click(copyThisToClipboard);
    $('body').on('click', '.copy-me', copyThisToClipboard);
});