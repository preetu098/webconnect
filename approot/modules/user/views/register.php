<!DOCTYPE html>
<html lang="en" class="h-100">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="keywords" content="" />
      <meta name="author" content="" />
      <meta name="robots" content="" />
      <meta name="viewport" content="width=device-width, initial-scale=1">
      
      <title>User Register - Risk Birbal</title>
     
      <link href="<?= base_url('external/');?>css/style.css" rel="stylesheet">
   </head>
   <body style="height:auto;">
      <div class="authincation h-100">
         <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
               <div class="col-md-6">
                  <div class="authincation-content" style="margin: 30px;">
                     <div class="row no-gutters">
                        <div class="col-xl-12">
                           <div class="auth-form">
                              <div class="text-center mb-3">
                                 <div class="row">
                                 <div class="col-xl-6">
                                 <a href="javascript:void;"><img src="<?= base_url('external/');?>images/logo.png" style="width: 150px;" alt=""></a>

                                 </div>

                                 <div class="col-xl-6">
                                     <?php 
                     $client = $this->qm->all('ri_clients_tbl','*',array('cid'=>$cid));
                     foreach($client as $client);
                  ?>
                                 <a href="javascript:void;"><img src="<?= base_url('external/uploads/');?><?= $client->image;?>" style="width: 100%;" alt=""></a>
                              </div>
                              </div>
                              </div>
                              <h4 class="text-center mb-4">Sign up your account</h4>

                              <form method="POST" action="<?= base_url('user/reg/');?><?= $cid;?>/<?= $pid;?>">
                                    <?php 
                     $cl = $this->qm->all("ri_clients_tbl","*",array('cid'=>$cid));
                     foreach ($cl as $cl);
                     ?>
                  <input type="hidden" name="client_code" value="<?= $cl->ccode;?>">
                  <input type="hidden" name="client_name" value="<?= $cl->cname;?>">
                                 <div class="mb-3">
                                    <label class="mb-1"><strong>Employee Id</strong></label>
                                    <input type="text" class="form-control" name="emp_id" placeholder="Employee Id">
                                 </div>
                                 <div class="mb-3">
                                    <label class="mb-1"><strong>Name</strong></label>
                                    <input type="text" class="form-control" name="name" placeholder="Full Name">
                                 </div>
                                 <div class="mb-3">
                                    <label class="mb-1"><strong>Username</strong></label>
                                    <input type="text" class="form-control" name="username" placeholder="Username">
                                 </div>
                                 <div class="mb-3">
                                    <label class="mb-1"><strong>Email</strong></label>
                                    <input type="email" class="form-control" name="email" placeholder="hello@example.com">
                                 </div>
                                  <div class="mb-3">
                                    <label class="mb-1"><strong>Mobile</strong></label>
                                    <input type="text" class="form-control" name="mobile" placeholder="1234567890">
                                 </div>
                                 <div class="mb-3">
                                    <label class="mb-1"><strong>Password</strong></label>
                                    <input type="password" class="form-control" name="password" value="Password">
                                 </div>
                                 <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-primary btn-block">Sign me up</button>
                                 </div>
                              </form>
                              
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      
      <script src="<?= base_url('external/');?>js/custom.min.js"></script>
      <script src="<?= base_url('external/');?>js/dlabnav-init.js"></script>
      <script src="<?= base_url('external/');?>js/styleSwitcher.js"></script>
   </body>
</html>
