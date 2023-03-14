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
   <title>Client</title>
   <link rel="shortcut icon" type="image/png" href="images/favicon.png" />
   <!-- Datatable -->
   <link href="<?= base_url('external/'); ?>vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
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

      .value-heading {
         margin-top: 50px;
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
         <a href="<?= base_url('client/dashboard/'); ?>" class="brand-logo">
            <img src="<?= base_url('external/images/'); ?>logo.png" style="width: 115px;">

         </a>
         <div class="nav-control">
            <div class="hamburger">
               <span class="line"></span><span class="line"></span><span class="line"></span>
            </div>
         </div>
      </div>
      <?php
      $chk = $this->qm->single("ri_clients_tbl", "*", array('cid' => $cid));
      ?>
      <div class="header border-bottom">
         <div class="header-content">
            <nav class="navbar navbar-expand">
               <div class="collapse navbar-collapse justify-content-between">
                  <div class="header-left">
                     <div class="dlabnav">
                        <div class="dlabnav-scroll">
                           <ul class="metismenu" id="menu">
                              <li><a href="<?= base_url('client/dashboard/'); ?>" class="" aria-expanded="false">
                                    <i class="fas fa-home"></i>
                                    <span class="nav-text">Home</span>
                                 </a>
                              </li>
                              <li><a href="javascript:void();" class="" aria-expanded="false">
                                    <i class="las la-shield-alt"></i>
                                    <span class="nav-text">Policies</span>
                                 </a>
                                 <ul aria-expanded="false" class="left mm-collapse mm-show cmenu-dropdwn-list" style="">
                                    <?php
                                    $pol = $this->qm->all("ri_clientpolicy_tbl", "*", array('cid' => $cid));
                                    foreach ($pol as $pol) {
                                    ?>
                                       <li><a href="<?= base_url('client/dashboard/' . $pol->id) ?>"><?= $pol->policy_num ?></a></li>
                                    <?php } ?>
                                 </ul>
                              </li>
                              <?php $pot = $this->qm->single("ri_clientpolicy_tbl", "*", array('cid' => $cid, 'id' => $pid));
                              $type = $this->qm->single("ad_policy_type", "*", array('policy_type_id' => $pot->policy_type));

                              ?>
                              <li>
                                 <a href="<?= base_url('client/dashboard/' . $pid); ?>" class="active" aria-expanded="false">
                                    <span class="nav-text"><?= $pot->policy_num ?><br><?= ($type->policy_type_name == "Group Health Insurance Floater") ? "GHIF" : ""; ?></span>
                                 </a>
                              </li>

                              <li><a href="<?= base_url('client/velueadded/'); ?>" class="" aria-expanded="false">
                                    <span class="nav-text">Value Added Services</span>
                                 </a>
                              </li>
                              <li><a href="<?= base_url('client/invitationhistory/'); ?>" class="" aria-expanded="false">
                                    <span class="nav-text">Invite History</span>
                                 </a>
                              </li>

                              <!--<li><a href="javascript:void();" class="" aria-expanded="false">
                     <span class="nav-text">Invite</span>
                     </a>
                     <ul aria-expanded="false" class="left mm-collapse mm-show" style="">
                         
                            <li><a href="javascript:;" data-bs-toggle="modal" data-bs-target="#inviteempmodal">Invite Employee</a></li>
                            <li><a href="<?= base_url('client/invitationhistory/'); ?>?>">Invite History</a></li>
                    
                    </ul>
                  </li>-->



                              <li><a href="<?= base_url('client/contactus/'); ?>" class="" aria-expanded="false">
                                    <span class="nav-text">Contact Us</span>
                                 </a>
                              </li>

                           </ul>


                        </div>
                     </div>
                  </div>
                  <ul class="navbar-nav header-right">

                     <li class="nav-item dropdown  header-profile">
                        <a class="nav-link" href="javascript:void(0);" role="button_" data-bs-toggle="dropdown">
                           <!--<img src="external/uploads/demo_icon1.png" width="56" alt="" />-->

                           <img src="<?= base_url() ?>external/uploads/<?= $chk->image ?>" width="56" alt="" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                           <a href="<?= base_url('client/profile/'); ?>" class="dropdown-item ai-icon">
                              <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                 <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                 <circle cx="12" cy="7" r="4"></circle>
                              </svg>
                              <span class="ms-2">Profile </span>
                           </a>

                           <a href="<?= base_url('client/logout/'); ?>" class="dropdown-item ai-icon">
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