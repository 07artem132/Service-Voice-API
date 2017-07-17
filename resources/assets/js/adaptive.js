/**
 * Created by Artem on 13.07.2017.
 */

/**
 * Адаптивность при первой загрузке страницы
 */
$(document).ready(function () {
    window.setTimeout(function () {
        if (window.innerWidth < 1600) {
            if ($('.brand').text() == 'Service-Voice')
                $('[data-toggle=offcanvas]').trigger('click');
            return;
        }
        if (window.innerWidth > 1600) {
            if ($('.brand').text() == 'S-V')
                $('[data-toggle=offcanvas]').trigger('click');
            return;
        }
    }, 20);
});

/**
 * Адаптивность при изменении размера окна браузера
 */
$(window).resize(function () {
    if (window.innerWidth < 1600) {
        if ($('.brand').text() == 'Service-Voice')
            $('[data-toggle=offcanvas]').trigger('click');
        return;
    }
    if (window.innerWidth > 1600) {
        if ($('.brand').text() == 'S-V')
            $('[data-toggle=offcanvas]').trigger('click');
        return;
    }
});