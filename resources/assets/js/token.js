/**
 * Created by Artem on 07.07.2017.
 */

window.tokenApi = class tokenApi {
    constructor(token, APIurl) {
        this.token = token;
        this.APIurl = APIurl;
    }

    TokenList(calback) {
        $.ajax
        ({
            type: "GET",
            url: this.APIurl + 'token/list',
            dataType: 'json',
            async: true,
            dataType: 'json',
            headers: {
                "X-token": this.token
            }, success: calback
        });

        return;
    }
}
