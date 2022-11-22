$(function () {

    $(document).on('click', '.tombolTambahsub', function (e) {
        $('#newSubMenuModalLabel').html('Add New Submenu');
        $('.modal-footer button[type=submit]').html('Add');
        $('#title').val("");
        $('#menu_id').val("");
        $('#url').val("");
        $('#icon').val("");

    });

    $(document).on('click', '.tampilModal', function (e) {
        $('#newSubMenuModalLabel').html('Change Submenu');
        $('.modal-footer button[type=submit]').html('Change');
        $('.modal-body form').attr('action', 'http://localhost/bkpsdm/menu/editsubmenu');

        const id = $(this).data('id');

        $.ajax({
            url: 'http://localhost/bkpsdm/menu/getubahsub',
            data: { id: id },
            method: 'post',
            dataType: 'json',
            success: function (data) {
                $('#is_active').val(data.is_active);
                $('#icon').val(data.icon);
                $('#url').val(data.url);
                $('#title').val(data.title);
                $('#id').val(data.id);
            }
        });
    });



});