<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    <p>
        This page for role settings
    </p>
    <hr>
    <div class="row">
        <div class="col-lg-12">
            <?= form_error('menu', '<div class="alert alert-danger alert-dismissible" role="alert">', '</div>'); ?>
            <?= $this->session->flashdata('menus'); ?>
            <a href="" class="btn mb-3 shadow tampilAddRole text-white" style=" background: #1a4645 ;" data-toggle="modal" data-target="#newRoleModal">Add New Role</a>

            <body>
                <link rel="stylesheet" href="<?= base_url('assets'); ?>/css/sb-admin-2.min.css" />
                <link rel="stylesheet" href="<?= base_url('assets'); ?>/vendor/datatables/dataTables.bootstrap4.min.css" />
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-3">
                        <div class="table-responsive-md" style="margin-bottom: 15px;">
                            <table class="table table-hover" cellspacing="0" width="100%" id="tabelsub">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Role ID</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($role as $r) : ?>
                                        <tr>
                                            <th scope="row"><?= $i; ?></th>
                                            <td><?= $r['role']; ?></td>
                                            <td><?= $r['id']; ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/roleaccess/') . $r['id']; ?>" class="badge badge-warning">access</a>
                                                <a href="" data-toggle="modal" data-id="<?= $r['id']; ?>" data-target="#newRoleModal" class="badge badge-success tampilModalRole">edit</a>
                                                <a href="<?= base_url('admin/deleteRole/' . $r['id']); ?>" class="badge badge-danger" onclick="return confirm('Want to delete this stuff ?')">delete</a>
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.min.js"></script>
                            <script src="<?= base_url('assets/'); ?>js/jquery.min.js"></script>
                            <script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
                            <script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
                            <!-- <script src="<?= base_url('assets/'); ?>js/demo/datatables-demo.js"></script> -->
                        </div>
                    </div>
            </body>
        </div>
    </div>
</div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<script>
    var ctx = document.getElementById("tabelsub");
    $(ctx).DataTable({
        // dom: '<"top">rt<"bottom"lfp><"clear">',
        pagingType: 'full_numbers',
        responsive: true,
        scrollX: true,
        scrollY: true,
        lengthMenu: [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "All"]
        ],
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox select-checkbox-all',
            targets: 0
        }],
        select: {
            style: 'multi',
            selector: 'td:first-child'
        },

        initComplete: function() {
            this.api().columns().every(function() {
                var column = this;
                var search = $(`<input class="form-control form-control-sm" type="text" placeholder="Search">`)
                    .appendTo($(column.footer()).empty())
                    .on('change input', function() {
                        var val = $(this).val()

                        column
                            .search(val ? val : '', true, false)
                            .draw();
                    });

            });
        }

    });
</script>

<!-- Modal Add Role -->
<div class="modal fade" id="newRoleModal" tabindex="-1" role="dialog" aria-labelledby="newRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog shadow" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newRoleModalLabel">Add New Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="<?= base_url('admin/role'); ?>" method="post">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <input type="text" class="form-control" id="role" name="role" placeholder="Role name">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn text-white" style="background:#1a4645 ;">Add</button>
            </div>
            </form>
        </div>
    </div>
</div>