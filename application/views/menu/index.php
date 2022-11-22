<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    <p>You can create a new menu here</p>
    <hr class="mb-4">

    <div class="row">
        <div class="col-lg-12">
            <?= form_error('menu', '<div class="alert alert-danger alert-dismissible" role="alert">', '</div>'); ?>
            <?= $this->session->flashdata('menus'); ?>

            <body>
                <link rel="stylesheet" href="<?= base_url('assets'); ?>/css/sb-admin-2.min.css" />
                <link rel="stylesheet" href="<?= base_url('assets'); ?>/vendor/datatables/dataTables.bootstrap4.min.css" />
                <a href="" class="btn btn-primary mb-3 tombolTambahData text-white border-0" data-toggle="modal" data-target="#newMenuModal">Add New Menu</a>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-3">
                        <div class="table-responsive-md" style="margin-bottom: 15px;">
                            <table class="table table-hover" cellspacing="0" width="100%" id="tabelmenu">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Menu</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($menu as $m) : ?>
                                        <tr>
                                            <th scope="row"><?= $i; ?></th>
                                            <td><?= $m['menu']; ?></td>
                                            <td>
                                                <a href="" data-toggle="modal" data-id="<?= $m['id']; ?>" data-target="#newMenuModal" class="badge badge-success tampilModalUbah">edit</a>
                                                <a href="<?= site_url('menu/deletemenu/' . $m['id']); ?>" class="badge badge-danger" onclick="return confirm('Want to delete this stuff ?')">delete</a>
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                                <!-- <tfoot>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Menu</th>
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
</div>
</div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal Add Menu -->
<div class="modal fade" id="newMenuModal" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenuModalLabel">Add New Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('menu'); ?>" method="post">
                    <input type="hidden" name="id" id="id">

                    <div class="form-group">
                        <input type="text" class="form-control" id="menu" name="menu" placeholder="Menu name">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn text-white" style="background:#a80231 ;">Add</button>
            </div>
            </form>
        </div>
    </div>
</div>