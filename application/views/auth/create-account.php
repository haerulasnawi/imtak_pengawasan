    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-lg-7">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Buat Akun Coaching Clinic!</h1>
                                    </div>
                                    <!-- Flash data -->
                                    <?php $this->view('message') ?>
                                    <?= $this->session->flashdata('menus') ?>
                                    <form class="user" method="post" action="<?= base_url('auth/createaccount'); ?>">
                                        <input type="hidden" id="id" name="id">
                                        <input type="hidden" id="date_created" name="date_created">
                                        <input type="hidden" id="role_id" name="role_id">
                                        <input type="hidden" id="image" name="image">
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="text" class="form-control form-control-user" id="name" name="name" placeholder="Nama Lengkap" value="<?= set_value('name'); ?>">
                                                <?= form_error('nama_lengkap', '<small class="text-danger pl-3">', '</small>'); ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="number" class="form-control form-control-user" id="nip" name="nip" placeholder="NIP" value="<?= set_value('nip'); ?>">
                                                <?= form_error('nip', '<small class="text-danger pl-3">', '</small>'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="text" class="form-control form-control-user" id="unit_kerja" name="unit_kerja" placeholder="Unit Kerja" value="<?= set_value('unit_kerja'); ?>">
                                                <?= form_error('unit_kerja', '<small class="text-danger pl-3">', '</small>'); ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="number" class="form-control form-control-user" id="no_hp" name="no_hp" placeholder="No. Handphone" value="<?= set_value('no_hp'); ?>">
                                                <?= form_error('no_hp', '<small class="text-danger pl-3">', '</small>'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="Alamat Email" value="<?= set_value('email'); ?>">
                                            <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                                                <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="password" class="form-control form-control-user" id="re_password" name="re_password" placeholder="Repeat Password">
                                                <?= form_error('re_password', '<small class="text-danger pl-3">', '</small>'); ?>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Register Account
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="<?= base_url('auth/forgotpassword'); ?>">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="<?= base_url('auth'); ?>">Already have an account? Login!</a>
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