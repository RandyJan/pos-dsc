require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import 'sweetalert2/dist/sweetalert2.min.css';
window.Swal = require('sweetalert2');
