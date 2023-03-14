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
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
   <link rel="shortcut icon" type="image/png" href="images/favicon.png" />
   <link href="<?= base_url('external/'); ?>vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
   <link href="<?= base_url('external/'); ?>vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
   <link href="<?= base_url('external/'); ?>vendor/owl-carousel/owl.carousel.css" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('external/'); ?>vendor/nouislider/nouislider.min.css">
   <link href="<?= base_url('external/'); ?>css/style.css" rel="stylesheet">
   <link href="<?= base_url('external/'); ?>css/custum.css" rel="stylesheet">
   <link href="<?= base_url('external/'); ?>css/checkBox/checkbox.css" rel="stylesheet">
   <style type="text/css">
      .DZ-bt-support-now.DZ-theme-btn {
         display: none !important;
      }

      .DZ-bt-buy-now.DZ-theme-btn {
         display: none !important;
      }
   </style>
</head>

<body>
   <div id="preloader">
      <div class="lds-ripple">
         <div></div>
         <div></div>
      </div>
   </div>
   <div id="main-wrapper">
      <div class="nav-header">
         <a href="index.html" class="brand-logo">
            <img src="<?= base_url('external/images/'); ?>logo.png" style="width: 115px;">

         </a>
         <div class="nav-control">
            <div class="hamburger">
               <span class="line"></span><span class="line"></span><span class="line"></span>
            </div>
         </div>
      </div>

      <div class="header border-bottom">
         <div class="header-content">
            <nav class="navbar navbar-expand">
               <div class="collapse navbar-collapse justify-content-between">
                  <div class="header-left">
                     <div class="dlabnav">
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
                                    <span class="nav-text">Dependents</span>
                                 </a>
                              </li>
                           </ul>


                        </div>
                     </div>


                  </div>
                  <ul class="navbar-nav header-right">

                     <li class="nav-item dropdown  header-profile">
                        <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" style="padding-left: 10px !important;padding-right: 10px !important;">
                           <?php
                           echo $this->session->userdata('name');
                           ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">

                           <a href="<?= base_url('user/logout/'); ?><?= $cid; ?>/<?= $pid; ?>/<?= $eid; ?>" class="dropdown-item ai-icon">
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
            </nav>
         </div>
      </div>