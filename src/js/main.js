'use strict';
/*!
* main.js
*/

window.app = {};
import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;
import _ from 'lodash';
import Promise from 'bluebird';
window.Promise = Promise;
import imagesLoaded from 'imagesLoaded';
window.imagesLoaded = imagesLoaded;
import PerfectScrollbar from './libs/perfect-scrollbar';
window.PerfectScrollbar = PerfectScrollbar;
require('./libs/slick');
require('intersection-observer');
// import closest from './libs/closest';
// import { on, off } from './libs/eventtoggle';
// require('jquery.easing');

import App from './components/App';

app = new App();
app.render();
