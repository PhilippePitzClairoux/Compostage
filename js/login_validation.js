
function validate() {

    let pass1 = document.getElementById("inputPasswordOne");
    let pass2 = document.getElementById("inputPasswordTwo");


    if ((!password_is_valid(pass1.value) || !password_is_valid(pass2.value)) || document.getElementById("error").innerText !== "") {
        console.log('invalid pass');
        document.getElementById("error").innerText = "Invalid password (needs to be 5 characters or more)";
        return false;
    }

    if (pass1.value !== pass2.value) {
        console.log('dont match');
        document.getElementById("error").innerText = "Make sure you typed the new password twice.";
        return false;
    }

    return true;
}

function password_is_valid(value) {
    return /(\S){5,}/.test(value) && value.length !== 0;
}

function lock_form(toLock) {

    for (let i = 0; i < toLock.length; i++)
        toLock[i].style.disabled = true;
}


function unlock_form(toLock) {

    for (let i = 0; i < toLock.length; i++)
        toLock[i].style.disabled = false;
}

window.onload = function() {

    let password = [document.getElementById("inputPasswordOne"), document.getElementById("inputPasswordTwo")];
    let form = document.getElementById("form_xd");
    let error = document.getElementById("error");
    let question = document.getElementById('question');
    let answer = document.getElementById("inputAnswer");
    let user = Cookies.get('user');

    if (user) {

        console.log(user);
        console.log(password);

        question.innerText = Cookies.get('user')["user_auth_question"];


        for (let i = 0; i < password.length; i++) {

            let pass = password[i];

            pass.addEventListener('blur', function () {
                if (!password_is_valid(pass.value)) {
                    error.innerText = "Invalid password (needs to be 5 characters or more)";
                    return false;
                } else {
                    error.innerText = "";
                    return true;
                }
            });
        }

        answer.addEventListener("keyup", function() {

            let xhr = new XMLHttpRequest();
            let query = "http://localhost:8080/api/testAuthQuestion.php?username=" + user["username"] + "&answer=" + answer.value;

            console.log(query);

            xhr.open('GET', query);
            xhr.responseType = 'json';

            xhr.send();

            xhr.onload = function() {
                if (xhr.status !== 200)
                    console.log("This is not supposed to happen...");
                else {

                    if (xhr.response["error"]) {
                        document.location.href = "http://localhost:8080/login.html";
                    } else if (xhr.response["status"] !== "completed") {
                        error.innerText = "Invalid answer";
                    } else {

                    }

                }
            };

        });

    } else {

        document.location.href = "http://localhost:8080/login.html";
    }
};
