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
    <title>User Login | Risk Birbal</title>
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
                      <div class="row">
                                 <div class="col-xl-12">
                                 <a href="javascript:void;"><img src="<?= base_url('external/');?>images/logo.png" style="width: 150px;" alt=""></a>

                                 </div>

                  
                              </div>
                    </div>
                    <h4 class="text-center mb-4">Sign in your account</h4>
                    <form action="<?= base_url('user/log');?>" method="POST">
                        <div class="mb-3">
                        <label class="mb-1"><strong>Employee Id</strong></label>
                        <input type="text" class="form-control"  name="emp_id" required placeholder="Example123">
                      </div>
                      <div class="mb-3">
                        <label class="mb-1"><strong>Username</strong></label>
                        <input type="text" class="form-control"  name="username" required placeholder="Example123">
                      </div>
                      <div class="mb-3">
                        <label class="mb-1"><strong>Password</strong></label>
                        <input type="password" name="password" class="form-control" required placeholder="Password">
                      </div>
                      <div class="row d-flex justify-content-between mt-4 mb-2">
                        
                        <div class="mb-3">
                          <a href="<?= base_url('client/forgotpassword');?>">Forgot Password?</a>
                        </div>
                      </div>
                      <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-block">Sign Me In</button>
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

  </body>
</html>
