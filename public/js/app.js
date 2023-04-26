
'use strict';

/* ===== Enable Bootstrap Popover (on element  ====== */

var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="popover"]'))
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl)
})

/* ==== Enable Bootstrap Alert ====== */
/* var alertList = document.querySelectorAll('.alert')
alertList.forEach(function (alert) {
  new bootstrap.Alert(alert)
});
 */

/* ===== Responsive Sidepanel ====== */
const sidePanelToggler = document.getElementById('sidepanel-toggler');
const sidePanel = document.getElementById('app-sidepanel');
const sidePanelDrop = document.getElementById('sidepanel-drop');
const sidePanelClose = document.getElementById('sidepanel-close');

window.addEventListener('load', function () {
    responsiveSidePanel();
});

window.addEventListener('resize', function () {
    responsiveSidePanel();
});


function responsiveSidePanel() {
    let w = window.innerWidth;
    if (w >= 1200) {
        // if larger
        //console.log('larger');
        sidePanel.classList.remove('sidepanel-hidden');
        sidePanel.classList.add('sidepanel-visible');

    } else {
        // if smaller
        //console.log('smaller');
        sidePanel.classList.remove('sidepanel-visible');
        sidePanel.classList.add('sidepanel-hidden');
    }
};

sidePanelToggler.addEventListener('click', () => {
    if (sidePanel.classList.contains('sidepanel-visible')) {
        console.log('visible');
        sidePanel.classList.remove('sidepanel-visible');
        sidePanel.classList.add('sidepanel-hidden');

    } else {
        console.log('hidden');
        sidePanel.classList.remove('sidepanel-hidden');
        sidePanel.classList.add('sidepanel-visible');
    }
});



sidePanelClose.addEventListener('click', (e) => {
    e.preventDefault();
    sidePanelToggler.click();
});

sidePanelDrop.addEventListener('click', (e) => {
    sidePanelToggler.click();
});

/* ====== Mobile search ======= */
const searchMobileTrigger = document.querySelector('.search-mobile-trigger');
const searchBox = document.querySelector('.app-search-box');

searchMobileTrigger.addEventListener('click', () => {

    searchBox.classList.toggle('is-visible');

    let searchMobileTriggerIcon = document.querySelector('.search-mobile-trigger-icon');

    if (searchMobileTriggerIcon.classList.contains('fa-search')) {
        searchMobileTriggerIcon.classList.remove('fa-search');
        searchMobileTriggerIcon.classList.add('fa-times');
    } else {
        searchMobileTriggerIcon.classList.remove('fa-times');
        searchMobileTriggerIcon.classList.add('fa-search');
    }
});

// Inside your JavaScript code
window.Livewire.on('alert', function (message) {
    alert(message);
});


window.addEventListener('show-alert', showAlert);
window.addEventListener('confirm-alert', showConfirm);
function showAlert(event) {
    swal(event.detail.title, event.detail.message, event.detail.confirm_message , event.detail.type, { timer: 1000, button: false });
}
function showConfirm(event) {
    swal({
        title: event.detail.title,
        text: event.detail.message,
        icon: event.detail.type,
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                swal("Success", event.detail.confirm_message , "success", { timer: 1000, button: false });
                Livewire.emit('alert-sent', event.detail.data);
            }
        });
}
window.addEventListener('remove-modal', event => {
    $(event.detail.modalName).modal('hide');
});

window.Livewire.on('toggleEye', () => {
    const icon = document.getElementById('eye-icon');
    const password = document.getElementById('password');
    icon.classList.toggle('hide');
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
  });
