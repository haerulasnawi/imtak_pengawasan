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
                                <div class="text-center mb-1">
                                    <img src="<?= base_url('assets/img/kota_mataram.png'); ?>" alt="BKPSDM Kota Mataram" width="80" height="100" class="img-responsive mb-1">
                                    <h1 class="h4 text-gray-900 mb-0"><strong>Inspektorat Kota Mataram</strong></h1>
                                    <!-- <h2 class="h4 text-gray-900 mb-4"><strong>Online Appointment System</strong></h2> -->
                                </div>
                                <!-- Flash data -->
                                <?php $this->view('message') ?>
                                <?= $this->session->flashdata('menus') ?>
                                <form class="user" method="post" action="<?= base_url('auth'); ?>">
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
                                </div>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('auth/createAccount'); ?>" style="color:#1a4645 ; ">Create an Account!</a>
                                </div>
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