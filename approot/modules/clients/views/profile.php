<!DOCTYPE html>
<html lang="en" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="robots" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="format-detection" content="telephone=no">
    <title>Change Password | Risk Birbal</title>
    <link rel="shortcut icon" type="image/png" href="images/favicon.png">
    <link href="<?= base_url('external/');?>css/style.css" rel="stylesheet">
  </head>
  <body class="vh-100">
    <div class="authincation h-100">
      <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
          <div class="col-md-6">
            <div class="authincation-content">
              <div class="row no-gutters">
                <div class="col-xl-12">
                  <div class="auth-form">

                    <div class="text-center mb-3">
                     
                                 <a href="javascript:void;"><img src="<?= base_url('external/');?>images/logo.png" style="width: 150px;" alt=""></a>

                              
                    </div>
                   
                       <?php 
                                 if(!empty($this->session->flashdata('chnpass'))){

                                    $chnpass = $this->session->flashdata('chnpass');
                              ?>
                           <div class="alert alert-success alert-dismissible fade show" style="width: 100%;">

                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                              </button>
                              <strong>Success!</strong><?= $chnpass;?>
                           </div>
                        <?php }
                        else if(!empty($this->session->flashdata('echnpass'))){
                           $echnpass = $this->session->flashdata('echnpass');
                         ?>
                          <div class="alert alert-danger alert-dismissible fade show" style="width: 100%;">

                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                              </button>
                              <strong>Error!</strong> <?= $echnpass;?>
                           </div>
                         <?php }else{} ?>  
                   
                    <form action="<?= base_url('login/updpass');?>" method="POST">
                                         
                                           <div class="mb-3">
                                             <label class="mb-1"><strong>Old Password</strong></label>
                                             <input type="password" name="opass" class="form-control" required placeholder="Password">
                                           </div>
                                           <div class="mb-3">
                                             <label class="mb-1"><strong>New Password</strong></label>
                                             <input type="password" name="npass" class="form-control" required placeholder="Password">
                                           </div>
                                           <div class="mb-3">
                                             <label class="mb-1"><strong>Confirm Password</strong></label>
                                             <input type="password" name="cpass" class="form-control" required placeholder="Password">
                                           </div>
                                            <?php 
                                 if(!empty($this->session->flashdata('notequal'))){

                                    $notequal = $this->session->flashdata('notequal');
                              ?>
                               <div class="alert alert-danger alert-dismissible fade show" style="width: 100%;padding: 10px;">

                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                              </button>
                              <strong>Error!</strong> <?= $notequal;?>
                           </div>
                        <?php } ?>
                                           <div class="text-center">
                                             <button type="submit" class="btn btn-primary btn-block">Change Password</button>
                                           </div>
                                         </form>
                   
                  </div>
                                            <a href="<?= base_url('dashboard/');?>" class="btn btn-primary" style="display: flow-root;width: 50%;margin: 0 auto;">Back To Dashboard</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <script src="<?= base_url('external/');?>js/custom.min.js"></script>
    <script src="<?= base_url('external/');?>js/dlabnav-init.js"></script>

  </body>
</html>
