// https://bootstrap-guide.com/components/modal
var inputModal = document.getElementById('inputModal')
inputModal.addEventListener('show.bs.modal', function (event) {
    // Button that triggered the modal
    var button = event.relatedTarget
    // Extract info from data-bs-* attributes
    var start = button.getAttribute('data-bs-start')
    var closing = button.getAttribute('data-bs-closing')
    // If necessary, you could initiate an AJAX request here
    // and then do the updating in a callback.
    //
    // Update the modal's content.
    var modalTitle = inputModal.querySelector('.modal-title')
    var modalBodyInput = inputModal.querySelector('.modal-body input')

    modalTitle.textContent = start
    modalBodyInput.value = closing
})
