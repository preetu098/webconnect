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
    <title>Client Login | Risk Birbal</title>
    <link rel="shortcut icon" type="image/png" href="images/favicon.png">
    <link href="<?= base_url('external/');?>css/style.css" rel="stylesheet">
  </head>
  <body class="vh-100">
    <div class="authincation h-100" style="background:#fff;">
      <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
          <div class="col-md-6">
            <div class="authincation-content">
              <div class="row no-gutters">
                <div class="col-xl-12">
                  <div class="auth-form">
                    <div class="text-center mb-3">
                        
                         
                      <div class="row">
                                 <div class="col-xl-6">
                                     <br><br><br>
                                 <a href="javascript:void;"><img src="<?= base_url('external/');?>images/logo.png" style="width: 200px;" alt=""></a>
                                 
                                 

                                 </div>

                                 <div class="col-xl-6">
                                     <?php 
                     $client = $this->qm->all('ri_clients_tbl','*',array('cid'=>$cid));
                     foreach($client as $client);
                  ?>
                                 <a href="javascript:void;"><img src="<?= base_url('external/uploads/');?><?= $client->image;?>" style="width: 150px;"  alt=""></a>
                              </div>
                              </div>
                    </div>
                    <h4 class="text-center mb-4">Change password</h4>
                    <form  method="POST" class="signin">
                      <div class="mb-3">
                        <label class="mb-1"><strong>New Password</strong></label>
                        <input type="password" class="form-control"  name="pass" required placeholder="New Password">
                      </div>
                      <div class="mb-3">
                        <label class="mb-1"><strong>Confirm Password</strong></label>
                        <input type="password" name="reenterpass" class="form-control" required placeholder="Confirm password">
                      </div>
                     
                      <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-block">Change Password</button>
                      </div>
                    </form>
                    
                    
                   
                  </div>
                </div>
              </div>
            </div>
          </div>
           <div class="col-md-6">
        <img src="<?= base_url('external/');?>images/emloyee-loin.jpg" class="img-responsive" style="width:100%" alt="">
        </div>
        </div>
      </div>
    </div>
    
    <script src="<?= base_url('external/');?>js/custom.min.js"></script>
    <script src="<?= base_url('external/');?>js/dlabnav-init.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function hidelogin(arg)
        {
            if(arg=='show')
            {
                $('.forget').show();
                $('.signin').hide();
            }else{
                 $('.forget').hide();
                $('.signin').show();
            }
        }
    </script>

  </body>
</html>
