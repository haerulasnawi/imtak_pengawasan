<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
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
                <div class="table-responsive-md" style="margin-bottom: 15px;">
                    <table class="table table-hover" cellspacing="0" width="100%" id="tabeltask">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Task Type</th>
                                <th scope="col">Source Language</th>
                                <th scope="col">Target Language</th>
                                <th scope="col">Value</th>
                                <th scope="col">Deadline</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($taskuser as $rtso) : ?>
                                <tr>
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $rtso['task_type']; ?></td>
                                    <td><?= $rtso['source_lang']; ?></td>
                                    <td><?= $rtso['target_lang']; ?></td>
                                    <td>$<?= $rtso['job_value']; ?></td>
                                    <td><?= date('d-m-Y', strtotime($rtso['deadline'])); ?></td>
                                </tr>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Task Type</th>
                                <th scope="col">Source Language</th>
                                <th scope="col">Target Language</th>
                                <th scope="col">Value</th>
                                <th scope="col">Deadline</th>
                            </tr>
                        </tfoot>
                    </table>
                    <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.min.js"></script>
                    <script src="<?= base_url('assets/'); ?>js/jquery.min.js"></script>
                    <script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
                    <script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
                    <script src="<?= base_url('assets/'); ?>js/demo/datatables-demo.js"></script>
                </div>
            </body>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->