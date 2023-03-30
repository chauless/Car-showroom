// make consts to the login form
const loginForm = document.getElementById("form");
const email = document.getElementById("email");
const password = document.getElementById("password");

// set novalidate parametr to true
loginForm.setAttribute('novalidate', true);

// add event listener to the email input
email.addEventListener("input", function () {
    // check if the email is valid
    if (email.validity.valid) {
        email.classList.remove("invalid");
        email.classList.add("valid");
        email.nextElementSibling.classList.remove("show");
    } else {
        email.classList.remove("valid");
        email.classList.add("invalid");
        email.nextElementSibling.classList.add("show");
    }
})

// add event listener to the password input
password.addEventListener("input", function () {
    // check if the password is valid
    if (password.validity.valid) {
        password.classList.remove("invalid");
        password.classList.add("valid");
        password.nextElementSibling.classList.remove("show");
    } else {
        password.classList.remove("valid");
        password.classList.add("invalid");
        password.nextElementSibling.classList.add("show");
    }
})

// add event listener to the form on submit
loginForm.addEventListener("submit", (e) => {
    // if email or password is not valid, prevent the form from submitting
    if (!email.validity.valid) {
        email.nextElementSibling.classList.add("show");
        email.classList.add("invalid");
        e.preventDefault();
    }
    if (!password.validity.valid) {
        password.nextElementSibling.classList.add("show");
        password.classList.add("invalid");
        e.preventDefault();
    }
});