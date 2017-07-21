/**
 * Created by Artem on 13.07.2017.
 */

window.preloading('div#content');
var tokenApi = new Token(API_TOKEN, API_URL);

var data = tokenApi.TokenList();

var items = [];

$.each(data.data, function (key, val) {
    var string = '<tr>';
    $.each(val, function (key, val) {
        string += "<th>" + val + "</th>";
    });
    string += '</tr>';
    items.push(string);
});

$('#tokenlist > tbody').append(items);


function createToken() {
    alert('created');
}