/**
 * Created by Artem on 13.07.2017.
 */

if (window.location.pathname == '/api-app') {

    var ClientTokenApi = new window.tokenApi(window.API_TOKEN, window.API_URL);
    ClientTokenApi.TokenList(PrintTokenList);

    $(document).ready(function () {
        window.preloading('div#content');
    });
}

function PrintTokenList(data) {
    var items = [];
    var table = '<table id="tokenlist" class=table>' +
        '<thead>' +
        '<tr>' +
        '<th>#</th>' +
        '<th>Токен</th>' +
        '<th>Область действия</th>' +
        '<th>Доступ разрешен с API</th>' +
        '<th>Тип токена</th>' +
        '<th>Дата создания</th>' +
        '<th>Дата изменения</th>' +
        '</thead>' +
        '<tbody>' +
        '</tbody>' +
        '</table>';


    $.each(data.data, function (key, val) {
        var string = '<tr>';
        string += "<th>" + 1 + "</th>";
        $.each(val, function (key, val) {
            string += "<th>" + val + "</th>";
        });
        string += '</tr>';
        items.push(string);
    });
    $('div#content').html(table);
    $('#tokenlist > tbody').append(items);
}


function createToken() {
    alert('created');
}