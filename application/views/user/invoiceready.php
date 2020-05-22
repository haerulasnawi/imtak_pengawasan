<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

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
                <a href="" class="btn btn-primary mb-3 tombolTambahinvoice" data-toggle="modal" data-target="#newInvoiceModal">Send a Invoice</a>
                <div class="table-responsive-sm" style="margin-bottom: 15px;">
                    <table class="table table-hover" cellspacing="0" width="100%" id="tabelReadyinvoice">
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
                            <?php foreach ($datainvoice as $di) : ?>
                                <tr>
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $di['id_task_invoice']; ?></td>
                                    <td><?= $di['task_type']; ?></td>
                                    <td><?= $di['email_freelance']; ?></td>
                                    <td><?= $di['source_lang']; ?></td>
                                    <td><?= $di['target_lang']; ?></td>
                                    <td><?= $di['job_value']; ?></td>
                                    <td><?= $di['date_completed']; ?></td>
                                    <td><?= $di['date_created']; ?></td>
                                    <td><?= $di['file_invoice']; ?></td>
                                    <td><?= $di['status']; ?></td>
                                    <td>
                                        <a href="" data-target="#newInvoiceModal" data-toggle="modal" data-id="<?= $di['id']; ?>" class="badge badge-success tampilModalInvoice">edit</a>
                                        <a href="<?= site_url('humanresource/deleteinvoice/' . $di['id']); ?>" class="badge badge-danger" onclick="return confirm('Want to delete this stuff ?')">delete</a>
                                        <a href="<?= base_url('humanresource/downloadinvoice/' . $di['id']); ?>" class="badge badge-primary">download</a>
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
                            </tr>
                        </tfoot>
                    </table>
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
    var ctx = document.getElementById("tabelReadyinvoice");
    $(ctx).DataTable({
        // dom: '<"top">rt<"bottom"lfp><"clear">',
        pagingType: 'full_numbers',
        responsive: true,
        scrollX: true,
        scrollY: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
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



<!-- /.container-fluid -->




</div>
<!-- End of Main Content -->