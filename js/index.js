$(document).ready(function () {
    $('#togglePassword').on('click', function (e) {
        e.preventDefault();
        const input = $('#usu_pass');
        const iconShow = $('#icon-show');
        const iconHide = $('#icon-hide');
        const isVisible = input.attr('type') === 'text';
        input.attr('type', isVisible ? 'password' : 'text');
        if (isVisible) {
        iconShow.removeClass('d-none');
        iconHide.addClass('d-none');
        } else {
        iconShow.addClass('d-none');
        iconHide.removeClass('d-none');
        }
    });
});
