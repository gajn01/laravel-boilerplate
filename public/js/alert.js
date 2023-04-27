

// Inside your JavaScript code
window.Livewire.on('alert', function (message) {
    alert('asd');
});


window.addEventListener('show-alert', showAlert);
window.addEventListener('confirm-alert', showConfirm);
function showAlert(event) {
    swal(event.detail.title, event.detail.message, event.detail.type, { timer: 1000, button: false });
}
function showConfirm(event) {
    swal({
        title: event.detail.title,
        text: event.detail.message,
        icon: event.detail.type,
        buttons: {
            cancel: 'No',
            confirm: 'Yes',
        },
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                swal("Success", "Successfully deleted", "success", { timer: 1000, button: false });
                Livewire.emit('alert-sent', event.detail.data);
            }
        });
}
window.addEventListener('remove-modal', event => {
    $(event.detail.modalName).modal('hide');
});

window.Livewire.on('onStartAlert', function (message) {
    swal({
        title: 'Are you sure?',
        text: message,
        icon: 'warning',
        buttons: {
            cancel: 'No',
            confirm: 'Yes',
        },
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                Livewire.emit('start-alert-sent');
            }
        });
});


