

window.onload = function() {


    let validate_username = document.getElementById("checkUsername");

    validate_username.addEventListener("click", function() {

        let username = document.getElementById("_username");
        let query = "http://localhost:8080/api/getUserInfo.php?username=" + username.value;
        let error = document.getElementById("error");

        let xhr = new XMLHttpRequest();


        xhr.open('GET', query);
        xhr.responseType = 'json';

        xhr.send();

        xhr.onload = function() {
            if (xhr.status !== 200)
                console.log("This is not supposed to happen...");
            else {

                if (xhr.response["error"]) {
                    error.innerHTML = xhr.response["error"];
                } else {
                    Cookies.set('user', xhr.response["user"]);
                    error.innerHTML = "";
                    document.location.href = "http://localhost:8080/forgot-password.html";
                }
            }
        };
    });

};