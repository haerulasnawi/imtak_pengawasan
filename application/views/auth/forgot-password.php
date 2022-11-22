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
                                    <h1 class="h4 text-gray-900 mb-4"><strong>Forgot your password ?</strong></h1>
                                </div>
                                <!-- Flash data -->
                                <?php $this->view('message') ?>
                                <?= $this->session->flashdata('menus') ?>
                                <form class="user" method="post" action="<?= base_url('auth/forgotpassword'); ?>">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="Enter Email Address..." value="<?= set_value('email'); ?>">
                                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>

                                    <button type="submit" class="btn btn-user btn-block text-white" style=" background: #1a4645 ;">
                                        Reset Password
                                    </button>
                                </form>
                                <hr>

                                <div class="text-center">
                                    <a class="small" href="<?= base_url('auth'); ?>" style=" color:#1a4645 ;">Back to login</a>
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