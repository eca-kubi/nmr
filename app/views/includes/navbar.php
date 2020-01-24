<?php $current_user = getUserSession(); ?>
<header>
    <div class="navbar-fixed fixed-top blockable">
        <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom px-3">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#">
                        <i class="fa fa-bars"></i>
                    </a>
                </li>
            </ul>

            <span class="mx-auto text-bold animated flash slower infinite"><?php echo isSubmissionOpened()? '<p class="text-success"><i class="fa fa-info-circle"></i> Flash Report Submission is Opened</p>' : '<p class="text-danger "><i class="fa fa-info-circle"></i> Flash Report Submission is Closed</p>'  ?></span>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown d-none">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fa fa-comments-o"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="" alt="User ..." class="img-size-50 mr-3 img-circle"/>
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Brad Diesel
                                        <span class="float-right text-sm text-danger">
                                        <i class="fa fa-star"></i>
                                    </span>
                                    </h3>
                                    <p class="text-sm">Call me whenever you can...</p>
                                    <p class="text-sm text-muted">
                                        <i class="fa fa-clock-o mr-1"></i> 4 Hours Ago
                                    </p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="" alt="User ..." class="img-size-50 img-circle mr-3"/>
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        John Pierce
                                        <span class="float-right text-sm text-muted">
                                        <i class="fa fa-star"></i>
                                    </span>
                                    </h3>
                                    <p class="text-sm">I got your message bro</p>
                                    <p class="text-sm text-muted">
                                        <i class="fa fa-clock-o mr-1"></i> 4 Hours Ago
                                    </p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="" alt="User ..." class="img-size-50 img-circle mr-3"/>
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Nora Silvester
                                        <span class="float-right text-sm text-warning">
                                        <i class="fa fa-star"></i>
                                    </span>
                                    </h3>
                                    <p class="text-sm">The subject goes here</p>
                                    <p class="text-sm text-muted">
                                        <i class="fa fa-clock-o mr-1"></i> 4 Hours Ago
                                    </p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                    </div>
                </li>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php
                        $user = getUserSession();
                        $initials = $user->first_name[0] . $user->last_name[0];
                        if ($user->profile_pic === DEFAULT_PROFILE_PIC) {
                            $name = $user->first_name . ' ' . $user->last_name;
                            $src = PROFILE_PIC_DIR . $user->profile_pic . '?' . microtime(); ?>
                            <img alt="<?php echo $initials ?>"
                                 class="user-image img-size-32 img-fluid img-circle d-inline-block"
                                 avatar="<?php echo $name; ?>">
                        <?php } else { ?>
                            <img src="<?php echo PROFILE_PIC_DIR . $user->profile_pic . '?' . microtime(); ?>"
                                 class="user-image img-size-32 img-fluid img-circle d-inline-block"
                                 alt="<?php echo $initials; ?>" /><?php } ?>
                        <span class="hidden-xs text-capitalize">
                        <?php echo ucwords($user->first_name . ' ' . $user->last_name); ?>
                    </span>
                    </a>
                    <ul class="dropdown-menu m-0 p-1 dropdown-menu-right" style="min-width: 19rem">
                        <!-- User image -->
                        <li class="user-header"></li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="col p-2">
                                <?php
                                if ($user->profile_pic === DEFAULT_PROFILE_PIC) {
                                    $initials = $user->first_name[0] . $user->last_name[0];
                                    $name = $user->first_name . ' ' . $user->last_name; ?>
                                    <img alt="<?php echo $initials ?>"
                                         class="user-image img-size-32 img-fluid img-circle d-inline-block"
                                         avatar="<?php echo $name; ?>">
                                <?php } else { ?>
                                    <img src="<?php echo PROFILE_PIC_DIR . $user->profile_pic . '?' . microtime(); ?>"
                                         class="user-image img-size-32 img-fluid img-circle d-inline-block"
                                         alt="<?php echo $initials; ?>" /><?php } ?>
                                <p class="text-bold mb-1">
                                    <?php echo ucwords($user->first_name . ' ' . $user->last_name, ' -'); ?>
                                </p>
                                <p class="text-bold mb-1 text-sm">
                                    <?php echo ucwords($user->job_title, '- '); ?>
                                </p>
                                <p class="text-nowrap text-muted d-none">
                                    Member since ...
                                </p>
                            </div>
                            <!-- /.row -->
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer glyphicon-arrow-down row px-2">
                            <div class="pull-left col">
                                <a href="<?php echo site_url('users/profile'); ?>"
                                   class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?php echo site_url('users/logout'); ?>" class="btn btn-default btn-flat">Sign
                                    out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <nav class="d-md-block navbar navbar-light bg-navy text-white flex-nowrap flex-row" id="navbar2"
             style="z-index: 0">
            <div class="container-fluid">
                <ul class="navbar-nav flex-row float-left">
                    <li class="nav-item d-none">
                        <a href="#" class="btn btn-default btn-lg w3-hover-text-grey btn-sm">
                            <i class="fa fa-angle-double-left  mr-1"></i>Go Back
                        </a>
                    </li>
                    <li class="nav-item ml-0 ml-sm-4 text-left pr-1 border-right border-white">
                        <a href="<?php echo site_url('pages/dashboard'); ?>"
                           class="ajax-link nav-link btn border-0 text-bold flat text-left font-raleway nav-item-white w3-text-hover-amber">
                            <i class="fa  fa-dashboard ml-4"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item dropdown  mx-2">
                        <a class="nav-link dropdown-item w3-text-hover-amber dropdown-toggle btn border-0 text-bold flat nav-item-white"
                           data-toggle="dropdown">
                            <i class="fa fa-file"></i>
                            Reports
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownId"
                            style="position:absolute">
                            <li><a class="dropdown-item"
                                   href="<?php echo site_url('pages/draft-reports') ?>"><i>
                                        <svg class="fontastic-draft"
                                             style="fill: currentColor; height: 14px; width: 14px">
                                            <use
                                                    xlink:href="<?php echo ICON_PATH . '#fontastic-draft' ?>"></use>
                                        </svg>
                                    </i> Draft Report</a>
                            </li>
                            <li><a class="dropdown-item"
                                   href="<?php echo site_url('pages/my-reports/') ?>"><i
                                            class="fa fa-file-user"></i> My Reports</a>
                            </li>
                            <li><a class="dropdown-item"
                                   href="<?php echo site_url('pages/submitted-reports/') ?>"><i
                                            class="fa fa-check-double"></i> Submitted Reports</a>
                            </li>
                        </ul>
                    </li>
                    <?php if (isITAdmin($current_user->user_id)): ?>
                        <li class="nav-item dropdown  mx-2">
                            <a class="nav-link dropdown-item w3-text-hover-amber dropdown-toggle btn border-0 text-bold flat nav-item-white"
                               data-toggle="dropdown">
                                <i class="fab fa-hackerrank"></i>
                                IT Admin
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownId"
                                style="position:absolute">
                                <li><a class="dropdown-item"
                                       href="<?php echo site_url('pages/new-draft') ?>"><i>
                                            <svg class="fontastic-draft"
                                                 style="fill: currentColor; height: 14px; width: 14px">
                                                <use
                                                        xlink:href="<?php echo ICON_PATH . '#fontastic-draft' ?>"></use>
                                            </svg>
                                        </i> New Draft Report</a>
                                </li>
                                <li><a class="dropdown-item"
                                       href="<?php echo site_url('pages/preloaded-draft-reports') ?>"><i>
                                            <svg class="fontastic-draft"
                                                 style="fill: currentColor; height: 14px; width: 14px">
                                                <use
                                                        xlink:href="<?php echo ICON_PATH . '#fontastic-draft' ?>"></use>
                                            </svg>
                                        </i> Preloaded Draft Reports</a>
                                </li>
                            </ul>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
        </nav>
    </div>
</header>

