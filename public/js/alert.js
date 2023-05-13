window.addEventListener('checkPoints', checkPoints);
window.addEventListener('show-alert', showAlert);
window.addEventListener('confirm-alert', showConfirm);

function checkPoints($event) {
    if (!$event.detail.is_all) {
        if ($event.detail.points < $event.detail.value) {
            document.getElementById($event.detail.id).value = $event.detail.points;
        } else if ($event.detail.value < 0) {
            document.getElementById($event.detail.id).value = 0;
        }
    } else {
        if ($event.detail.points < $event.detail.value) {
            document.getElementById($event.detail.id).value = $event.detail.points;
        } else if ($event.detail.value < 0) {
            document.getElementById($event.detail.id).value = 0;
        } else if ($event.detail.points > $event.detail.value) {
            document.getElementById($event.detail.id).value = 0;
        }
    }
}
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
    }).then((willDelete) => {
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
