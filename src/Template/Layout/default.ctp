<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Welcome To | <?= SITE_NAME?> <?= SITE_NAME_LONG?></title>
    <!-- Favicon-->
    <link rel="icon" href="<?= SITE_NAME?>/img/favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?=SITE_URL?>/bsb/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?=SITE_URL?>/bsb/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?=SITE_URL?>/bsb/plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?=SITE_URL?>/bsb/css/style.css" rel="stylesheet">

    <!-- Wait Me Css -->
    <link href="<?=SITE_URL?>/bsb/plugins/waitme/waitMe.css" rel="stylesheet" />

    <!-- Bootstrap Select Css -->
    <link href="<?=SITE_URL?>/bsb/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

     <!-- Custom Css -->
    <link href="<?=SITE_URL?>/bsb/css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?=SITE_URL?>/bsb/css/themes/all-themes.css" rel="stylesheet" />

    <!-- Bootstrap Select Css -->
    <link href="<?=SITE_URL?>/bsb/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />


</head>
<?php if($this->request->session()->read('Auth.User')) { ?>
<?php
    $role = $this->request->session()->read('Auth.User.role');
    $email = $this->request->session()->read('Auth.User.email');
    $img = SITE_URL . USER_IMAGE_PATH . (($this->request->session()->read('Auth.User.image') == '') ? 'default-user.png' : $this->request->session()->read('Auth.User.image'));
?>
<body class="theme-blue">
    <style type="text/css">
        /*admin*/
        .sidebar .admin-info {
            padding: 13px 15px 12px 15px;
            white-space: nowrap;
            position: relative;
            border-bottom: 1px solid #e9e9e9;
            background: url("<?= SITE_URL?>/img/admin-background.jpeg") no-repeat no-repeat;
            height: 135px;
        }
        .sidebar .admin-info .image {
            margin-right: 12px;
            display: inline-block;
        }
        .sidebar .admin-info .image img {
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            -ms-border-radius: 50%;
            border-radius: 50%;
            vertical-align: bottom !important;
        }
        .sidebar .admin-info .info-container {
            cursor: default;
            display: block;
            position: relative;
            top: 25px;
        }
        .sidebar .admin-info .info-container .name {
            white-space: nowrap;
            -ms-text-overflow: ellipsis;
            -o-text-overflow: ellipsis;
            text-overflow: ellipsis;
            overflow: hidden;
            font-size: 14px;
            max-width: 200px;
            color: #fff;
        }
        .sidebar .admin-info .info-container .email {
            white-space: nowrap;
            -ms-text-overflow: ellipsis;
            -o-text-overflow: ellipsis;
            text-overflow: ellipsis;
            overflow: hidden;
            font-size: 12px;
            max-width: 200px;
            color: #fff;
        }
        .sidebar .admin-info .info-container .user-helper-dropdown {
            position: absolute;
            right: -3px;
            bottom: -12px;
            -webkit-box-shadow: none;
            -moz-box-shadow: none;
            -ms-box-shadow: none;
            box-shadow: none;
            cursor: pointer;
            color: #fff;
        }

        /*teacher*/
        .sidebar .teacher-info {
            padding: 13px 15px 12px 15px;
            white-space: nowrap;
            position: relative;
            border-bottom: 1px solid #e9e9e9;
            background: url("<?= SITE_URL?>/img/teacher-background.jpeg") no-repeat no-repeat;
            height: 135px;
        }
        .sidebar .teacher-info .image {
            margin-right: 12px;
            display: inline-block;
        }
        .sidebar .teacher-info .image img {
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            -ms-border-radius: 50%;
            border-radius: 50%;
            vertical-align: bottom !important;
        }
        .sidebar .teacher-info .info-container {
            cursor: default;
            display: block;
            position: relative;
            top: 25px;
        }
        .sidebar .teacher-info .info-container .name {
            white-space: nowrap;
            -ms-text-overflow: ellipsis;
            -o-text-overflow: ellipsis;
            text-overflow: ellipsis;
            overflow: hidden;
            font-size: 14px;
            max-width: 200px;
            color: #fff;
        }
        .sidebar .teacher-info .info-container .email {
            white-space: nowrap;
            -ms-text-overflow: ellipsis;
            -o-text-overflow: ellipsis;
            text-overflow: ellipsis;
            overflow: hidden;
            font-size: 12px;
            max-width: 200px;
            color: #fff;
        }
        .sidebar .teacher-info .info-container .user-helper-dropdown {
            position: absolute;
            right: -3px;
            bottom: -12px;
            -webkit-box-shadow: none;
            -moz-box-shadow: none;
            -ms-box-shadow: none;
            box-shadow: none;
            cursor: pointer;
            color: #fff;
        }

        /*student*/
        .sidebar .student-info {
            padding: 13px 15px 12px 15px;
            white-space: nowrap;
            position: relative;
            border-bottom: 1px solid #e9e9e9;
            background: url("<?= SITE_URL?>/img/student-background.jpeg") no-repeat no-repeat;
            height: 135px;
        }
        .sidebar .student-info .image {
            margin-right: 12px;
            display: inline-block;
        }
        .sidebar .student-info .image img {
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            -ms-border-radius: 50%;
            border-radius: 50%;
            vertical-align: bottom !important;
        }
        .sidebar .student-info .info-container {
            cursor: default;
            display: block;
            position: relative;
            top: 25px;
        }
        .sidebar .student-info .info-container .name {
            white-space: nowrap;
            -ms-text-overflow: ellipsis;
            -o-text-overflow: ellipsis;
            text-overflow: ellipsis;
            overflow: hidden;
            font-size: 14px;
            max-width: 200px;
            color: #fff;
        }
        .sidebar .student-info .info-container .email {
            white-space: nowrap;
            -ms-text-overflow: ellipsis;
            -o-text-overflow: ellipsis;
            text-overflow: ellipsis;
            overflow: hidden;
            font-size: 12px;
            max-width: 200px;
            color: #fff;
        }
        .sidebar .student-info .info-container .user-helper-dropdown {
            position: absolute;
            right: -3px;
            bottom: -12px;
            -webkit-box-shadow: none;
            -moz-box-shadow: none;
            -ms-box-shadow: none;
            box-shadow: none;
            cursor: pointer;
            color: #fff;
        }
    </style>
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->

    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->

    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="<?= ($role == 1) ? 'admin-info' : (($role == 2) ? 'teacher-info' : 'student-info')?>">
                <div class="image">
                    <img src="<?= $img?>" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="email"><?= $email?></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="<?= SITE_URL . DS . 'users' . DS . 'edit' . DS . $this->request->session()->read('Auth.User.id') ?>"><i class="material-icons">person</i>Profile</a></li>
                            <li><a href="<?= SITE_URL . DS . 'logout' ?>"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list" >

                    <?php if($role == 1) {?>
                        <li class=<?= $this->fetch('title') == 'users' ? 'active' : '';?>>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">account_box</i>
                                <span>Users</span>
                            </a>
                            <ul class="ml-menu">
                                <li class="<?= (($this->fetch('title') == 'users') && (in_array($this->request->params['action'], ['index', 'edit']))) ? 'active' : '';?>">
                                    <a href="<?= SITE_URL ?>/users/">List</a>
                                </li>
                                <li class=" <?= (($this->fetch('title') == 'users') && ($this->request->params['action'] == 'add')) ? 'active' : '';?>">
                                    <a href="<?= SITE_URL ?>/users/add/">Add</a>
                                </li>
                            </ul>
                        </li>

                        <li class=<?= $this->fetch('title') == 'departments' ? 'active' : '';?>>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">dns</i>
                                <span>Departments</span>
                            </a>
                            <ul class="ml-menu">
                                <li class="<?= (($this->fetch('title') == 'departments') && in_array($this->request->params['action'], ['index', 'edit'])) ? 'active' : '';?>">
                                    <a href="<?= SITE_URL ?>/departments/">List</a>
                                </li>
                                <li class=" <?= (($this->fetch('title') == 'departments') && ($this->request->params['action'] == 'add')) ? 'active' : '';?>">
                                    <a href="<?= SITE_URL ?>/departments/add/">Add</a>
                                </li>
                            </ul>
                        </li>

                        <li class=<?= $this->fetch('title') == 'yearlevels' ? 'active' : '';?> >
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">assessment</i>
                                <span>Year Levels</span>
                            </a>
                            <ul class="ml-menu">
                                <li class="<?= (($this->fetch('title') == 'yearlevels') && (in_array($this->request->params['action'], ['index', 'edit']))) ? 'active' : '';?>">
                                    <a href="<?= SITE_URL ?>/yearlevels/">List</a>
                                </li>
                                <li class=" <?= (($this->fetch('title') == 'yearlevels') && ($this->request->params['action'] == 'add')) ? 'active' : '';?>">
                                    <a href="<?= SITE_URL ?>/yearlevels/add/">Add</a>
                                </li>
                            </ul>
                        </li>

                        <li class=<?= $this->fetch('title') == 'sections' ? 'active' : '';?> >
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">aspect_ratio</i>
                                <span>Sections</span>
                            </a>
                            <ul class="ml-menu">
                                <li class="<?= (($this->fetch('title') == 'sections') && (in_array($this->request->params['action'], ['index', 'edit']))) ? 'active' : '';?>">
                                    <a href="<?= SITE_URL ?>/sections/">List</a>
                                </li>
                                <li class=" <?= (($this->fetch('title') == 'sections') && ($this->request->params['action'] == 'add')) ? 'active' : '';?>">
                                    <a href="<?= SITE_URL ?>/sections/add/">Add</a>
                                </li>
                            </ul>
                        </li>

                        <li class=<?= $this->fetch('title') == 'courses' ? 'active' : '';?>>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">assignment</i>
                                <span>Courses</span>
                            </a>
                            <ul class="ml-menu">
                                <li class="<?= (($this->fetch('title') == 'courses') && (in_array($this->request->params['action'], ['index', 'edit']))) ? 'active' : '';?>">
                                    <a href="<?= SITE_URL ?>/courses/">List</a>
                                </li>
                                <li class=" <?= (($this->fetch('title') == 'courses') && ($this->request->params['action'] == 'add')) ? 'active' : '';?>">
                                    <a href="<?= SITE_URL ?>/courses/add/">Add</a>
                                </li>
                            </ul>
                        </li>
                        <li class=<?= $this->fetch('title') == 'subjects' ? 'active' : '';?>>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">book</i>
                                <span>Subjects</span>
                            </a>
                            <ul class="ml-menu">
                                <li class="<?= (($this->fetch('title') == 'subjects') && (in_array($this->request->params['action'], ['index', 'edit']))) ? 'active' : '';?>">
                                    <a href="<?= SITE_URL ?>/subjects/">List</a>
                                </li>
                                <li class=" <?= (($this->fetch('title') == 'subjects') && ($this->request->params['action'] == 'add')) ? 'active' : '';?>">
                                    <a href="<?= SITE_URL ?>/subjects/add/">Add</a>
                                </li>
                            </ul>
                        </li>
                        <li class=<?= $this->fetch('title') == 'teachers' ? 'active' : '';?>>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">card_travel</i>
                                <span>Teachers</span>
                            </a>
                            <ul class="ml-menu">
                                <li class="<?= (($this->fetch('title') == 'teachers') && ($this->request->params['action'] == 'teachers')) ? 'active' : '';?>">
                                    <a href="<?= SITE_URL ?>/users/teachers">List</a>
                                </li>
                            </ul>
                        </li>



                        <?php if(false){ ?>

                        <?php }?>
                    <?php } else if($role == 2) { ?>
                        <li class=<?= $this->fetch('title') == 'lessons' ? 'active' : '';?>>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">library_books</i>
                                <span>Lessons</span>
                            </a>
                            <ul class="ml-menu">
                                <li class="<?= in_array($this->request->params['action'], ['index', 'edit']) ? 'active' : '';?>">
                                    <a href="<?= SITE_URL ?>/lessons/">List</a>
                                </li>
                                <li class=" <?= $this->request->params['action'] == 'upload' ? 'active' : '';?>">
                                    <a href="<?= SITE_URL ?>/lessons/upload/">Upload</a>
                                </li>
                            </ul>
                        </li>
                    <?php } else if($role == 3) { ?>
                        <li class=<?= $this->fetch('title') == 'lessons' ? 'active' : '';?>>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">library_books</i>
                                <span>Lessons</span>
                            </a>
                            <ul class="ml-menu">
                                <li class="<?= in_array($this->request->params['action'], ['download', 'edit']) ? 'active' : '';?>">
                                    <a href="<?= SITE_URL ?>/lessons/download">Download</a>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <?php if(false){ ?>
            <div class="legal">
                <div class="copyright">
                    &copy; 2016 - 2017 <a href="javascript:void(0);"><?= SITE_NAME ?> </a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.0
                </div>
            </div>
            <?php } ?>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
    </section>


    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="<?= SITE_URL?>"><?= SITE_NAME ?> </a>
            </div>
        </div>
    </nav>

    <!-- #Top Bar -->
    <section class="content">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </section>

</body>
<?php } else {?>
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
<?php } ?>


<!-- Jquery Core Js -->
<script src="<?=SITE_URL?>/bsb/plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap Core Js -->
<script src="<?=SITE_URL?>/bsb/plugins/bootstrap/js/bootstrap.js"></script>

<!-- Select Plugin Js -->
<script src="<?=SITE_URL?>/bsb/plugins/bootstrap-select/js/bootstrap-select.js"></script>

<!-- Slimscroll Plugin Js -->
<script src="<?=SITE_URL?>/bsb/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

<!-- Waves Effect Plugin Js -->
<script src="<?=SITE_URL?>/bsb/plugins/node-waves/waves.js"></script>

<!-- Jquery CountTo Plugin Js -->
<script src="<?=SITE_URL?>/bsb/plugins/jquery-countto/jquery.countTo.js"></script>

<!-- Morris Plugin Js -->
<script src="<?=SITE_URL?>/bsb/plugins/raphael/raphael.min.js"></script>
<script src="<?=SITE_URL?>/bsb/plugins/morrisjs/morris.js"></script>

<!-- ChartJs -->
<script src="<?=SITE_URL?>/bsb/plugins/chartjs/Chart.bundle.js"></script>

<!-- Flot Charts Plugin Js -->
<script src="<?=SITE_URL?>/bsb/plugins/flot-charts/jquery.flot.js"></script>
<script src="<?=SITE_URL?>/bsb/plugins/flot-charts/jquery.flot.resize.js"></script>
<script src="<?=SITE_URL?>/bsb/plugins/flot-charts/jquery.flot.pie.js"></script>
<script src="<?=SITE_URL?>/bsb/plugins/flot-charts/jquery.flot.categories.js"></script>
<script src="<?=SITE_URL?>/bsb/plugins/flot-charts/jquery.flot.time.js"></script>

<!-- Waves Effect Plugin Js -->
<script src="<?=SITE_URL?>/bsb/plugins/node-waves/waves.js"></script>

<!-- Sparkline Chart Plugin Js -->
<script src="<?=SITE_URL?>/bsb/plugins/jquery-sparkline/jquery.sparkline.js"></script>

<!-- Bootstrap Notify Plugin Js -->
<script src="<?=SITE_URL?>/bsb/plugins/bootstrap-notify/bootstrap-notify.js"></script>

<!-- Validation Plugin Js -->
<script src="<?=SITE_URL?>/bsb/plugins/jquery-validation/jquery.validate.js"></script>

<!-- Demo Js -->
<script src="<?=SITE_URL?>/bsb/js/demo.js"></script>

<!-- Custom Js -->
<script src="<?=SITE_URL?>/bsb/js/admin.js"></script>
<?= $this->Html->script('notify.js');?>

<script type="text/javascript">
    // console.log('$.notify');
    // $(function () {

        var cakephp_msg = $('div.message');//

        $(cakephp_msg).each(function(){

            var msgs = $(this).text();
            var type = $(this).hasClass('success') ? 'bg-black' : 'bg-red';

            console.log(msgs);

            $(this).remove();
            try{
                showMessage(msgs, type);
            } catch (e){

            }

        });
    // });
</script>

</html>
