$(function () {

    $(document).on('click', '.tombolTambahData', function (e) {
        $('#newMenuModalLabel').html('Add New Menu');
        $('.modal-footer button[type=submit]').html('Add');
        $('#menu').val("");
    });

    $(document).on('click', '.tampilModalUbah', function (e) {
        $('#newMenuModalLabel').html('Change Menu');

        $('.modal-footer button[type=submit]').html('Change');
        $('.modal-body form').attr('action', 'http://localhost/bkpsdm/menu/editmenu');

        const id = $(this).data('id');

        $.ajax({
            url: 'http://localhost/bkpsdm/menu/getubah',
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