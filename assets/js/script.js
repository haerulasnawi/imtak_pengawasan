$(function () {

    $('.tombolTambahData').on('click', function () {
        $('#newMenuModalLabel').html('Add New Menu');
        $('.modal-footer button[type=submit]').html('Add');
        $('#menu').val("");


    });

    $('.tampilModalUbah').on('click', function () {
        $('#newMenuModalLabel').html('Change Menu');

        $('.modal-footer button[type=submit]').html('Change');
        $('.modal-body form').attr("action", "<?= base_url('menu/editmenu');?>");

        const id = $(this).data('id');

        $.ajax({
            url: 'http://localhost/wpu-login/menu/getubah',
            data: { id: id },
            method: 'post',
            dataType: 'json',
            success: function (data) {
                $('#menu').val(data.menu);
                $('#id').val(data.id);
            }
        });
    });

});