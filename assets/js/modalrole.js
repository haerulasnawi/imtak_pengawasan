$(function () {

    $(document).on('click', '.tampilAddRole', function (e) {
        $('#newRoleModalLabel').html('Add New Role');
        $('.modal-footer button[type=submit]').html('Add');
        $('#role').val("");

    });

    $(document).on('click', '.tampilModalRole', function (e) {
        $('#newRoleModalLabel').html('Change Role');
        $('.modal-footer button[type=submit]').html('Change');
        $('.modal-body form').attr('action', 'http://localhost/bkpsdm/admin/editRole');

        const id = $(this).data('id');

        $.ajax({
            url: 'http://localhost/bkpsdm/admin/getubahrole',
            data: { id: id },
            method: 'post',
            dataType: 'json',
            success: function (data) {
                $('#role').val(data.role);
                $('#id').val(data.id);
            }
        });
    });

});