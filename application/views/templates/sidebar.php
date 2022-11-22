<!-- Sidebar -->

<ul class="navbar-nav sidebar sidebar-dark accordion" style=" background: #1a4645 ;" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <?php if ($this->session->userdata('role_id') == 2 || $this->session->userdata('role_id') == 1) : ?>
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('user') ?>">
        <?php else : ?>
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('humanresource') ?>">
            <?php endif; ?>

            <div class="sidebar-brand-icon rotate-n-0 mt-4">
                <img src="<?=base_url('assets2/')?>/img/kota_mataram.png" class="rounded img-thumbnail img-responsive star" alt="BKPSDM Logo" width="200" height="200">
            </div>
                <div class="sidebar-brand-text mx-3 mt-4">Inspektorat</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider mt-4">
            <div class="">
                
            </div>

            <?php
            $role_id = $this->session->userdata('role_id');
            $queryMenu = "SELECT `user_menu`.`id`, `menu`
                    FROM `user_menu` JOIN `user_access_menu`
                    ON `user_menu`.`id` = `user_access_menu`.`menu_id`
                    WHERE `user_access_menu`.`role_id` = $role_id
                    ORDER BY `user_access_menu`.`menu_id` ASC
                    ";
            $menu = $this->db->query($queryMenu)->result_array();
            ?>

            <!-- Looping MENU -->
            <?php foreach ($menu as $m) : ?>
                <div class="sidebar-heading">
                    <?= $m['menu']; ?>
                </div>

                <!-- SIAPKAN SUB-MENU SESUAI MENU -->
                <?php
                $menuId = $m['id'];
                $querySubMenu = "SELECT *
                        FROM `user_sub_menu` JOIN `user_menu`
                        ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
                        WHERE `user_sub_menu`.`menu_id` = $menuId
                        AND `user_sub_menu`.`is_active` = 1
                        ";
                $subMenu = $this->db->query($querySubMenu)->result_array();
                ?>
                <?php foreach ($subMenu as $sm) : ?>
                    <?php if ($title == $sm['title']) : ?>
                        <li class="nav-item active">
                        <?php else : ?>
                        <li class="nav-item">
                        <?php endif; ?>
                        <a class="nav-link pb-0" href="<?= base_url($sm['url']); ?>">
                            <i class="<?= $sm['icon']; ?>"></i>
                            <span><?= $sm['title']; ?></span></a>
                        </li>
                    <?php endforeach; ?>
                    <!-- Divider -->
                    <hr class="sidebar-divider mt-3">
                <?php endforeach; ?>

                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('auth/logout'); ?>" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-fw fa-sign-out-alt"></i>
                        <span>Logout</span></a>
                </li>


                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">

                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center d-none d-md-inline">
                    <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>

</ul>
<!-- End of Sidebar -->