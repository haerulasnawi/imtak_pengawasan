<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
  <p>Your profile info</p>
  <hr>

  <div class="row">
    <div class="col-lg-5">
      <?= $this->session->flashdata('menus') ?>
    </div>

  </div>

  <div class="row">
    <?php
    $ygini = $this->db->get_where('request_task', ['email' => $useremail = $this->session->userdata('email')])->num_rows();

    $this->db->select_sum('job_value');
    $query = $this->db->get_where('user_invoice', ['email_freelance' => $useremailfr = $this->session->userdata('email'), 'status' => 'invoiced']);

    $total = 0;
    foreach ($query->result_array() as $row) {
      $total += $row['job_value'];
    }

    $querykuuser = $this->db->query("SELECT * FROM `request_task` WHERE `status` NOT LIKE '%denied%' AND `status` NOT LIKE '%Invoiced%' AND `email`= '$useremail'");
    $donetaskuser = $querykuuser->num_rows();

    $querypending = $this->db->query("SELECT * FROM `request_task` WHERE `status` LIKE '%pending%' AND `email`= '$useremail'");
    $donetaskuserpending = $querypending->num_rows();


    ?>
    <div class="col-xl-3 col-md-6 mb-2 mt-2">
      <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Tasks gained</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $ygini; ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-tasks fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-2 mt-2">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Uninvoice Tasks</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $donetaskuser; ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-list-ul fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-2 mt-2">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pending Tasks</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $donetaskuserpending ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-spinner fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-2 mt-2">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Earnings (Overall)</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">$<?= $total ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <div class="row">
    <div class="col ml-0 mr-0 mt-2 mb-5">
      <div class="card shadow p-2" style="max-width: 400px; ">
        <div class="row no-gutters">
          <div class="row-md">
            <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="card-img-top rounded">
          </div>
          <div class="col-md-10">
            <div class="card-body">
              <h5 class="card-title"><?= $user['name']; ?></h5>
              <p class="card-text mb-0"><?= $user['email']; ?></p>
              <p class="card-text"><small class="text-muted">Member since <?= date('d F Y', $user['date_created']) ?></small></p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col">

      <!-- Illustrations -->
      <div class="card shadow mb-4 ml-4 mt-2" style="width: 450px;">
        <a href="#collapseCardExample" class="card-header" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
          <h6 class="m-0 font-weight-bold text-primary">Intermezzo</h6>
        </a>
        <div class="collapse show" id="collapseCardExample">
          <div class="card-body">
            <div class="text-center">
              <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="<?= base_url('assets/') ?>img/undrawsvg.svg" alt="">
            </div>
            <p>Don't forget to take a break while tired of working, to keep your productivity well maintained and produce maximum work!</p>
            <a target="_blank" rel="nofollow" href="https://youtube.com/">Browse your favorite content on youtube →</a>
          </div>
        </div>
      </div>
    </div>
    <div class="col">

      <!-- Illustrations -->
      <div class="card shadow mb-4 ml-4 mt-2" style="width: 450px;">
        <a href="#collapseCardExample" class="card-header" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
          <h6 class="m-0 font-weight-bold text-primary">Intermezzo</h6>
        </a>
        <div class="collapse show" id="collapseCardExample">
          <div class="card-body">
            <div class="text-center">
              <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="<?= base_url('assets/') ?>img/undrawsvg.svg" alt="">
            </div>
            <p>Don't forget to take a break while tired of working, to keep your productivity well maintained and produce maximum work!</p>
            <a target="_blank" rel="nofollow" href="https://youtube.com/">Browse your favorite content on youtube →</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->