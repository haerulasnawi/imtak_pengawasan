<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-lg-12">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mt-4 mb-4" style="font-style:italic;"><strong>Survei Pelayanan Publik</strong></h1>
                    <nav aria-label="breadcrumb" class="ml-4 mr-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url('landingpage/') ?>" style="color:#1a4645;">Beranda</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Survei</li>
                        </ol>
                    </nav>
                </div>
                <div class="card-body p-0 ">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg">
                            <div class="p-4">

                                <!-- Flash data -->
                                <!-- <?php $this->view('message') ?>
                                <?= $this->session->flashdata('menus') ?> -->

                                <form class="form-horizontal" role="form" action="<?= base_url('Landingpage/survei'); ?>" method="post" enctype="multipart/form-data">
                                    <input type="hidden" id="id" name="id">

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail4">Nama</label>
                                            <input type="text" class="form-control" name="nama" placeholder="Nama" id="nama">
                                            <?= form_error('Nama', '<small class="text-danger pl-3">', '</small>'); ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputPassword4">Email</label>
                                            <input type="text" class="form-control" name="email" placeholder="Email" id="email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputAddress">Alamat</label>
                                        <input type="text" class="form-control" id="alamat" placeholder="Alamat">
                                        <?= form_error('Alamat', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="inputCity">Pekerjaan</label>
                                            <input type="text" class="form-control" name="pekerjaan" placeholder="Pekerjaan" id="pekerjaan">
                                            <?= form_error('Pekerjaan', '<small class="text-danger pl-3">', '</small>'); ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Bidang">Pilih Sekretariat/Bidang yang Ingin Dinilai</label>
                                            <select name="Bidang" id="Bidang" class="form-control">
                                                <option selected>Pilih...</option>
                                                <?php foreach ($databidang as $bid) : ?>
                                                    <option value="<?= $bid['id']; ?>"><?= $bid['nama_bidang']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?= form_error('Bidang', '<small class="text-danger pl-3">', '</small>'); ?>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn " style="background:#1a4645 ; width:100px; height:38px; color:ghostwhite;">Kirim</button>
                                </form>



                                <!-- <form class="user" method="post" action="<?= base_url('auth'); ?>">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="Enter Email Address..." value="<?= set_value('email'); ?>">
                                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                                        <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <button type="submit" class="btn btn-user btn-block text-white" style="background:#1a4645 ;">
                                        Login
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('auth/forgotpassword'); ?>" style="color:#1a4645 ; ">Forgot Password?</a>
                                </div> -->
                                <!-- <div class="text-center">
                                    <a class="small" href="<?= base_url('auth/registration'); ?>">Create an Account!</a>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
<script>
    $(document).ready(function() {
        $('.confirm-div').hide();
        <?php if ($this->session->flashdata('message')) { ?>
            $('.confirm-div').html('<?php echo $this->session->flashdata('message'); ?>').show();
        <?php } ?>
    });
</script>