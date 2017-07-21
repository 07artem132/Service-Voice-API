/**
 * Created by Artem on 07.07.2017.
 */

class Token {
    constructor(token, APIurl) {
        this.token = token;
        this.APIurl = APIurl;
    }

    TokenList() {
        var result = $.ajax
        ({
            type: "GET",
            url: this.APIurl + 'token/list',
            dataType: 'json',
            async: true,
            headers: {
                "X-token": this.token
            }, success: function (data) {
                return data;
            }
        }).responseJSON;

        return result;
    }

}
