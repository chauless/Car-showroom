// get switch theme button
let switchTheme = document.getElementById('switch-theme');

// add event listener on click to switch theme
switchTheme.addEventListener('click', function() {
    document.body.classList.toggle('dark-theme');
    let theme = 'light';
    if (document.body.classList.contains('dark-theme')) {
        theme = 'dark';
    }
    
    // add theme to cookie
    document.cookie = 'theme=' + theme;
});




