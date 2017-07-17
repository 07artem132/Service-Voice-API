/**
 * Created by Artem on 13.07.2017.
 */

window.preloading = function preloading($idElement) {
    $html = '<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>';
    $($idElement).html($html);
};
