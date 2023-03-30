// find the file input element
const fileInput = document.getElementById('photo');

// add event listener for the file input to change
fileInput.addEventListener('change', (e) => {
    const file = e.target.files[0];

    // check if the file is an image
    if (file.type !== 'image/jpeg' && file.type !== 'image/png' && file.type !== 'image/webp') {
        // if not an image, alert the user and delete uploaded file
        alert('File is not an image.');
        photo.classList.add('invalid');
        photo.classList.remove('valid');
        photo.nextElementSibling.classList.add('show');
        fileInput.value = '';
        e.preventDefault();
    } else {
        photo.classList.add('valid');
        photo.classList.remove('invalid');
        photo.nextElementSibling.classList.remove('show');
    }
});


