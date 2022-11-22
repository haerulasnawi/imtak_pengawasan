<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    <p>You can edit profile here</p>
    <hr class="mb-4">
    <?= $this->session->flashdata('menus'); ?>
    <?php if (validation_errors()) : ?>
        <div class="alert alert-danger" role="alert">
            <?= validation_errors(); ?>
        </div>

    <?php endif; ?>

    <div class="row">
        <div class="col-lg-8">
            <?= form_open_multipart('humanresource/edit'); ?>
            <input type="hidden" id="id" name="id" value="<?= $user['id']; ?>">
            <input type="hidden" id="date_created" name="date_created" value="<?= $user['date_created']; ?>">
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="name" name="name" placeholder="Nama Lengkap" value="<?= $user['name']; ?>">
                    <?= form_error('nama_lengkap', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="col-sm-6">
                    <input type="number" class="form-control form-control-user" id="nip" name="nip" placeholder="NIP" value="<?= $user['nip']; ?>">
                    <?= form_error('nip', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="unit_kerja" name="unit_kerja" placeholder="Unit Kerja" value="<?= $user['unit_kerja']; ?>">
                    <?= form_error('unit_kerja', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="col-sm-6">
                    <input type="number" class="form-control form-control-user" id="no_hp" name="no_hp" placeholder="No. Handphone" value="<?= $user['no_hp']; ?>">
                    <?= form_error('no_hp', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
            </div>
            <div class="form-group">
                <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="Alamat Email" value="<?= $user['email']; ?>">
                <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>
            <div class="form-group row">
                <div class="col-sm-1">
                    Picture
                </div>
                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-sm-3">
                            <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="img-thumbnail">
                        </div>
                        <div class="col-sm-9">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image">
                                <label class="custom-file-label" for="image">Choose file (max size 3MB)</label>
                                <?= form_error('image', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row justify-content-end">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </div>
        </div>
        </form>
    </div>

</div>
<!-- /.container-fluid -->


</div>
<!-- End of Main Content -->