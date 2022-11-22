<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    <p>Data pegawai coaching clinic</p>
    <hr class="mb-4">
    <div class="row">

        <?= $this->session->flashdata('menus'); ?>
        <?php if (validation_errors()) : ?>
            <div class="alert alert-danger" role="alert">
                <?= validation_errors(); ?>
            </div>

        <?php endif; ?>

        <body>
            <link rel="stylesheet" href="<?= base_url('assets'); ?>/css/sb-admin-2.min.css" />
            <link rel="stylesheet" href="<?= base_url('assets'); ?>/vendor/datatables/dataTables.bootstrap4.min.css" />
            <div class="col-sm-12">

                <!-- <a href="" class="btn btn-primary mb-3 tampilModalUbahFree text-white border-0" style=" background: #a80231 ;" data-toggle="modal" data-target="#newFreelanceModal">Add New Freelance</a> -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-3">
                        <div class="table-responsive-md" style="margin-bottom: 15px;">
                            <table class="table table-hover" cellspacing="0" width="100%" id="tabelkus">
                                <thead>
                                    <tr>
                                        <th scope="col" class="th-sm">#</th>
                                        <th scope="col" class="th-sm">NIP</th>
                                        <th scope="col">Nama Lengkap</th>
                                        <th scope="col">No. HP</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Unit Kerja</th>
                                        <th scope="col">Date Created</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($useraja as $ua) : ?>
                                        <tr>
                                            <th scope="row"><?= $i; ?></th>
                                            <td><?= $ua['nip']; ?></td>
                                            <td><?= $ua['name']; ?></td>
                                            <td><?= $ua['no_hp']; ?></td>
                                            <td><?= $ua['email']; ?></td>
                                            <td><?= $ua['unit_kerja']; ?></td>
                                            <td><?= date('d-m-Y', $ua['date_created']); ?></td>
                                            <td>
                                                <!-- <a href="" data-toggle="modal" data-id="<?= $ua['id']; ?>" data-target="#newFreelanceModal" class="badge badge-success tampilModalFreelance">edit</a> -->
                                                <a href="<?= site_url('humanresource/deleteuser/' . $ua['id']); ?>" class="badge badge-danger" onclick="return confirm('Want to delete this stuff ?')">delete</a>
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                    <!-- <tfoot>
                                    <tr>
                                        <th scope="col" class="th-sm">#</th>
                                        <th scope="col" class="th-sm">Name</th>
                                        <th scope="col" class="th-sm">Alamat</th>
                                        <th scope="col" class="th-sm">Telepon</th>
                                        <th scope="col" class="th-sm">Email</th>
                                        <th scope="col" class="th-sm">Language</th>
                                        <th scope="col" class="th-sm">Action</th>
                                    </tr>
                                </tfoot> -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
    </div>

    <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= base_url('assets/'); ?>js/jquery.min.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url('assets/'); ?>js/demo/datatables-demo.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.colVis.min.js"></script>


    <script>
        $('#tabelkus').DataTable({
            // dom: '<"top">rt<"bottom"lfp><"clear">',
            pagingType: 'full_numbers',
            responsive: true,
            scrollX: true,
            scrollY: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            dom: 'lBfrtip',
            buttons: [{
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'csvHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'LEGAL',
                    filename: 'Coaching List',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                }
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


    </body>
</div>

<!-- <script>
    var ctx = document.getElementById("tabelku");
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
                    columns: [0, 1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'pdfHtml5',
                orientation: 'potrait',
                pageSize: 'LEGAL',
                filename: 'Data Freelance',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
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
        };

    });
    
</script> -->
<!-- Modal Add Freelance -->
<div class="modal fade" id="newFreelanceModal" tabindex="-1" role="dialog" aria-labelledby="newFreelanceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newFreelanceModalLabel">Add New Freelance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="<?= base_url('humanresource'); ?>" method="post">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?= set_value('name'); ?>">
                        <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Address" value="<?= set_value('alamat'); ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="Phone Number" value="<?= set_value('no_telp'); ?>">
                    </div>
                    <div class="form-group">
                        <select name="email" id="email" class="form-control">
                            <option value="">Select Email</option>
                            <?php foreach ($useraja as $ua) : ?>
                                <option value="<?= $ua['email']; ?>"><?= $ua['email']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="language" name="language" placeholder="Language" value="<?= set_value('language'); ?>">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn text-white" style="background:#a80231 ;">Add Freelance</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- /.container-fluid -->



</div>
<!-- End of Main Content -->