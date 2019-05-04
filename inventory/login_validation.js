
let password_validation = "/(.){5,}/";

function execute_regex(string, regex) {
    return regex.test(string);
}

window.onload = function() {

    let password = document.getElementById("password");
    let error = document.getElementById("error");

    password.addEventListener(onblur, function() {

        if (!execute_regex(password.innerText, password_validation))
            error.innerText = "Invalid password (needs to be 5 characters or more)";
        else
            error.innerText = "";
    });

};