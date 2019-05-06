
function validate() {

    let pass1 = document.getElementsByName("pass1")[0];
    let pass2 = document.getElementsByName("pass2")[0];

    if (!password_is_valid(pass1.value) || !password_is_valid(pass2.value)) {
        document.getElementById("error").innerText = "Invalid password (needs to be 5 characters or more)";
        return false;
    }

    if (pass1.value !== pass2.value) {
        document.getElementById("error").innerText = "Make sure you typed the new password twice.";
        return false;
    }

    return true;
}

function password_is_valid(value) {
    return /(\S){5,}/.test(value) && value.length !== 0;
}

window.onload = function() {

    let password = document.querySelectorAll("#password");
    let error = document.getElementById("error");

    for (let i = 0; i < password.length; i++) {

        let pass = password[i];

        pass.addEventListener('blur', function () {
            if (!password_is_valid(pass.value))
                error.innerText = "Invalid password (needs to be 5 characters or more)";
            else
                error.innerText = "";
        });
    }
};
