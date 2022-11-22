<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
  <p>Your profile info</p>
  <hr>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/locale/id.min.js"></script>
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script> -->
  <script src="<?= base_url('assets/'); ?>js/fullcalendar.min.js"></script>

  <div class="row">
    <div class="col-lg-5">
      <?= $this->session->flashdata('menus') ?>
    </div>

  </div>

  <div class="row">
    <?php
    $ygini = $this->db->get_where('event', ['email' => $useremail = $this->session->userdata('email')])->num_rows();

    $this->db->select_sum('job_value');
    $query = $this->db->get_where('user_invoice', ['email_freelance' => $useremailfr = $this->session->userdata('email'), 'status' => 'invoiced']);

    $total = 0;
    foreach ($query->result_array() as $row) {
      $total += $row['job_value'];
    }

    $querykuuser = $this->db->query("SELECT * FROM `event` WHERE `status` LIKE '%disetujui%' AND `email`= '$useremail'");
    $donetaskuser = $querykuuser->num_rows();

    $querypending = $this->db->query("SELECT * FROM `event` WHERE `status` LIKE '%diajukan%' AND `email`= '$useremail'");
    $donetaskuserpending = $querypending->num_rows();


    ?>
    <div class="col-xl-4 col-md-6 mb-2 mt-2">
      <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Coaching Agenda</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $ygini; ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-tasks fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-2 mt-2">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Coaching Selesai</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $donetaskuser; ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-list-ul fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-2 mt-2">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Coaching Tertunda</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $donetaskuserpending ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-spinner fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- <div class="col-xl-3 col-md-6 mb-2 mt-2">
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
    </div> -->

  </div>
  <div class="row">
    <div class="col ml-0 mt-2 mb-4">
      <div class="card shadow p-2" style="max-width: 450px; ">
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
    <div class="col ml-0 mt-2 mb-4">
      <?php $taskremaining = $this->db->get_where('request_task', ['email' => $useremail = $this->session->userdata('email'), 'status' => 'accepted'])->num_rows(); ?>
      <!-- Illustrations -->
      <div class="card shadow card-calendar" style="width: 800px; height: 660px;">
        <div class="card-body mb-2">
          <div class="calendar" data-bs-toggle="calendar" id="calendar"></div>
        </div>
      </div>
      <!-- <?php if ($taskremaining != 0) { ?>
            <div class="card-body">
              <div class="text-center">
                <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="<?= base_url('assets/') ?>img/undrawsvg.svg" alt="">
              </div>
              <p>You still have <?= $taskremaining ?> tasks that have not been done!</p>
              <a target="_blank" rel="nofollow" href="<?= base_url('user/curtask'); ?>">Finish now →</a>
            <?php } else { ?>
              <div class="card-body">
                <div class="text-center">
                  <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 21rem;" src="<?= base_url('assets/') ?>img/swing.svg" alt="">
                </div>
                <p>You have no task left! Enjoy your free time</p>
                <a target="_blank" rel="nofollow" href="<?= base_url('auth/logout'); ?>">Logout →</a>
              <?php } ?>

              </div>
            </div> -->
      <!-- <div class="col"> -->

      <!-- Illustrations -->
      <!-- <div class="card shadow mb-4 ml-0 mt-2" style="width: 400px;">
          <a href="#collapseCardExample2" class="card-header" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample2">
            <h6 class="m-0 font-weight-bold" style="color:#a80231;">Intermezzo</h6>
          </a>
          <div class="collapse show" id="collapseCardExample2">
            <div class="card-body">
              <div class="text-center">
                <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 15.7rem;" src="<?= base_url('assets/') ?>img/vidyt.svg" alt="">
              </div>
              <p>Don't forget to take a break while tired of working, to keep your productivity well maintained and produce maximum work!</p>
              <a target="_blank" rel="nofollow" href="https://youtube.com/">Browse your favorite content on youtube →</a>
            </div>
          </div>
        </div>
      </div> -->
    </div>
  </div>
  <!-- /.container-fluid -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');

      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 620,
        // events: "<?php echo base_url(); ?>fullcalendar/load",

      });

      calendar.render();
    });
  </script>
  <script type="text/javascript">
    (function() {
      var options = {
        email: "inspektoratkotamataram@gmail.com", // Email
        call: " 0370645092", // Sms phone number
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

</div>
<!-- End of Main Content -->