import _ from 'lodash';
window._ = _;

// import 'bootstrap';
import * as bootstrap from "bootstrap";
window.bootstrap = bootstrap;

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Alpine from "alpinejs";
window.Alpine = Alpine;
Alpine.start();

import Mark from 'mark.js';
window.Mark = Mark;
