<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    <p>You can create a new user here</p>
    <hr class="mb-4">

    <div class="row">
        <?php $this->view('message') ?>

        <?= $this->session->flashdata('menus'); ?>
        <?php if (validation_errors()) : ?>
            <div class="alert alert-danger" role="alert">
                <?= validation_errors(); ?>
            </div>

        <?php endif; ?>

        <div class="col-lg-12">

            <body>
                <link rel="stylesheet" href="<?= base_url('assets'); ?>/css/sb-admin-2.min.css" />
                <link rel="stylesheet" href="<?= base_url('assets'); ?>/vendor/datatables/dataTables.bootstrap4.min.css" />

                <a href="" class="btn btn-primary mb-3 text-white border-0" style=" background: #a80231 ;" data-toggle="modal" data-target="#newUserModal">Add New User</a>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-3">
                        <div class="table-responsive" style="margin-bottom: 15px;">
                            <table class="table table-hover" width="100%" id="tabeluserlist">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th style="width:100px;">Name</th>
                                        <th style="width:50px;">Email</th>
                                        <th style="width:20px;">Image</th>
                                        <th style="width:10px;">Role ID</th>
                                        <th style="width:10px;">Active</th>
                                        <th style="width:20px;">Created</th>
                                        <th style="width:10px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($userlist as $us) : ?>
                                        <tr>
                                            <th scope="row"><?= $i; ?></th>
                                            <td><?= $us['name']; ?></td>
                                            <td><?= $us['email']; ?></td>
                                            <td><?= $us['image']; ?></td>
                                            <td><?= $us['role_id']; ?></td>
                                            <td><?= $us['is_active']; ?></td>
                                            <td><?= date('d F Y', $us['date_created']); ?></td>
                                            <td>
                                                <a href="<?= site_url('humanresource/deleteuser/' . $us['id']); ?>" class="badge badge-danger" onclick="return confirm('Want to delete this stuff ?')">delete</a>
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                                <!-- <tfoot>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Role ID</th>
                                        <th scope="col">Active</th>
                                        <th scope="col">Created</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </tfoot> -->
                            </table>
                            <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.min.js"></script>
                            <script src="<?= base_url('assets/'); ?>js/jquery.min.js"></script>
                            <script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
                            <script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
                            <script src="<?= base_url('assets/'); ?>js/demo/datatables-demo.js"></script>
            </body>
        </div>
    </div>
</div>
<div class="alert alert-info mb-4" role="alert">
    Description! ⫸ Role ID : 1 → Administration | 2 → Freelance | 4 → Humanresource | 5 → Project Manager | 6 → Finance || Active : 1 → True | 0 → False
</div>
</div>
</div>
</div>

<!-- <script>
    var ctx = document.getElementById("tabeluserlist");
    $(ctx).DataTable({
  // dom: '<"top">rt<"bottom"lfp><"clear">',
  pagingType: 'full_numbers',
  responsive: true,

  columnDefs: [{
    orderable: false,
    className: 'select-checkbox select-checkbox-all',
    targets: 0
  }],
  select: {
    style: 'multi',
    selector: 'td:first-child'
  },
  initComplete: function () {
    this.api().columns().every(function () {
      var column = this;
      var search = $(`<input class="form-control form-control-sm" type="text" placeholder="Search">`)
        .appendTo($(column.footer()).empty())
        .on('change input', function () {
          var val = $(this).val()

          column
            .search(val ? val : '', true, false)
            .draw();
        });

    });
  };
</scrip> -->


<div class="modal fade" id="newUserModal" tabindex="-1" role="dialog" aria-labelledby="newUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newUserModalLabel">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('humanresource/userlist'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?= set_value('name'); ?>">
                        <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email Address" value="<?= set_value('email'); ?>">
                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <select name="role_id" id="role_id" class="form-control">
                            <option value="">Select Role</option>
                            <?php foreach ($user_role as $ur) : ?>
                                <option value="<?= $ur['id']; ?>"><?= $ur['role']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password1" name="password1" placeholder="Password">
                        <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password2" name="password2" placeholder="Repeat Password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn text-white" style="background:#a80231 ;">Add User</button>
                </div>
            </form>
        </div>
    </div>
</div>

</div>