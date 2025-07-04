import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;


Alpine.start();

function openModal(data) {
    const alpineRoot = document.querySelector('[x-data]');
    alpineRoot.__x.$data.formData = JSON.parse(JSON.stringify(data));
    alpineRoot.__x.$data.showModal = true;
}