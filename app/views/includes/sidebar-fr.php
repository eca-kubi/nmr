<!-- Main Sidebar Container -->
<aside class="fa main-sidebar sidebar-dark-primary elevation-4 blockable" style="left:-1px">
    <!-- Brand Logo -->
    <a href="<?php echo site_url(); ?>" class="brand-link">
        <img src="<?php echo site_url('public/assets/images/adamus.jpg'); ?>" alt="logo"
             class="brand-image  ml-0  elevation-3" style="opacity: .8"/>
        <span class="brand-text font-weight-light"><?php echo APP_NAME; ?></span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <?php
                $user = getUserSession();
                if ($user->profile_pic == DEFAULT_PROFILE_PIC) {
                    $src = PROFILE_PIC_DIR . $user->profile_pic . '?' . microtime();
                    $name = $user->first_name . ' ' . $user->last_name;
                    echo "<img alt='<?php echo $name ?>' src=\"$src\" class=\"elevation-2 img-circle p-1 img-size-32\" avatar=\"$name\" >";
                } else { ?>
                    <img src="<?php echo PROFILE_PIC_DIR . $user->profile_pic; ?>"
                         class="elevation-2 img-circle  img-size-32" alt="avatar"/>
                <?php } ?>
            </div>
            <div class="info font-poppins" style="font-size: 13px;">
                <a href="<?php echo site_url('users/profile'); ?>" class="d-block">
                    <?php echo ucwords($user->first_name . ' ' . $user->last_name, ' -'); ?>
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="<?php echo site_url('pages/dashboard') ?>" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-file"></i>
                        <p>
                           Forms
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-circle-notch animated rotateIn"></i>
                                <p>
                                    Finance
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?php echo site_url('salary-advance'); ?>" class="nav-link">
                                        <i class="nav-icon fas fa-circle-notch animated rotateIn invisible"></i>
                                        <p>
                                            Salary Advance
                                        </p>
                                    </a>

                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-circle-notch animated rotateIn"></i>
                                <p>IT</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-circle-notch animated rotateIn nav-icon"></i>
                                <p>HR</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-circle-notch animated rotateIn nav-icon"></i>
                                <p>Admin</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-circle-notch animated rotateIn nav-icon"></i>
                                <p>Mining</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>