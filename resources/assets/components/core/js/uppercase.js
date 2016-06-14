jQuery(document).ready(function($) {
    // transformar la escritura de los elementos a mayúsculas
    $('input[type=text], textarea').on('keyup', function () {
        $(this).val($(this).val().toUpperCase());
    });
});