/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)

// Core variables and mixins
import "../css/_variables.scss";
import "../css/_mixins.scss";

// Main scss
import '../css/app.scss';

// Components
import '../css/_medals.scss';
import '../css/_buttons.scss';
import '../css/_navbar.scss';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

//console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
