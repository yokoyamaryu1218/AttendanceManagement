$('#start_btn').click(function() {
    const now = new Date()
    const hour = now.getHours().toString().padStart(2, '0')
    const minute = now.getMinutes().toString().padStart(2, '0')
    $('#modal_start_time').val(hour + ':' + minute)
})

$('#end_btn').click(function() {
    const now = new Date()
    const hour = now.getHours().toString().padStart(2, '0')
    const minute = now.getMinutes().toString().padStart(2, '0')
    $('#modal_end_time').val(hour + ':' + minute)
})

$("#inputModal").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget);
    var target_day = button.data('day');
    console.log(target_day)
});
