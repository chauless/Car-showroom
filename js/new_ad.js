// make consts to the login form
const regForm = document.getElementById('form');
const comments = document.getElementById('comments');
const palivo = document.getElementById('palivo');
const karoserie = document.getElementById('karoserie');

// set novalidate parametr to true
regForm.setAttribute('novalidate', true);

// create list of all inputs (exept textarea and select)
inputs = document.querySelectorAll('input');

// validation of all inputs (exept textarea and select)
for (let i = 0; i < inputs.length; i++) {
    inputs[i].addEventListener('input', function () {
        // prevent special characters in inputs
        // onkeyup=this.value = this.value.replace(/[)&*+<=>,:;^(%'"/{}|\\]/g, '')
        // check if input is valid
        if (inputs[i].validity.valid) {
            inputs[i].classList.remove('invalid');
            inputs[i].classList.add('valid');
            inputs[i].nextElementSibling.classList.remove('show');
        } else {
            inputs[i].classList.remove('valid');
            inputs[i].classList.add('invalid');
            inputs[i].nextElementSibling.classList.add('show');
        }
    });

    // if any input is invalid, prevent form from submit
    regForm.addEventListener('submit', function (event) {
        if (!inputs[i].validity.valid) {
            inputs[i].classList.add('invalid');
            inputs[i].nextElementSibling.classList.add('show');
            event.preventDefault();
        }
    });
}

// validation of comments
comments.addEventListener('input', function () {
    // prevent special characters in inputs
    // onkeyup=this.value = this.value.replace(/[)&*+<=>@^;('/{}|]/g, '')
    // check if input is valid
    if (comments.validity.valid) {
        comments.classList.remove('invalid');
        comments.classList.add('valid');
        comments.nextElementSibling.classList.remove('show');
    } else {
        comments.classList.remove('valid');
        comments.classList.add('invalid');
        comments.nextElementSibling.classList.add('show');
    }
});

// validation of comments, type of car and type of gas on submit
regForm.addEventListener('submit', (e) => {
    // if any input is invalid, prevent form from submit
    if (!comments.validity.valid) {
        comments.nextElementSibling.classList.add('show');
        comments.classList.add('invalid');
        e.preventDefault();
    }
    if (karoserie.value == '') {
        karoserie.nextElementSibling.classList.add('show');
        karoserie.classList.add('invalid');
        e.preventDefault();
    }
    if (palivo.value == '') {
        palivo.nextElementSibling.classList.add('show');
        palivo.classList.add('invalid');
        e.preventDefault();
    }
});

// validation of type of car on input
karoserie.addEventListener('input', function () {
    // if any input is invalid, prevent form from submit
    if (karoserie.value == '') {
        karoserie.nextElementSibling.classList.add('show');
        karoserie.classList.remove('valid');
        karoserie.classList.add('invalid');
        e.preventDefault();
    } else {
        karoserie.nextElementSibling.classList.remove('show');
        karoserie.classList.remove('invalid');
        karoserie.classList.add('valid');
    }
});

// validation of type of gas on input
palivo.addEventListener('input', function () {
    // if any input is invalid, prevent form from submit
    if (palivo.value == '') {
        palivo.nextElementSibling.classList.add('show');
        palivo.classList.remove('valid');
        palivo.classList.add('invalid');
        e.preventDefault();
    } else {
        palivo.nextElementSibling.classList.remove('show');
        palivo.classList.remove('invalid');
        palivo.classList.add('valid');
    }
});