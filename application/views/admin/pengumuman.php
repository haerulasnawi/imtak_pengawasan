<div class="container-fluid">

    <!-- Page Heading -->

    <!-- <div class="shadow-sm p-3 mb-3 bg-white rounded"> -->
    <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    <p>Admin can do a announce here</p>
    <hr>
    <!-- </div> -->


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
                <a href="" class="btn btn-primary mb-3 shadow-sm tombolTambahtask text-white border-0" data-toggle="modal" data-target="#newTaskModal">Create Announcement</a>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-3">
                        <div class="table-responsive-sm" style="margin-bottom: 15px;">
                            <table class="table table-hover" cellspacing="0" width="100%" id="tabeltask">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Uraian</th>
                                        <th scope="col">Gambar</th>
                                        <th scope="col">Date Created</th>
                                        <th scope="col">Is_Active</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($pengumuman as $um) : ?>
                                        <tr>
                                            <th scope="row"><?= $i; ?></th>
                                            <td><?= $um['title']; ?></td>
                                            <td><?= $um['uraian']; ?></td>
                                            <td><img src="<?= base_url('assets/informasi/' . $um['image']); ?>" width="200px"></td>
                                            <td><?= date('d F Y', $um['date_created']); ?></td>
                                            <td><?= $um['is_active']; ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/download/' . $um['id']); ?>" data-id="<?= $um['id']; ?>" data-target="#editpengumumanmodal" data-toggle="modal" class="badge badge-success">edit</a>
                                                <a href="<?= site_url('admin/deletepengumuman/' . $um['id']); ?>" class="badge badge-danger" onclick="return confirm('Want to delete this stuff ?')">delete</a>
                                                <!-- <a href="<?= base_url('admin/download/' . $um['id']); ?>" class="badge badge-primary">download</a> -->
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                                <!-- <tfoot>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Task Type</th>
                                        <th scope="col">Source Language</th>
                                        <th scope="col">Target Language</th>
                                        <th scope="col">Freelance</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Files</th>
                                        <th scope="col">Deadline</th>
                                        <th scope="col">Value</th>
                                        <th scope="col">Date Created</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </tfoot> -->
                            </table>
                        </div>
                    </div>
                    <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.min.js"></script>
                    <script src="<?= base_url('assets/'); ?>js/jquery.min.js"></script>
                    <script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
                    <script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
                    <!-- <script src="<?= base_url('assets/'); ?>js/demo/datatables-demo.js"></script> -->
                    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
                    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.bootstrap4.min.js"></script>
                    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
                    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
                    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
                    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
                    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
                    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.colVis.min.js"></script>
            </body>
        </div>
    </div>
</div>
</div>
<script>
    var ctx = document.getElementById("tabeltask");
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
        dom: 'lBfrtip',
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
<div class="modal fade" id="newTaskModal" tabindex="-1" role="dialog" aria-labelledby="newTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newTaskModalLabel">Create a New Announcement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/informasi'); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="date_created" name="date_created">
                    <div class="form-group">
                        <label for="title">Judul</label>
                        <input type="text" class="form-control" id="title" name="title">
                        <?= form_error('title', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="uraian">Uraian</label>
                        <input type="text" class="form-control" id="uraian" name="uraian">
                        <?= form_error('uraian', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="image">Upload Gambar</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" name="image">
                            <label class="custom-file-label" for="image">Choose file</label>
                            <?= form_error('image', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" value="1" id="is_active" name="is_active">
                            <label class="form-check-label" for="is_active">
                                Active?
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn text-white" style="background:#1a4645 ;">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Pengumuman -->
<div class="modal fade" id="editpengumumanmodal" tabindex="-1" role="dialog" aria-labelledby="editpengumumanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editpengumumanModalLabel">Edit Announcement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/edit_pengumuman'); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="id" name="id" value="<?= $um['id']; ?>">
                    <input type="hidden" id="date_created" name="date_created" value="<?= $um['date_created']; ?>">
                    <div class="form-group">
                        <label for="title">Judul</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?= $um['title']; ?>">
                        <?= form_error('title', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="uraian">Uraian</label>
                        <input type="text" class="form-control" id="uraian" name="uraian" value="<?= $um['uraian']; ?>">
                        <?= form_error('uraian', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="image">Upload Gambar</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" name="image">
                            <label class="custom-file-label" for="image">Choose file</label>
                            <?= form_error('image', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" checked type="checkbox" value="1" id="is_active" name="is_active">
                            <label class="form-check-label" for="is_active">
                                Active?
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn text-white" style="background:#1a4645 ;">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- /.container-fluid -->




</div>
<!-- End of Main Content -->