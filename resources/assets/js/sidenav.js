/**
 * Created by Artem on 13.07.2017.
 */

$(document).ready(function () {
    $('[data-toggle=offcanvas]').click(function () {
        $('.row-offcanvas').toggleClass('active');
        //$('#sidebar').toggleClass('col-xs-1');
        $('.collapse').toggleClass('in');
        if ($('.brand').text() == 'S-V') {
            $('.brand').text('Service-Voice');
            $('aside#sidenav').removeClass('col-md-1');
            $('aside#sidenav').addClass('col-md-2');
            $('aside#sidenav').css('width', '');
            $('aside#sidenav').css('min-width', '');
            //   $('header#header').css('width', '');
            //   $('footer#footer').css('width', '');
            //   $('section#content').css('width', '');
            $('i#sidebar-button').addClass('fa-chevron-left');
            $('i#sidebar-button').removeClass('fa-chevron-right');
       /*     $('section#content').addClass('col-md-10');
            $('section#content').removeClass('col-md-11');
            $('footer#footer').addClass('col-md-10');
            $('footer#footer').removeClass('col-md-11');
            $('header#header').addClass('col-md-10');
            $('header#header').removeClass('col-md-11');*/

        } else {
            $('.brand').text('S-V');
            $('aside#sidenav').removeClass('col-md-2');
            $('aside#sidenav').addClass('col-md-1');
            $('aside#sidenav').css('width', '4.3vw');
            $('aside#sidenav').css('min-width', '75.547px');
            //      $('header#header').css('width', '94.8vw');
            //      $('footer#footer').css('width', '94.8vw');
            //       $('section#content').css('width', '94.8vw');
            $('i#sidebar-button').removeClass('fa-chevron-left');
            $('i#sidebar-button').addClass('fa-chevron-right');
        /*    $('section#content').removeClass('col-md-10');
            $('section#content').addClass('col-md-11');
            $('footer#footer').removeClass('col-md-10');
            $('footer#footer').addClass('col-md-11');
            $('header#header').removeClass('col-md-10');
            $('header#header').addClass('col-md-11');*/
        }
    });
});
