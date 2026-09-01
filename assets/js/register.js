const btn = document.getElementById("regBtn").addEventListener("click", (e) => {
    e.preventDefault();
    // console.log("hi")
    const fname = document.getElementById("fname").value;
    const phone = document.getElementById("phone").value;
    const remail = document.getElementById("remail").value;
    const pass = document.getElementById("pass").value;
    const re_pass = document.getElementById("re_pass").value;

    // console.log(fname, phone, remail, pass, re_pass);
    //Error
    let err = document.getElementById("err");
    let nerr = document.getElementById("nErr");
    let pherr = document.getElementById("phErr");
    let emerr = document.getElementById("emErr");
    let passerr = document.getElementById("passErr");
    if (fname === "" || phone === "" || remail === "" || pass === "" || re_pass === "") {
        err.innerHTML = "Field can not be empty";
    }
    else {
        err.innerHTML = "";
    }

    if (fname.length > 15) {
        nerr.innerHTML = "Name must be in 15 latter";
    }

    else {
        nerr.innerHTML = "";
    }


    const length6Pattern = /^.{6,}$/;
    const casePattern = /^(?=.*[a-z])(?=.*[A-Z]).+$/;

    if (!length6Pattern.test(pass)) {
        passerr.innerHTML = "Password at least 6 latter"
    }
    else if (!casePattern.test(pass)) {
        passerr.innerHTML = "Password at least have one small,capital latter"
    }

    else if (pass !== re_pass) {
        passerr.innerHTML = "Confirm password didn't match"
    }
    else {
        passerr.innerHTML = "";
    }
    if (phone.length != 11) {
        pherr.innerHTML = "Phone number must be 11 digit."
    }
    else if (phone[0] !== "0") {
        pherr.innerHTML = "Phone number must be start with 0"
    }
    else if (phone[1] !== "1") {
        pherr.innerHTML = "Phone number must be second digit 1."
    }

    else {
        pherr.innerHTML = "";
    }
})

let data = document.getElementById("ss")
let doc = document.getElementById("docS")

document.getElementById("patientp").addEventListener('click', () => {
    doc.classList.add("f");
    data.classList.add("s");
    // console.log("hi");
    data.innerHTML = `
       <label for ="dob"> DOB</label>
       <input type='date' id='dob' placeholder="DD-MM-YYYY" required>
       `
})

document.getElementById("doctorP").addEventListener('click', () => {
    data.classList.add("f");
    doc.classList.add("s");

    doc.innerHTML = `
       <label for="spec">Specialization (doctors only)</label>
          <select id="spec">
            <option>General Physician</option>
            <option>Cardiology</option>
            <option>Dermatology</option>
            <option>Pediatrics</option>
            <option>Orthopedics</option>
          </select>
       `
})
