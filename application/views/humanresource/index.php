<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
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

                <a href="" class="btn btn-primary mb-3 tampilModalUbahFree" data-toggle="modal" data-target="#newFreelanceModal">Add New Freelance</a>
                <div class="table-responsive-md" style="margin-bottom: 15px;">
                    <table class="table table-hover" cellspacing="0" width="100%" id="tabelku">
                        <thead>
                            <tr>
                                <th scope="col" class="th-sm">#</th>
                                <th scope="col" class="th-sm">Name</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Telepon</th>
                                <th scope="col">Email</th>
                                <th scope="col">Language</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($freelance as $fr) : ?>
                                <tr>
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $fr['name']; ?></td>
                                    <td><?= $fr['alamat']; ?></td>
                                    <td><?= $fr['no_telp']; ?></td>
                                    <td><?= $fr['email']; ?></td>
                                    <td><?= $fr['language']; ?></td>
                                    <td>
                                        <a href="" data-toggle="modal" data-id="<?= $fr['id']; ?>" data-target="#newFreelanceModal" class="badge badge-success tampilModalFreelance">edit</a>
                                        <a href="<?= site_url('humanresource/deleteuser/' . $fr['id']); ?>" class="badge badge-danger" onclick="return confirm('Want to delete this stuff ?')">delete</a>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        <tfoot>
                            <tr>
                                <th scope="col" class="th-sm">#</th>
                                <th scope="col" class="th-sm">Name</th>
                                <th scope="col" class="th-sm">Alamat</th>
                                <th scope="col" class="th-sm">Telepon</th>
                                <th scope="col" class="th-sm">Email</th>
                                <th scope="col" class="th-sm">Language</th>
                                <th scope="col" class="th-sm">Action</th>
                            </tr>
                        </tfoot>
                        </tbody>
                    </table>
                </div>

            </div>
    </div>

    <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= base_url('assets/'); ?>js/jquery.min.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url('assets/'); ?>js/demo/datatables-demo.js"></script>
    </body>


</div>
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
                        <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat" value="<?= set_value('alamat'); ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="Telepon" value="<?= set_value('no_telp'); ?>">
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
                        <button type="submit" class="btn btn-primary">Add Freelance</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- /.container-fluid -->



</div>
<!-- End of Main Content -->