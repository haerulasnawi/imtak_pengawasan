<?php if ($this->session->has_userdata('message')) { ?>

  <div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <?= $this->session->flashdata('message'); ?>
  </div>
<?php }  ?>
<?php if ($this->session->has_userdata('wrong')) { ?>

  <div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <?= $this->session->flashdata('wrong'); ?>
  </div>
<?php }  ?>
<?php if ($this->session->has_userdata('activated')) { ?>

  <div class="alert alert-warning alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <?= $this->session->flashdata('activated'); ?>
  </div>
<?php }  ?>
<?php if ($this->session->has_userdata('registered')) { ?>

  <div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <?= $this->session->flashdata('registered'); ?>
  </div>
<?php }  ?>
<?php if ($this->session->has_userdata('logout')) { ?>

  <div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
    <?= $this->session->flashdata('logout'); ?>
  </div>
<?php }  ?>