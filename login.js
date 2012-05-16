var initLogin = function () {
    "use strict";
    var login, connect, loginBtn;
    login = function (assertion) {
        if (assertion) {
            document.location = "{{tpl:BlogURL}}browserid/assertion/" + assertion;
        }
    };
    connect = function () {
        navigator.id.get(login);
    };
    loginBtn = document.getElementById("login");
    if (loginBtn.addEventListener) {
        loginBtn.addEventListener("click", connect, false);
    } else if (loginBtn.attachEvent) {
        loginBtn.attachEvent("onclick", connect);
    }
};
if (window.addEventListener) {
    window.addEventListener("load", initLogin, false);
} else if (window.attachEvent) {
    window.attachEvent("onload", initLogin);
}
