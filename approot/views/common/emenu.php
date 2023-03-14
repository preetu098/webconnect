<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="robots" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="format-detection" content="telephone=no">
    <title>Employee</title>
    <link rel="shortcut icon" type="image/png" href="images/favicon.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <link href="<?= base_url('external/'); ?>vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="<?= base_url('external/'); ?>vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link href="<?= base_url('external/'); ?>vendor/owl-carousel/owl.carousel.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('external/'); ?>vendor/nouislider/nouislider.min.css">
    <link href="<?= base_url('external/'); ?>css/style.css" rel="stylesheet">
    <link href="<?= base_url('external/'); ?>css/checkBox/checkbox.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/6210356d25.js"></script>
    <style type="text/css">
        .DZ-bt-support-now.DZ-theme-btn {
            display: none !important;
        }

        .DZ-bt-buy-now.DZ-theme-btn {
            display: none !important;
        }
    </style>
    <style>
        .img-responsive {
            max-width: 100%;
        }

        .bxhead-tp {
            padding-top: 100px;
        }

        .bxhead-tp h2 {
            font-size: 34px;
            font-weight: 600;
            color: #4a457d;
        }

        .bxhead-tp p {
            font-size: 18px;
            color: #222;
            text-align: justify;
        }

        .bxhead-tp a {
            border: 1px solid #09bd3c;
            color: #09bd3c;
            padding: 8px 15px;
            font-size: 16px;
        }

        .bxhead-tp a:hover {
            border: 1px solid #4a457d;
            color: #4a457d;
        }

        .crd-detl:hover {
            background: #6f4bb9;
            color: #fff !important;
            border: solid 2px #422088;
        }


        .plcy-card {
            background: #ffffff;
            border-radius: 15px 15px 0px 0px;
            padding: 15px;
            border: solid 1px #f3912e;
        }

        .plcy-card-text {
            border-radius: 15px 15px 15px 15px;
            background-color: #cccccc14;
        }

        .plcy-card-text h4 {
            margin-bottom: 10px;
            font-size: 15px !important;
        }

        .plcy-card span {
            background: #8bf3b5;
            color: #0b8815;
            font-size: 14px;
            padding: 2px 7px;
        }

        .plcy-card h6 {
            color: #000;
            font-weight: 400;
        }

        .well-cnct {
            font-family: 'Caveat', cursive;
            font-size: 24px;
            line-height: 22px;
            margin-top: 18px;
            margin-left: 2px;
            color: #0554a3;
        }

        .plcy-card h4 {
            font-size: 14px;
            color: #0554a3;
            font-weight: 600;
        }

        .brand-logo img {
            width: 60% !important;
        }

        .medical-card-icon img {
            width: 25% !important;
        }

        .plcy-card-bottom {
            border-radius: 0px 0px 0px 0px;
            /*background-color: #f5d338;*/
            background: linear-gradient(#0b6de5, #66abf0);
            padding: 10px;
            border-bottom: none;
        }

        .plcy-card-bottom h4 {
            color: #10315b;
            font-size: 12px;
        }

        .plcy-card-bottom h6 {
            color: #ffffff;
        }

        .see-btn {
            float: right;
            margin-top: 20px;
            margin-bottom: 40px;
        }

        .see-btn a {
            margin-right: 10px;
        }

        .database-title {
            background-color: #eeeeee;
        }

        .batabase-table-btn a {
            font-size: 12px !important;
        }

        .months-fil input {
            border: 1px solid #e2e2e2;
            padding: 0.3rem 0.5rem;
            color: #715d5d;
            border-radius: 5px;
        }

        .family-details li {
            margin-bottom: 5px;
            font-size: 18px;
        }

        .family-details li i {
            color: #4a457d;
            margin-right: 10px;
        }

        .fmly-tp-bx {
            width: 55%;
            margin: 0 auto;
        }



        .nav-header .logo {
            width: 75% !important;
            position: absolute;
            left: 60px;
        }

        .total-attendence span {
            font-weight: 600;
        }

        .attendence-number span {
            position: relative;
            left: 15px;
            font-weight: 500;
        }

        .attendence-number-1 {
            position: relative;
            left: 20px;
            font-weight: 500;
        }

        .card-btn-left {}

        .card-btn-section {
            border: solid 1px #1675e7;
            padding: 20px;
            border-radius: 0px 0px 15px 15px;
            border-top: none;
        }

        /*
.card-text-btn{
	border-bottom: 1px solid #ccc;
    margin: 5px 0px 5px 0;
}*/

        .ppt-slider-head {
            font-size: 34px;
            font-weight: 600;
            color: #4a457d;
        }

        .ppt-slider-pera {
            font-size: 16px;
            text-align: justify;
        }

        .faq-dislamer {
            font-size: 16px;
            text-align: justify;
        }

        .accordion-header {
            border: 0.0625rem solid #4a457d !important;
        }

        .accordion-bordered .accordion__body {
            border: 0.0625rem solid #4a457d;
        }

        .tryal-gradient2 {
            background: #ffffff;
            position: relative;
            border: solid 3px #0e3551;
        }

        .for-insrnc-logo {
            width: 55%;
            margin-bottom: 15px;
        }

        .prfile-detail h1 {
            color: #0e3551;
            font-weight: 600;
            padding: 0;
            margin: 0;
        }

        .prfile-detail h6 {
            font-size: 1rem;
            font-weight: 500;
            color: #0e3551;
            margin: 0;
        }

        .prfile-detail h2 {
            font-size: 1.55rem;
            color: #0e3551;
            font-weight: 400;
        }

        .tryal-1 {
            padding: 1rem 1rem 0rem 1rem;
        }

        .tryal2 {
            padding: 0rem 1rem 1rem 1rem;
        }

        .knw-yr-plcy {
            font-size: 34px;
            font-weight: 600;
            color: #4a457d;
        }

        .crd-pd {
            padding: 2rem;
        }

        .crd-pd ul li {
            margin: 15px 0px;
        }

        .crd-pd ul li a {
            font-size: 22px;
            font-weight: 500;
            color: #088069;
        }

        .crd-pd ul li a:hover {
            font-weight: 500;
            color: #fdcd71;
        }

        .membr-list-crd {
            padding: 2rem;
        }

        .membrs-list li {
            margin: 15px 0px;
        }

        .membrs-list li a {
            font-size: 18px;
            color: #0d59a6;
            font-weight: 500;
        }

        .membrs-list-btn li {
            margin: 15px 0px;

            text-align: right;
        }



        .membrs-list-btn li a {
            font-size: 18px;
            background: #0554a3;
            color: #fff;
            padding: 5px 9px;
        }

        .membrs-list-btn li a:hover {
            font-size: 18px;
            background: #fdcd71;
            color: #fff;
            padding: 5px 9px;
        }

        .add-membr-btn {
            font-size: 18px;
            background: #20b741;
            color: #fff;
            padding: 5px 9px;
            margin-left: 49.9%;
            border-radius: 20px;
        }

        .add-membr-btn:hover {
            font-size: 18px;
            background: #fdcd71;
            color: #fff;
            padding: 5px 9px;
        }

        .cntct_us {
            border: 1px solid #09bd3c;
            color: #09bd3c;
            font-size: 1.2rem;
            padding: 8px 12px;
        }

        .cntct_us:hover {
            border: 1px solid #4a457d;
            color: #4a457d;
        }


        .tpa-headng {
            font-size: 1.3rem;
            font-weight: 600;
            color: #6d53a0;
        }

        .contact-card span {
            font-size: 0.9rem !important;
        }


        /*=============================== File Upload=======================*/

        .dp-upld-bx {
            position: relative;
            z-index: 999;
            width: 45%;
            float: right;
            margin-right: 10px;
            top: -25px;
        }

        .dp-upld-bx h5 {
            text-align: center;
            color: #fff;
        }

        .dp-upld-bx .form-file {
            border-radius: 8px 18px 18px 8px;
        }

        .dp-upld-bx .form-file-input {
            border-radius: 0px 20px 20px 0px;
        }

        #knowyourpolicy h5 {
            font-size: 1.5rem;
        }

        #knowyourpolicy strong {
            font-size: 1rem;
        }

        .knw-abt-plcy-list {
            margin-top: 15px;
        }

        .knw-abt-plcy-list li {
            font-size: 1.2rem;
            margin-bottom: 15px;
            text-align: justify;
        }

        .knw-abt-plcy-list li i {
            margin-right: 10px;
            color: #4a457d;
        }


        .ppt-slide-bx {
            width: 80%;
            margin: 0 auto;
        }

        .ham-menu1 {
            display: none;
        }


        .emplyee-span-email-txt span {
            font-size: 0.9rem !important;
        }



        @media only screen and (max-width: 47.9375rem) {

            .ham-menu1 {
                display: block;
            }


            .ham-menu1 {
                position: relative;
                top: -95px;
                z-index: 9;
                left: 1.3rem;
            }


            .menu-items {
                text-align: left;
                position: absolute;
                padding: 0rem;
                margin-top: -6rem;
                margin-left: -1rem;
                top: 17rem;
                z-index: 9;
                left: 0.5rem;
                list-style: none;
                opacity: 0;
                font-size: 1.3rem;
                border: 1px solid #313030;
                background-color: #fff;
                border-radius: 0.25em;
                transform: translateX(-10%);
                transition: transform 100ms ease-in-out, opacity 200ms;
            }

            .menu-items li {
                color: white;
                padding: 0.5rem;
                border-bottom: solid 1px #dedede;
                padding-left: 1.5rem;
            }

            .menu-items li a {
                color: #000;
                text-decoration: none;
            }

            .menu-items li a:hover {
                color: rgb(174, 174, 174);
            }

            .chckd {
                position: absolute;
                top: 8rem;
                left: 8rem;
                height: 3rem;
                width: 3rem;
                opacity: 0;
                z-index: 3;
            }

            .chckd:hover {
                cursor: pointer;
            }

            .chckd:checked~.menu-items {
                display: block;
                transform: translateX(0%);
                opacity: 1;
            }

            .ham-menu {
                height: 3rem;
                width: 3rem;
                position: absolute;
                top: 8rem;
                left: 8rem;
                padding: 0.5rem;
                z-index: 2;
                display: flex;
                flex-direction: column;
                justify-content: space-around;
                background-color: #0859a8;
                border-radius: 0.25em;
            }

            .ham-menu .line {
                background-color: white;
                border-radius: 1em;
                width: 2rem;
                height: 0.25rem;
            }

            .ham-menu .line1 {
                transform-origin: 0% 0%;
                transition: transform 100ms ease-in-out;
            }

            .ham-menu .line3 {
                transform-origin: 0% 100%;
                transition: transform 100ms ease-in-out;
            }

            .chckd:checked~.ham-menu .line1 {
                display: block;
                transform: rotate(45deg);
            }

            .chckd:checked~.ham-menu .line2 {
                opacity: 0;
            }

            .chckd:checked~.ham-menu .line3 {
                display: block;
                transform: rotate(-45deg);
            }

            .emplye-lft-menu {
                display: none;
            }

            .brand-logo img {
                width: 100% !important;
            }

            .emlyee-user-bx-mble {
                margin-left: -18rem;
            }


            .dp-upld-bx {
                width: 95%;
                top: -5px;
            }

            .emply-dash-img-hide {
                display: none;
            }

            .fmly-tp-bx {
                width: 100%;
                margin-bottom: 6rem;
            }

            .ppt-slide-bx {
                width: 100%;
            }

        }

        .valu_add-pop-btn-colr {
            background: #ffedf0;
            border: solid 1px #fdcbd3;
            color: #ff6550;
        }

        .valu_add-pop-btn-colr:hover {
            background-color: #ff6550;
            border-color: #ffedf0;
            color: #fff;
        }

        .eplyee-valu-list li {
            margin-bottom: 10px;
            font-size: 1rem;
        }

        .eplyee-valu-list li i {
            color: #34dc60;
            margin-right: 8px;
        }

        .eplyee-valu-list li span {
            margin-left: 22px;
        }

        .velue-popup-head {
            font-size: 1.5rem;
            font-weight: 600;
            color: #644998;
        }
    </style>
</head>

<body>
    <!--<div id="preloader">
         <div class="lds-ripple">
            <div></div>
            <div></div>
         </div>
      </div>-->
    <div id="main-wrapper">
        <div class="nav-header">
            <a href="#" class="brand-logo">
                <img src="<?= base_url('external/images/'); ?>logo.png" style="width: 115px;">

            </a>
            <div class="nav-control">
                <!--<div class="hamburger emloye-hamburger">
                  <span class="line"></span><span class="line"></span><span class="line"></span>
               </div>-->

            </div>
        </div>
        <div class="ham-menu1">
            <input type="checkbox" name="" id="" class="chckd">
            <ul class="menu-items">
                <li><a href="<?= base_url('employee/dashboard/'); ?><?= $cid; ?>/<?= $pid; ?>/<?= $eid; ?>">Home</a></li>
                <li><a href="<?= base_url('employee/value/') ?><?= $cid; ?>/<?= $pid; ?>/<?= $eid; ?>">VALUE ADDED SERVICES</a></li>
                <li><a href="<?= base_url('employee/myupdates/') ?><?= $cid; ?>/<?= $pid; ?>/<?= $eid; ?>">My Claims</a></li>
                <li><a href="<?= base_url('employee/contactus/'); ?><?= $cid; ?>/<?= $pid; ?>/<?= $eid; ?>">CONTACT US</a></li>
            </ul>
            <div class="ham-menu">
                <span class="line line1"></span>
                <span class="line line2"></span>
                <span class="line line3"></span>
            </div>
        </div>
        <div class="header border-bottom">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="dlabnav emlye-mblie-menu">
                                <div class="dlabnav-scroll">
                                    <ul class="metismenu" id="menu">
                                        <li><a href="<?= base_url('user/dashboard/'); ?><?= $cid; ?>/<?= $pid; ?>/<?= $eid; ?>" class="" aria-expanded="false">
                                                <i class="fas fa-home"></i>
                                                <span class="nav-text">Dashboard</span>
                                            </a>
                                        </li>
                                        <li><a href="<?= base_url('user/profile/'); ?><?= $cid; ?>/<?= $pid; ?>/<?= $eid; ?>" class="" aria-expanded="false">
                                                <i class="las la-user-circle"></i>
                                                <span class="nav-text">Profile</span>
                                            </a>
                                        </li>
                                        <li><a href="<?= base_url('user/dependents/'); ?><?= $cid; ?>/<?= $pid; ?>/<?= $eid; ?>" class="" aria-expanded="false">
                                                <i class="las la-restroom"></i>
                                                <span class="nav-text">Dependants</span>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>

                            <div class="header-left">
                                <div class="header-btn emplye-lft-menu ">
                                    <a href="<?= base_url('employee/dashboard/'); ?><?= $cid; ?>/<?= $pid; ?>/<?= $eid; ?>" class="btn btn-outline-primary btn-rounded fs-18" style="margin-right: 10px;">HOME</a>
                                    <a href="<?= base_url('employee/focusedclaim/') ?><?= $cid; ?>/<?= $pid; ?>/<?= $eid; ?>" class="btn btn-outline-info btn-rounded fs-18">My Claims</a>&nbsp;&nbsp;&nbsp;
                                    <a href="<?= base_url('employee/value/') ?><?= $cid; ?>/<?= $pid; ?>/<?= $eid; ?>" class="btn btn-outline-success btn-rounded fs-18">VALUE ADDED SERVICES</a> &nbsp;&nbsp;&nbsp;
                                    <a href="<?= base_url('employee/contactus/'); ?><?= $cid; ?>/<?= $pid; ?>/<?= $eid; ?>" class="btn btn-outline-success btn-rounded fs-18">CONTACT US</a>
                                </div>



                            </div>










                        </div>


                        <div class="navbar-nav header-right emlyee-user-bx-mble">

                            <ul>

                                <li class="nav-item dropdown  header-profile">

                                    <!--<a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" style="padding-left: 10px !important;padding-right: 10px !important;">
                           <?php
                            //echo $this->session->userdata('name');
                            ?>
                           </a>-->
                                    <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                                        <?php
                                        $image = $this->qm->single('emp_images', '*', array('employee_id' => $eid));
                                        //print_r($image);
                                        if (isset($image->image)) { ?>
                                            <img src="<?= base_url($image->image) ?>" alt="" class="sd-shape" style="height: 56px;width: 56px;">
                                        <?php } else { ?>
                                            <img src="<?= base_url() ?>external/images/chart.png" class="img-responsive for-insrnc-logo_" style="height: 56px;width: 56px;" />
                                        <?php } ?>


                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">

                                        <a href="<?= base_url('employee/logout/'); ?><?= $cid; ?>/<?= $pid; ?>/<?= $eid; ?>" class="dropdown-item ai-icon">
                                            <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                                <polyline points="16 17 21 12 16 7"></polyline>
                                                <line x1="21" y1="12" x2="9" y2="12"></line>
                                            </svg>
                                            <span class="ms-2">Logout </span>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>