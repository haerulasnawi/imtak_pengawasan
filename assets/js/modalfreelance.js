$(function () {

    $(document).on('click', '.tampilModalUbahFree', function (e) {
        $('#newFreelanceModalLabel').html('Add New Freelance');
        $('.modal-footer button[type=submit]').html('Add');
        $('#name').val("");
        $('#alamat').val("");
        $('#no_telp').val("");
        $('#language').val("");

    });

    $(document).on('click', '.tampilModalFreelance', function (e) {
        $('#newFreelanceModalLabel').html('Change Data Freelance');
        $('.modal-footer button[type=submit]').html('Change');
        $('.modal-body form').attr('action', 'http://localhost/wpu-login/humanresource/editfreelance');

        const id = $(this).data('id');

        $.ajax({
            url: 'http://localhost/wpu-login/humanresource/getubahfreelance',
            data: { id: id },
            method: 'post',
            dataType: 'json',
            success: function (data) {
                $('#language').val(data.language);
                $('#no_telp').val(data.no_telp);
                $('#alamat').val(data.alamat);
                $('#name').val(data.name);
                $('#id').val(data.id);
            }
        });
    });

});