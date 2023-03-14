
         <div class="content-body">
            <div class="container-fluid">
               <div class="row page-titles">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item active"><a href="javascript:void(0)">Client</a></li>
                     <li class="breadcrumb-item"><a href="javascript:void(0)">Profile</a></li>
                  </ol>
               </div>
               
               <div class="row">
                  <div class="col-xl-4">
                     <?php 
                        $cl = $this->qm->all('ri_clients_tbl','*',array('cid'=>$cid));
                        foreach ($cl as $cl) {
                           
                     ?>
                      <div class="card overflow-hidden">
                                          <div class="text-center p-3 overlay-box " style="background-image: url(images/big/img1.jpg);">
                                             <div class="profile-photo">
                                                <img src="<?= base_url('external/uploads/');?><?= ($cl->image==NULL)?'pro.png':$cl->image;?>" class="img-fluid rounded-circle" alt="" width="100">
                                             </div>
                                                <h3 class="mt-3 mb-1 text-white"><?= $cl->cname;?></h3>
                                               
                                             </div>
                                             <ul class="list-group list-group-flush">
                                                 <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Client Code</span> <strong class="text-muted"><?= $cl->ccode;?>  </strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Mobile</span> <strong class="text-muted"><?= $cl->phone;?>  </strong></li>
                                                 <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Email</span> <strong class="text-muted"><?= $cl->email;?>  </strong></li>
                                                 
                                                 
                                                </ul>
                                                
                                       </div>
                                    <?php } ?>
                  </div>
                  <div class="col-xl-8">
                     <div class="card">
                      <div class="card-header">
                     <h4 class="card-title">Supports</h4>
                     </div>
                        <div class="card-body">
                           <div class="row">
                             <?php 
                              $tech = $this->qm->all('ri_clients_tbl','*',array('cid'=>$cid));
                              foreach($tech as $tech);
                             ?> 
                             <div class="col-xl-6 col-lg-12 col-sm-12">
                              <div class="card">
                                 <div class="card-header border-0 pb-0">
                                 <h2 class="card-title"><i class="las la-user-astronaut"></i> Tech Support</h2>
                                 </div>
                                 <div class="card-body pb-0">

                                 <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                    <strong>Name</strong>
                                    <span class="mb-0"><?= $tech->tname;?></span>
                                    </li>
                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                    <strong>Email</strong>
                                    <span class="mb-0"><?= $tech->temail;?></span>
                                    </li>
                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                    <strong>Phone</strong>
                                    <span class="mb-0"><?= $tech->tphone;?></span>
                                    </li>

                                 </ul>
                                 </div>
                             
                              </div>
                              </div>
                              <div class="col-xl-6 col-lg-12 col-sm-12">
                              <div class="card">
                                 <div class="card-header border-0 pb-0">
                                 <h2 class="card-title"><i class="las la-user-astronaut"></i> Functional Support</h2>
                                 </div>
                                 <div class="card-body pb-0">

                                 <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                    <strong>Name</strong>
                                    <span class="mb-0"><?= $tech->fname;?></span>
                                    </li>
                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                    <strong>Email</strong>
                                    <span class="mb-0"><?= $tech->femail;?></span>
                                    </li>
                                    <li class="list-group-item d-flex px-0 justify-content-between">
                                    <strong>Phone</strong>
                                    <span class="mb-0"><?= $tech->fphone;?></span>
                                    </li>

                                 </ul>
                                 </div>
                             
                              </div>
                              </div>
                              
                           
                              </div>
                              
                           </div>

                        </div>
                     </div>
                     <div class="col-xl-6">
                        
                        <div class="card">
   <div class="card-header">
      <h4 class="card-title">Account Setting</h4>
         <?php 
                                 if(!empty($this->session->flashdata('upd'))){

                                    $upd = $this->session->flashdata('upd');
                              ?>
                           <div class="alert alert-success alert-dismissible fade show" style="width: 50%;">

                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                              </button>
                              <strong>Success!</strong><?= $upd;?>
                           </div>
                        <?php }
                        else if(!empty($this->session->flashdata('upde'))){
                           $upde = $this->session->flashdata('upde');
                         ?>
                          <div class="alert alert-danger alert-dismissible fade show" style="width: 50%;">

                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                              </button>
                              <strong>Error!</strong> <?= $upde;?>
                           </div>
                         <?php }else{} ?>  
   </div>
            <div class="card-body">
               <div class="basic-form">
                  <form method="POST" action="<?= base_url('client/updprofile/');?>" enctype="multipart/form-data">

                     <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                           <input type="email"  name="email" value="<?= $cl->email;?>" class="form-control" placeholder="Email">
                        </div>
                     </div>
                     <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Phone</label>
                        <div class="col-sm-9">
                           <input type="text" name="phone" value="<?= $cl->phone;?>"  class="form-control" placeholder="Phone">
                        </div>
                     </div>
                      <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Image</label>
                        <div class="col-sm-6">
                           <input type="file" name="image" class="form-control">
                        </div>
                        <div class="col-sm-3">
                           <img src="<?= base_url('external/uploads/');?><?= $cl->image;?>" style='width: 100px;'>
                        </div>
                     </div>
                     
                    
                     <div class="mb-3 row">
                        <div class="col-sm-10">
                           <button type="submit" class="btn btn-primary">Update Me</button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>

                     </div>
                     <div class="col-xl-6">
                        
                        <div class="card">
   <div class="card-header">
      <h4 class="card-title">Change Password</h4>
          <?php 
                                 if(!empty($this->session->flashdata('chnpass'))){

                                    $chnpass = $this->session->flashdata('chnpass');
                              ?>
                           <div class="alert alert-success alert-dismissible fade show" style="width: 50%;">

                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                              </button>
                              <strong>Success!</strong><?= $chnpass;?>
                           </div>
                        <?php }
                        else if(!empty($this->session->flashdata('echnpass'))){
                           $echnpass = $this->session->flashdata('echnpass');
                         ?>
                          <div class="alert alert-danger alert-dismissible fade show" style="width: 50%;">

                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                              </button>
                              <strong>Error!</strong> <?= $echnpass;?>
                           </div>
                         <?php }else{} ?>  
   </div>
            <div class="card-body">
               <div class="basic-form">
                  <form method="POST" action="<?= base_url('client/chnpass/');?>" enctype="multipart/form-data">

                     <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Old Password</label>
                        <div class="col-sm-9">
                           <input type="password"  name="opass" class="form-control" placeholder="Old Password">
                        </div>
                     </div>
                     <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">New Password</label>
                        <div class="col-sm-9">
                           <input type="password" name="npass"   class="form-control" placeholder="New Password">
                        </div>
                     </div>
                      <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Confirm Password</label>
                        <div class="col-sm-9">
                           <input type="password" name="cpass" class="form-control" placeholder="Confirm Password">
                        </div>
                       
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
                    
                     <div class="mb-3 row">
                        <div class="col-sm-10">
                           <button type="submit" class="btn btn-primary">Change Password</button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>

                     </div>


               </div>
            </div>
         </div>

