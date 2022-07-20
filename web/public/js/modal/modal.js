const modal = document.querySelector('.main-modal');
const closeButton = document.querySelectorAll('.modal-close');
const inputModal = document.getElementById('.inputModal');


const modalClose = () => {
    modal.classList.remove('fadeIn');
    modal.classList.add('fadeOut');
    setTimeout(() => {
        modal.style.display = 'none';
    }, 500);
}

const openModal = () => {
    modal.classList.remove('fadeOut');
    modal.classList.add('fadeIn');
    modal.style.display = 'flex';
}

for (let i = 0; i < closeButton.length; i++) {

    const elements = closeButton[i];

    elements.onclick = (e) => modalClose();

    modal.style.display = 'none';

    window.onclick = function (event) {
        if (event.target == modal) modalClose();
    }
}


// https://flowbite.com/docs/components/modal/#javascript-behaviour
$('#inputModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var target_day = button.data('day')
    console.log(target_day)
})
