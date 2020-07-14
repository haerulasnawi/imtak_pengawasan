<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
  <p>You can see the PO data you sent here</p>
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
                <a href="" class="btn btn-primary mb-3 tombolTambahinvoice text-white border-0" style=" background: #a80231 ;" data-toggle="modal" data-target="#newInvoiceModal">Send a PO to Freelance</a>
                <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-3">
                <div class="table-responsive-sm" style="margin-bottom: 15px;">
                    <table class="table table-hover" cellspacing="0" width="100%" id="tabeldatainvoice">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ID Task Invoice</th>
                                <th scope="col">Task Type</th>
                                <th scope="col">Email</th>
                                <th scope="col">Source Language</th>
                                <th scope="col">Target Language</th>
                                <th scope="col">Value</th>
                                <th scope="col">Date Completed</th>
                                <th scope="col">Date Created</th>
                                <th scope="col">File Invoices</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($datain as $dn) : ?>
                                <tr>
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $dn['id_task_reqtask']; ?></td>
                                    <td><?= $dn['task_type']; ?></td>
                                    <td><?= $dn['email_freelance']; ?></td>
                                    <td><?= $dn['source_lang']; ?></td>
                                    <td><?= $dn['target_lang']; ?></td>
                                    <td><?= $dn['job_value']; ?></td>
                                    <td><?= $dn['date_completed']; ?></td>
                                    <td><?= $dn['date_created']; ?></td>
                                    <td><?= $dn['file_invoice']; ?></td>
                                    <td><?= $dn['status']; ?></td>
                                    <td>
                                        <!-- <a href="" data-target="#newInvoiceModal" data-toggle="modal" data-id="<?= $dn['id']; ?>" class="badge badge-success tampilModalInvoice">edit</a> -->
                                        <a href="<?= site_url('projectmanager/deleteinvoice/' . $dn['id']); ?>" class="badge badge-danger" onclick="return confirm('Want to delete this stuff ?')">delete</a>
                                        <a href="<?= base_url('projectmanager/downloadinvoice/' . $dn['id']); ?>" class="badge badge-primary">download</a>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ID Task Invoice</th>
                                <th scope="col">Task Type</th>
                                <th scope="col">Email</th>
                                <th scope="col">Source Language</th>
                                <th scope="col">Target Language</th>
                                <th scope="col">Value</th>
                                <th scope="col">Date Completed</th>
                                <th scope="col">Date Created</th>
                                <th scope="col">File Invoices</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </tfoot>
                    </table>
                    <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.min.js"></script>
                    <script src="<?= base_url('assets/'); ?>js/jquery.min.js"></script>
                    <script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
                    <script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
                    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
                    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.bootstrap4.min.js"></script>
                    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
                    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
                    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
                    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
                    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
                    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.colVis.min.js"></script>
                    <!-- <script src="<?= base_url('assets/'); ?>js/demo/datatables-demo.js"></script> -->
                    <!-- <script src="<?= base_url('assets/'); ?>js/data-table/datatableButton.js" type="text/javascript"></script>
                    <script src="<?= base_url('assets/'); ?>js/data-table/flash.js" type="text/javascript"></script>
                    <script src="<?= base_url('assets/'); ?>js/html5.js" type="text/javascript"></script>
                    <script src="<?= base_url('assets/'); ?>js/jzip.js" type="text/javascript"></script>
                    <script src="<?= base_url('assets/'); ?>js/pdf.js" type="text/javascript"></script>
                    <script src="<?= base_url('assets/'); ?>js/print.js" type="text/javascript"></script>
                    <script src="<?= base_url('assets/'); ?>js/vfs.js" type="text/javascript"></script> -->
                    <!-- <script src="<?= base_url('assets/'); ?>js/js/dropify.js" type="text/javascript"></script> -->
                    <!-- <script src="{{ asset('public/assets/js/sweetalert.js') }}"></script> -->
                    <!-- <script src="<?= base_url('assets/'); ?>js/select2.js" type="text/javascript"></script> -->

            </body>
        </div>
        </div>
        </div>
    </div>
</div>
</div>
<script>
    var ctx = document.getElementById("tabeldatainvoice");
    $(ctx).DataTable({
        pagingType: 'full_numbers',
        responsive: true,
        scrollX: true,
        scrollY: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        // lengthChange: false,
        dom: 'Bfrtip',
        buttons: [{
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                }
            },
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                filename: 'Send Invoice Data',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                }
            }
        ],
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
<div class="modal fade" id="newInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="newInvoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newInvoiceModalLabel">Send a New Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('projectmanager/invoicedata'); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="date_created" name="date_created">
                    <input type="hidden" id="status" name="status">
                    <div class="form-group">
                        <label for="id_task_reqtask">Task to invoice</label>
                        <select name="id_task_reqtask" id="id_task_reqtask" class="form-control">
                            <option value="">Select Task</option>
                            <?php foreach ($taskinvoice as $ti) : ?>
                                <option value="<?= $ti['id_reqtask']; ?>"><?= $ti['name']; ?> - <?= $ti['file_final']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('id_task_reqtask', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="task_type">Task Type</label>
                        <input type="text" class="form-control" id="task_type" name="task_type">
                        <?= form_error('task_type', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="source_lang">Source Language</label>
                            <input type="text" class="form-control" id="source_lang" name="source_lang">
                            <?= form_error('source_lang', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="target_lang">Target Language</label>
                            <input type="text" class="form-control" id="target_lang" name="target_lang">
                            <?= form_error('target_lang', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="email_freelance">Email</label>
                            <select name="email_freelance" id="email_freelance" class="form-control">
                                <option value="">Select Email</option>
                                <?php foreach ($taskinvoice as $ti) : ?>
                                    <option value="<?= $ti['email']; ?>"><?= $ti['email']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('email_freelance', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="date_completed">Date Completed</label>
                            <select name="date_completed" id="date_completed" class="form-control">
                                <option value="">Select Date</option>
                                <?php foreach ($taskinvoice as $ti) : ?>
                                    <option value="<?= $ti['date_created']; ?>"><?= $ti['date_created']; ?> - <?= $ti['email']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('date_completed', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="job_value">Value</label>
                            <select name="job_value" id="job_value" class="form-control">
                                <option value="">Select Value</option>
                                <?php foreach ($reqtask as $rt) : ?>
                                    <option value="<?= $rt['job_value']; ?>">$<?= $rt['job_value']; ?> - <?= $rt['email']; ?> - <?= $rt['task_type']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('date_completed', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="task_files">Upload Invoice File</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="file_invoice" name="file_invoice">
                                <label class="custom-file-label" for="file_invoice">Choose file</label>
                                <?= form_error('file_invoice', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn text-white" style="background:#a80231 ;">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- /.container-fluid -->




</div>
<!-- End of Main Content -->