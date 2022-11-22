<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    <p>You can see the requested coaching given here</p>
    <hr class="mb-4">


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
                <a href="" class="btn btn-primary mb-3 text-white border-0" data-toggle="modal" data-target="#newAgendaModal">+ Agenda</a>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-3">
                        <div class="table-responsive-md" style="margin-bottom: 15px;">
                            <table class="table table-hover" cellspacing="0" width="100%" id="tabeltaskuser">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Permasalahan</th>
                                        <th scope="col">Penjelasan Umum</th>
                                        <th scope="col">Tanggal & Waktu</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($event as $ev) : ?>
                                        <tr>
                                            <th scope="row"><?= $i; ?></th>
                                            <td><?= $ev['event_problem']; ?></td>
                                            <td><?= $ev['penjelasan_umum']; ?></td>
                                            <td><?= date('d-m-Y', strtotime($ev['date_event'])); ?></td>
                                            <!-- <td><?= date('d-m-Y', strtotime($ev['deadline'])); ?></td> -->
                                            <td><?= $ev['status']; ?></td>
                                            <?php if ($ev['status'] == "disetujui") { ?>
                                                <td>
                                                    <a href="#" class="badge badge-primary"">selesai</a>
                                                </td>
                                            <?php } else { ?>
                                                <td>
                                                    <a href=" <?= site_url('user/deleteevent/' . $ev['id']); ?>" class="badge badge-danger" onclick="return confirm('Want to delete this agenda ?')">delete</a>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.min.js"></script>
                            <script src="<?= base_url('assets/'); ?>js/jquery.min.js"></script>
                            <script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
                            <script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
                            <script src="<?= base_url('assets/'); ?>js/demo/datatables-demo.js"></script>
                        </div>
                    </div>
                </div>
            </body>
        </div>
    </div>
</div>

<!-- Add Agenda Modal -->

<div class="modal fade" id="newAgendaModal" tabindex="-1" role="dialog" aria-labelledby="newAgendaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newAgendaModalLabel">Tambah Agenda Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('user/requestCoaching'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="id_user" name="id_user" value="<?= $user['id']; ?>">
                    <input type="hidden" id="date_created" name="date_created">
                    <input type="hidden" id="status" name="status">
                    <input type="hidden" id="name" name="name" value="<?= $user['name']; ?>">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="email" name="email" value="<?= $user['email']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="no_hp" name="no_hp" value="<?= $user['no_hp']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="event_problem">Pilih Permasalahan</label>
                        <select class="form-control" id="event_problem" name="event_problem">
                            <option>Permasalahan Hukum</option>
                            <option>Permasalahan Personal</option>
                            <option>Permasalahan Kepegawaian</option>
                        </select>
                        <?= form_error('event_problem', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" id="penjelasan_umum" name="penjelasan_umum" placeholder="Penjelasan umum"></textarea>
                        <?= form_error('penjelasan_umum', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <!-- <div class="input-group date" id="date_event" data-target-input="nearest"> -->
                        <input type="date" id="date_event" name="date_event" class="form-control" value="<?= set_value('deadline'); ?>" />
                        <!-- <div class="input-group-append" data-target="#date_event" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div> -->
                        <!-- </div> -->
                        <!-- <?= form_error('date_event', '<small class="text-danger pl-3">', '</small>'); ?> -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah Agenda</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- /.container-fluid -->
<script>
    var ctx = document.getElementById("tabeltaskuser");
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

<script>
    $(function() {
        $('#date_event').datetimepicker({
            format: 'YYYY/DD/MM',
            language: "id",
            autoclose: true
        });
    });
</script>
<script type="text/javascript">
    (function() {
        var options = {
            email: "bkpsdm@mataramkota.go.id", // Email
            call: " 0370644491", // Sms phone number
            call_to_action: "Message us", // Call to action
            button_color: "#E74339", // Color of button
            position: "right", // Position may be 'right' or 'left'
            order: "email,sms", // Order of buttons
        };
        var proto = document.location.protocol,
            host = "getbutton.io",
            url = proto + "//static." + host;
        var s = document.createElement('script');
        s.type = 'text/javascript';
        s.async = true;
        s.src = url + '/widget-send-button/js/init.js';
        s.onload = function() {
            WhWidgetSendButton.init(host, proto, options);
        };
        var x = document.getElementsByTagName('script')[0];
        x.parentNode.insertBefore(s, x);
    })();
</script>

<script type="text/javascript" language="javascript" src="<?= base_url('assets/'); ?>js/moment-with-locales.js"></script>
<script type="text/javascript" language="javascript" src="<?= base_url('assets/'); ?>js/bootstrap-datetimepicker.min.js"></script>
</div>
<!-- End of Main Content -->