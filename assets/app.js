/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';


// listen to the collapse button

const element = document.getElementById("navbarSupportedContent-4");
const btn = document.getElementById('displayBtn');
let state = false;

btn.addEventListener('click', function() {
    state = !state;
    if (state) {
        element.classList.remove('text-center', 'bg-secondary');
        element.classList.add('collapse');
    } else {
        element.classList.add('text-center', 'bg-secondary');
        element.classList.remove('collapse');
    }
});

