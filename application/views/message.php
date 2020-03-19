<?php if ($this->session->has_userdata('message')) { ?>

  <div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
        <h4><i class="icon fa fa-check"> Alert</h4></i>
            <?=$this->session->flashdata('message'); ?>
  </div>

<?php }  ?>
