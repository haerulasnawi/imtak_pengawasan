<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
  <p>You can see the task submission result here</p>
  <hr class="mb-4">

    <div class="row align-middle position-relative">

        <?php if (validation_errors()) : ?>
            <div class="alert alert-danger" role="alert">
                <?= validation_errors(); ?>
            </div>
        <?php endif; ?>
        <?= $this->session->flashdata('menus') ?>

        <div class="col-lg-12">
        
            <body>
                <link rel="stylesheet" href="<?= base_url('assets'); ?>/css/sb-admin-2.min.css" />
                <link rel="stylesheet" href="<?= base_url('assets'); ?>/vendor/datatables/dataTables.bootstrap4.min.css" />
                <a href="" class="btn btn-primary mb-3 tombolTambahtaskinvoice text-white border-0" style=" background: #a80231 ;" data-toggle="modal" data-target="#newTaskInvoiceModal">Submit a Task</a>
                <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-3">
                <div class="table-responsive-sm" style="margin-bottom: 15px;">
                    <table class="table table-hover" cellspacing="0" width="100%" id="tabelinvoiceawait">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Email PM</th>
                                <th scope="col">Your Name</th>
                                <th scope="col">Your Email</th>
                                <th scope="col">Base Task ID</th>
                                <th scope="col">Files</th>
                                <th scope="col">Date Created</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            ?>
                            <?php foreach ($taskinvoiceuser as $tiu) : ?>
                                <tr>
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $tiu['email_hr']; ?></td>
                                    <td><?= $tiu['name']; ?></td>
                                    <td><?= $tiu['email']; ?></td>
                                    <td><?= $tiu['id_reqtask']; ?></td>
                                    <td><?= $tiu['file_final']; ?></td>
                                    <td><?= $tiu['date_created']; ?></td>
                                    <td><?= $tiu['status']; ?></td>
                                    <td>
                                        <!-- <a href="" data-target="#newTaskModal" data-toggle="modal" data-id="<?= $tiu['id']; ?>" class="badge badge-success tampilModalTaskInvoice">edit</a>
                                        <a href="<?= site_url('user/deletetaskfinal/' . $tiu['id']); ?>" class="badge badge-danger" onclick="return confirm('Want to delete this stuff ?')">delete</a> -->
                                        <a href="<?= base_url('user/downloadtaskfinal/' . $tiu['id']); ?>" class="badge badge-primary">download</a>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Email HR</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Base Task ID</th>
                                <th scope="col">Files</th>
                                <th scope="col">Date Created</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </tfoot>
                    </table>
                    </div>
                    </div>
                    <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.min.js"></script>
                    <script src="<?= base_url('assets/'); ?>js/jquery.min.js"></script>
                    <script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
                    <script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
                    <!-- <script src="<?= base_url('assets/'); ?>js/demo/datatables-demo.js"></script> -->
            </body>
            
        </div>
    </div>
</div>
</div>
<script>
    var ctx = document.getElementById("tabelinvoiceawait");
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
<!-- Modal Add Menu -->
<div class="modal fade" id="newTaskInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="newTaskInvoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newTaskInvoiceModalLabel">Submit a Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('user/invoiceAwait'); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="date_created" name="date_created">
                    <input type="hidden" id="status" name="status">
                    <div class="form-group">
                        <label for="email_hr">Email PM</label>
                        <select name="email_hr" id="email_hr" class="form-control">
                            <option value="">Select Email</option>
                            <?php foreach ($humanr as $hr) : ?>
                                <option value="<?= $hr['email']; ?>"><?= $hr['email']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('email_hr', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="id_reqtask">Task</label>
                        <select name="id_reqtask" id="id_reqtask" class="form-control">
                            <option value="">Select Task</option>
                            <?php foreach ($reqtask as $rts) : ?>
                                <option value="<?= $rts['id']; ?>"><?= $rts['task_files']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('id_reqtask', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Your Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= $user['name']; ?>" readonly>
                            <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">Your Email</label>
                            <input type="text" class="form-control" id="email" name="email" value="<?= $user['email']; ?>" readonly>
                            <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="file_final">Files</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file_final" name="file_final">
                            <label class="custom-file-label" for="task_files">Choose file</label>
                            <?= form_error('file_final', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Your Email Password</label>
                        <div class="input-group" id="show_hide_password">
                            <input class="form-control" type="password" id="password" name="password" placeholder="Password">
                            <!-- <div class="input-group-addon">
                                <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                            </div> -->
                        </div>
                    </div>
                    <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn text-white" style="background:#a80231 ;">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- <script>
    $(document).ready(function() {
        $("#show_hide_password a").on('click', function(event) {
            event.preventDefault();
            if ($('#show_hide_password input').attr("type") == "text") {
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass("fa-eye-slash");
                $('#show_hide_password i').removeClass("fa-eye");
            } else if ($('#show_hide_password input').attr("type") == "password") {
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass("fa-eye-slash");
                $('#show_hide_password i').addClass("fa-eye");
            }
        });
    });
</script> -->



<!-- /.container-fluid -->




</div>
<!-- End of Main Content -->