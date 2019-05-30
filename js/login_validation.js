
function validate() {

    let pass1 = document.getElementById("inputPasswordOne");
    let pass2 = document.getElementById("inputPasswordTwo");

    if (pass1.value !== "" && pass2.value !== "") {

        if (!password_is_valid(pass1.value)) {
            document.getElementById("error").innerText = "Invalid password (needs to be 5 characters or more)";
            document.getElementById('submit').disabled = true;
            return false;
        }

        if (pass1.value !== pass2.value) {
            document.getElementById("error").innerText = "Passwords do not match";
            document.getElementById('submit').disabled = true;
            return false;
        }

        document.getElementById('error').innerText = "";
        document.getElementById('submit').disabled = false;
        return true;
    }

    return false;
}

function password_is_valid(value) {
    return /(\S){5,}/.test(value) && value.length !== 0;
}

function lock_form(toLock) {

    for (let i = 0; i < toLock.length; i++)
        toLock[i].disabled = true;
}


function unlock_form(toLock) {

    for (let i = 0; i < toLock.length; i++)
        toLock[i].disabled = false;
}

window.onload = function() {

    let password = [document.getElementById("inputPasswordOne"), document.getElementById("inputPasswordTwo")];
    let form = new Array();
    let error = document.getElementById("error");
    let question = document.getElementById('question');
    let answer = document.getElementById("inputAnswer");
    let user = JSON.parse(Cookies.get('user'));

    form.push(password[0]);
    form.push(password[1]);
    form.push(document.getElementById('submit'));

    console.log(user);
    lock_form(form);

    if (user) {

        question.innerText = user["user_auth_question"];


        for (let i = 0; i < password.length; i++) {

            let pass = password[i];

            pass.addEventListener('keyup', function () {
                validate();
            });
        }

        answer.addEventListener("keyup", function() {

            if (answer.value !== "") {

                let xhr = new XMLHttpRequest();
                let query = "http://localhost:8080/api/testAuthQuestion.php?username=" + user["username"] + "&answer=" + answer.value;


                xhr.open('GET', query);
                xhr.responseType = 'json';
                xhr.send();

                xhr.onload = function () {

                    console.log(xhr.response);

                    if (xhr.status !== 200)
                        console.log("This is not supposed to happen...");
                    else {
                        if (xhr.response["error"]) {
                            document.location.href = "http://localhost:8080/login.html";
                        } else if (xhr.response["status"] !== "completed") {
                            error.innerText = "Invalid answer";
                            lock_form(form);
                        } else {
                            document.getElementById('inputAnswer').disabled = true;
                            error.innerText = "";
                            unlock_form(password);
                            Cookies.remove('user');
                        }
                    }
                };
            }

        });

    } else {

        document.location.href = "http://localhost:8080/login.html";
    }
};
