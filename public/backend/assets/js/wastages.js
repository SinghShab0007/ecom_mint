$(document).ready(function () {

    $(document).on('change', '#name', function () {
        var wastage = $(this).find(":selected").attr('data-code');
        $('#code').val('');
        $('#code').val(wastage);

    });


});
