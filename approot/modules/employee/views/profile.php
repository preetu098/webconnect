
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
                     <div class="row">
                        <div class="col-xl-12">
                           <div class="card">
                              <div class="card-body text-center ai-icon  text-primary">
                                  <?php 
                                    $em = $this->qm->all('ri_employee_tbl','*',array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid));
                                    foreach ($em as $em);
                                    
                                   ?>
                                <i class="las la-file-pdf" style="font-size: 75px;float: left;">
                                    <a style="float: left;line-height: 30px;" href="<?= base_url('external/uploads/policy_cards/'.$cid.'_'.$pid.'/');?><?= $em->card;?>.pdf" class="btn my-2 btn-primary btn-lg px-4"><i class="fa fa-usd"></i> Download</a>
                                </i>
                                  
                                   
                                 </div>
                              <div class="card-body">
                                 
                                 <div class="profile-statistics">
                                   <?php 
                                    $emp = $this->qm->all('ri_employee_tbl','*',array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid));
                                    foreach ($emp as $emp) {
                                    
                                   ?>
                                       <div class="card overflow-hidden">
                                          <div class="text-center p-3 overlay-box " style="background-image: url(images/big/img1.jpg);">
                                             <div class="profile-photo">
                                                <img src="<?= base_url('external/uploads/');?><?= ($emp->pimage==NULL)?'pro.png':$emp->pimage;?>" class="img-fluid rounded-circle" alt="" width="100">
                                             </div>
                                                <h3 class="mt-3 mb-1 text-white"><?= $emp->name;?></h3>
                                                <p class="text-white mb-0"><?= $emp->emp_id;?></p>
                                             </div>
                                             <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Mobile</span> <strong class="text-muted"><?= $emp->mobile;?>  </strong></li>
                                                 <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Email</span> <strong class="text-muted"><?= $emp->email;?>  </strong></li>
                                                  <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Gender</span> <strong class="text-muted"><?= $emp->gender;?>  </strong></li>
                                                   <li class="list-group-item d-flex justify-content-between"><span class="mb-0">D.O.B</span> <strong class="text-muted"><?= $emp->dob;?>  </strong></li>
                                                <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Years Old</span> <strong class="text-muted">Age: <?= $emp->age;?>   </strong></li>
                                                </ul>
                                                
                                       </div>
                                 <?php }?>
                                    
                                 </div>
                              </div>
                           </div>
                        </div>
                       
                      
                      
                     </div>
                  </div>
                  <div class="col-xl-8">
                     <div class="card">
                        <div class="card-body">
                           <div class="profile-tab">
                              <div class="custom-tab-1">
                                
                               
                                   
                                      <div class="pt-3">
                                          <div class="settings-form">
                                            
                                               <?php 
                                 if(!empty($this->session->flashdata('upd'))){

                                    $upd = $this->session->flashdata('upd');
                              ?>
                           <div class="alert alert-success alert-dismissible fade show" style="width: 25%;">

                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                              </button>
                              <strong>Success!</strong><?= $upd;?>
                           </div>
                        <?php }
                        else if(!empty($this->session->flashdata('upde'))){
                           $upde = $this->session->flashdata('upde');
                         ?>
                          <div class="alert alert-danger alert-dismissible fade show" style="width: 25%;">

                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                              </button>
                              <strong>Error!</strong> <?= $upde;?>
                           </div>
                         <?php }else{} ?>  
                           <?php 
                                 if(!empty($this->session->flashdata('chnpass'))){

                                    $chnpass = $this->session->flashdata('chnpass');
                              ?>
                           <div class="alert alert-success alert-dismissible fade show" style="width: 25%;">

                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                              </button>
                              <strong>Success!</strong><?= $chnpass;?>
                           </div>
                        <?php }
                        else if(!empty($this->session->flashdata('echnpass'))){
                           $echnpass = $this->session->flashdata('echnpass');
                         ?>
                          <div class="alert alert-danger alert-dismissible fade show" style="width: 25%;">

                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                              </button>
                              <strong>Error!</strong> <?= $echnpass;?>
                           </div>
                         <?php }else{} ?>  
                         <div class="default-tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                       <li class="nav-item">
                                          <a class="nav-link active" data-bs-toggle="tab" href="#profile"><i class="las la-cog"></i> Account Setting</a>
                                       </li>
                                       <li class="nav-item">
                                          <a class="nav-link" data-bs-toggle="tab" href="#chnpass"><i class="las la-key"></i> Change Password</a>
                                       </li>
                                        <li class="nav-item">
                                          <a class="nav-link" data-bs-toggle="tab" href="#support"><i class="las la-user-astronaut"></i> Contact Supports</a>
                                       </li>
                                      
                                    </ul>
                                    <div class="tab-content">
                                       <div class="tab-pane fade active show" id="profile" role="tabpanel">
                                           <h4 class="text-primary" style="padding: 10px;">Account Setting</h4>
                                          <form method="POST" action="<?= base_url('user/updme/');?><?= $cid;?>/<?= $pid;?>/<?= $eid;?>" enctype="multipart/form-data">
                                                <?php 
                                                  $uemp = $this->qm->all('ri_employee_tbl','*',array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid));
                                                    foreach ($uemp as $uemp) {
                                                ?>
                                                <div class="row">
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">Name</label>
                                                      <input type="text" placeholder="Name" value="<?= $uemp->name;?>" name="name" class="form-control">
                                                   </div>
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">Email</label>
                                                      <input type="email" placeholder="Email" value="<?= $uemp->email;?>" name="email" class="form-control">
                                                   </div>
                                                      <div class="mb-3 col-md-6">
                                                      <label class="form-label">Mobile</label>
                                                      <input type="text" placeholder="Mobile" value="<?= $uemp->mobile;?>" name="mobile" class="form-control">
                                                   </div>
                                                      <div class="mb-3 col-md-6">
                                                      <label class="form-label">Gender</label>
                                                       <select class="form-control" name="gender">
                                                         <option>Select gender</option>
                                                         <option value="Male" <?= ($uemp->gender=='Male')?'selected':'';?>>Male</option>
                                                         <option value="Female" <?= ($uemp->gender=='Female')?'selected':'';?>>Female</option>
                                                         <option value="Others" <?= ($uemp->gender=='Others')?'selected':'';?>>Others</option>
                                                     </select>
                                                   </div>
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">Wedding Date</label>
                                                        <input type="date" name="wedd_date" value="<?= $uemp->wedd_date;?>" class="form-control" placeholder="Wedding Date">
                                                   </div>
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">DOB</label>
                                                       <input type="date" name="dob" id="dob" class="form-control" value="<?= $uemp->dob;?>" placeholder="Dob">
                                                   </div>
                                                    <div class="mb-3 col-md-6">
                                                      <label class="form-label">Age</label>
                                                       <input type="text" name="age" id="age" class="form-control" value="<?= $uemp->age;?>" placeholder="Age">
                                                   </div>
                                                    <div class="mb-3 col-md-6">
                                                      <div class="row">
                                                         <div class="col-xl-8">
                                                      <label class="form-label">Profile Image</label>
                                                       <input type="file" name="pimage" class="form-control">
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <img src="<?= base_url('external/uploads/');?><?= ($uemp->pimage==NULL)?'pro.png':$uemp->pimage;?>">
                                                         </div>
                                                        </div>
                                                   </div>

                                               
                                                </div>
                                                <?php } ?>
                                                
                                               
                                                <button class="btn btn-primary" type="submit">Update Me</button>
                                             </form>
                                       </div>
                                       <div class="tab-pane fade" id="chnpass">
                                          <h4 class="text-primary" style="padding: 10px;">Change Password</h4>
                                          <div class="centrics">
                                         <form action="<?= base_url('user/updpass');?>/<?= $cid;?>/<?= $pid;?>/<?= $eid;?>" method="POST">
                                         
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

                                       </div>

                                       <div class="tab-pane fade" id="support">
                                          <div class="row">
                                             <div class="col-xl-12">
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
                                          </div>
                                          

                                       </div>
                                      
                                    </div>
                                 </div>

                                             
                                          </div>
                                       </div>

                                  
                                       
                                      
                                     
                                       
                                    </div>
                                    
                                 
                              </div>
                             
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>

