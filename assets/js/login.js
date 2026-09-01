let er = document.getElementById("emailErr")
let passer = document.getElementById("passError")
function loginCheck(e) {
    e.preventDefault();
    const email = document.getElementById("email").value;
    const pass = document.getElementById("password").value;
    console.log(pass)
    // console.log("email" + email)

    if (email === "") {
        er.innerHTML = "Email can't be empty."
    }
    else if (!email.includes("@")) {
        er.innerHTML = "Email should have @"
    }
    else if (!email.includes(".")) {
        er.innerHTML = "Email should have ."
    }
    else {
        er.innerHTML = ""
    }

    if (pass === "") {
        passer.innerHTML = "Password can't be empty."
    }
    else if (pass.length < 6) {
        passer.innerHTML = "Password length at least 6"

    }
    else {
        passer.innerHTML = ""
    }
}