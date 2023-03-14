
         <!--**********************************
            Content body start
            ***********************************-->
         <div class="content-body">
            <div class="container-fluid">
               <div class="row page-titles">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item active"><a href="javascript:void(0)">Clients</a></li>
                     <li class="breadcrumb-item"><a href="javascript:void(0)">Client Detail</a></li>
                     <?php 
                        $pol = $this->qm->all('ri_clientpolicy_tbl','*',array('id'=>$pid));
                        foreach($pol as $pol);

                     ?>
                     <li class="breadcrumb-item"><a href="javascript:void(0)"><?= ($pol->policy_num==5283)?'Data Collection':$pol->policy_num;?></a></li>
                  </ol>
                 
               </div>
               <!-- row -->
               <div class="row">
                  <?php 
                     $client = $this->qm->all('ri_clients_tbl','*',array('cid'=>$cid));
                     foreach($client as $client);
                  ?>
                  <div class="col-lg-5">
                     <div class="card overflow-hidden">
                     <div class="text-center p-3 overlay-box " style="background-image: url(<?= base_url('external/uploads/');?><?= $client->image;?>); background-repeat: no-repeat;background-size: cover; background-position: center;">
                        <div class="profile-photo">
                           <img src="<?= base_url('external/uploads/');?><?= $client->image;?>" class="img-fluid rounded-circle" alt="" width="100">
                        </div>
                        <h3 class="mt-3 mb-1 text-white"><?= $client->cname;?></h3>
                        <p class="text-white mb-0"><?= $client->ccode;?></p>
                     </div>
                     <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Last Login</span> <strong class="text-muted"><?php 
                            if($client->last_login==NULL){
                          ?><span class="badge bg-danger">Offline</span>
<?php }
                        else{ ?>
<?= $client->last_login;?>
<?php } ?>  </strong></li>
                         <li class="list-group-item d-flex justify-content-between"><a target="_blank" href="<?= base_url('client/index');?>" class="btn btn-success"><span class="btn-icon-start text-success"><i class="fa fa-lock"></i>
                                    </span>Hr Login</a>
                                    <a href="<?= base_url('user/register/');?><?= $cid;?>/<?= $pid;?>" target="_blank" class="btn btn-info"><span class="btn-icon-start text-info"><i class="fa fa-user"></i>
                                    </span>Employee Register</a> 
                                    <a  href="<?= base_url('clients/employees');?>/<?= $cid;?>/<?= $pid;?>" class="btn btn-success" aria-expanded="false"><span class="btn-icon-start text-success"><i class="fa fa-users"></i>
                                    </span>Employees </a></li>

                     
                     </ul>
                           
                        </div>
                  </div>
                  <div class="col-lg-7">
                     <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Welcome Message</h4>
                                <a href="<?= base_url('clients/message');?>/<?= $cid;?>/<?= $pid;?>" class="btn btn-dark">Add Message</a>
                            </div>
                            <div class="card-body">
                                <!-- Nav tabs -->
                                <div class="default-tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <?php 
                                          $a=1;
                                          $well = $this->qm->all("welcomemsg_tbl","*",array('cid'=>$cid,'pid'=>$pid));
                                          foreach ($well as $well) {
                                            
                                      ?>       
                                        <li class="nav-item">
                                            <a class="nav-link <?= ($a == 1)?'active':'';?>" data-bs-toggle="tab" href="#message<?= $well->id;?>"><i class="la la-envelope me-2"></i>   <?= $well->type;?></a>
                                        </li>
                                     <?php $a++; } ?>
                                    </ul>
                                    <div class="tab-content">
                                        <?php 
                                        $ab= 1;
                                          $well = $this->qm->all("welcomemsg_tbl","*",array('cid'=>$cid,'pid'=>$pid));
                                          foreach ($well as $well) {
                                            
                                      ?>    
                                        <div class="tab-pane fade <?= ($ab == 1)?'show active':'';?>" id="message<?= $well->id;?>">
                                            <div class="pt-4">
                                                
                                                <?= $well->msg;?><br>
                                                <a href="<?= base_url('clients/editmessage');?>/<?= $well->id;?>/<?= $cid;?>/<?= $pid;?>" class="btn btn-primary">
                                                   <i class="fas fa-pencil-alt"></i> Edit</a>
                                            </div>
                                        </div>
                                        
                                     <?php 
                                  $ab++;
                                  }?>
                                    </div>
                                </div>
                            </div>
                        </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-lg-3">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Relation List</h4>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#addrelation">  Add Relation</button>
                                <div class="modal fade" id="addrelation" data-bs-backdrop="addrelation" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addrelationBackdropLabel" aria-hidden="true">
                       <div class="modal-dialog">
                         <div class="modal-content">
                         <form class="form-group" method="POST" action="<?= base_url('clients/addrelation');?>/<?= $cid;?>/<?= $pid;?>">
                           <div class="modal-body">

                      
                                <div class="row">
                                   <div class="col-lg-12">
                                       <label class="form-label">Relation Type</label>
                                      
                                       <select class="form-control" name="reltype">
                                           
                                           <option>Select Relation</option>
                                           <option value="Self">Self</option>
                                           <option value="Spouse">Spouse</option>
                                           <option value="Kid">Kid</option>
                                           <option value="Mother">Mother</option>
                                           <option value="Father">Father</option>
                                           <option value="Mother In Law">Mother In Law</option>
                                           <option value="Father In Law">Father In Law</option>
                                       </select>
                                   </div>
                                   <div class="col-lg-6">
                                       <label class="form-label">Max Entries</label>
                                       <input type="text" name="max_entry" value="" class="form-control">
                                   </div>
                                   <div class="col-lg-6">
                                       <label class="form-label">Is Publish</label>
                                       <select class="form-control" name="is_publish">
                                          <option>Select</option>
                                          <option value="1">Yes</option>
                                          <option value="0">No</option>
                                       </select>
                                    
                                   </div>
                                   
                                </div>
                             
                            
                           </div>
                           <div class="modal-footer">
                             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                             <button type="submit" class="btn btn-primary">Update</button>
                           </div>
                           </form>
                         </div>
                       </div>
                     </div>
                            </div>
                            <div class="card-body">
                                <div class="basic-list-group">
                                    <div class="row">
                                        <div class="col-lg-6 col-xl-6">
                                            <div class="list-group mb-4 " id="list-tab" role="tablist">
                                              <?php
                                              $r=1;
                          $rel = $this->qm->all('fm_relation_tbl','*',array('cid'=>$cid,'pid'=>$pid));
                          foreach ($rel as $rel) {
                           
                        ?>  
                                             <a class="list-group-item list-group-item-action <?= ($r == 1)?'active':'';?>" id="list-home-list" data-bs-toggle="list" href="#relation<?= $rel->id;?>" role="tab" aria-selected="true"><?= $rel->reltype;?></a>
                                          <?php $r++; } ?>
                                           <!--   <a class="list-group-item list-group-item-action" id="list-profile-list" data-bs-toggle="list" href="#list-profile" role="tab" aria-selected="false">Profile</a> 

                                             <a class="list-group-item list-group-item-action" id="list-messages-list" data-bs-toggle="list" href="#list-messages" role="tab" aria-selected="false">Messages</a>

                                             <a class="list-group-item list-group-item-action" id="list-settings-list" data-bs-toggle="list" href="#list-settings" role="tab" aria-selected="false">Settings</a> -->
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-xl-6">
                                            <div class="tab-content" id="nav-tabContent">
                                               <?php
                                               $aa=1;
                          $rel = $this->qm->all('fm_relation_tbl','*',array('cid'=>$cid,'pid'=>$pid));
                          foreach ($rel as $rel) {
                           
                        ?>  
                                                <div class="tab-pane fade <?= ($aa == 1)?'show active':'';?>" id="relation<?= $rel->id;?>">
                                                    <h4 class="mb-4">Max Entry : <?= $rel->max_entry;?></h4>
                                                    <h4 class="mb-4">Is Publish : <?= $rel->is_publish==1?'<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">Inactive</span>';?></h4>
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#static<?= $rel->id;?>"> <i class="fas fa-pencil-alt"></i> Edit</button>
                                                   <div class="modal fade" id="static<?= $rel->id;?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                       <div class="modal-dialog">
                         <div class="modal-content">
                         <form class="form-group" method="POST" action="<?= base_url('clients/updrelation');?>/<?= $rel->id;?>/<?= $cid;?>/<?= $pid;?>">
                           <div class="modal-body">

                            <?php 
                        $rt = $this->qm->all("fm_relation_tbl","*",array('id'=>$rel->id));
                        foreach ($rt as $rt) {
                          
                    ?>
                                <div class="row">
                                   <div class="col-lg-12">
                                       <label class="form-label">Relation Type</label>
                                        <select class="form-control" name="reltype">
                                           
                                           <option>Select Relation</option>
                                           <option value="Self" <?= ($rt->reltype=='Self')?'selected':'';?>>Self</option>
                                           <option value="Spouse" <?= ($rt->reltype=='Spouse')?'selected':'';?>>Spouse</option>
                                           <option value="Kid" <?= ($rt->reltype=='Kid')?'selected':'';?>>Kid</option>
                                           <option value="Mother" <?= ($rt->reltype=='Mother')?'selected':'';?>>Mother</option>
                                           <option value="Father" <?= ($rt->reltype=='Father')?'selected':'';?>>Father</option>
                                           <option value="Mother In Law" <?= ($rt->reltype=='Mother In Law')?'selected':'';?>>Mother In Law</option>
                                           <option value="Father In Law" <?= ($rt->reltype=='Father In Law')?'selected':'';?>>Father In Law</option>
                                       </select>
                                   </div>
                                   <div class="col-lg-6">
                                       <label class="form-label">Max Entries</label>
                                       <input type="text" name="max_entry" value="<?= $rt->max_entry;?>" class="form-control">
                                   </div>
                                   <div class="col-lg-6">
                                       <label class="form-label">Is Publish</label>
                                       <select class="form-control" name="is_publish">
                                          <option>Select</option>
                                          <option value="1"<?= $rt->is_publish==1?'selected':'';?>>Yes</option>
                                          <option value="0"<?= $rt->is_publish==0?'selected':'';?>>No</option>
                                       </select>
                                    
                                   </div>
                                   
                                </div>
                             <?php } ?>
                            
                           </div>
                           <div class="modal-footer">
                             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                             <button type="submit" class="btn btn-primary">Update</button>
                           </div>
                           </form>
                         </div>
                       </div>
                     </div>
                                                </div>
                                             <?php
$aa++;
                                              }?>
                                              
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="col-lg-9">
                        <div class="card">
                           <div class="card-header d-block">

                              <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><span class="btn-icon-start text-primary"><i class="fa fa-file-powerpoint"></i>
                                    </span>PPT </button>
                                    <div class="dropdown-menu" style="margin: 0px;">
                                        <button type="button" onclick="getForm(this.value, <?= $cid;?>, <?= $pid;?>)" class="dropdown-item" value="1">Add PPT</button>
                                        <button type="button" onclick="getForm(this.value, <?= $cid;?>, <?= $pid;?>)" class="dropdown-item" value="2">View PPT</button>
                                    </div>
                              </div>
                              <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><span class="btn-icon-start text-primary"><i class="fa fa-comments"></i>
                                    </span>FAQ </button>
                                    <div class="dropdown-menu" style="margin: 0px;">
                                        <button type="button" onclick="getForm(this.value, <?= $cid;?>, <?= $pid;?>)" class="dropdown-item" value="3">Add</button>
                                        <button type="button" onclick="getForm(this.value, <?= $cid;?>, <?= $pid;?>)" class="dropdown-item" value="4">View</button>
                                    </div>
                              </div>
                              <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><span class="btn-icon-start text-primary"><i class="fa fa-images"></i>
                                    </span>Upload Banner </button>
                                    <div class="dropdown-menu" style="margin: 0px;">
                                        <button type="button" onclick="getForm(this.value, <?= $cid;?>, <?= $pid;?>)" class="dropdown-item" value="5">Banner</button>
                                        
                                    </div>
                              </div>
                              
                              <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><span class="btn-icon-start text-primary"><i class="fa fa-question"></i>
                                    </span>Claim Process </button>
                                    <div class="dropdown-menu" style="margin: 0px;">
                                        <button type="button" onclick="getForm(this.value, <?= $cid;?>, <?= $pid;?>)" class="dropdown-item" value="6">Add</button>
                                        <button type="button" onclick="getForm(this.value, <?= $cid;?>, <?= $pid;?>)" class="dropdown-item" value="7">View</button>
                                    </div>
                              </div>
                               <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><span class="btn-icon-start text-primary"><i class="fa fa-file"></i>
                                    </span>Client Document </button>
                                    <div class="dropdown-menu" style="margin: 0px;">
                                        <button type="button" onclick="getForm(this.value, <?= $cid;?>, <?= $pid;?>)" class="dropdown-item" value="8">Add</button>
                                        <button type="button" onclick="getForm(this.value, <?= $cid;?>, <?= $pid;?>)" class="dropdown-item" value="9">View</button>
                                    </div>
                              </div>
                                
                           </div>
                          
                            <div class="card-body" id="dem">
                                  <?php 
                                 if(!empty($this->session->flashdata('success'))){

                                    $success = $this->session->flashdata('success');
                              ?>
                           <div class="alert alert-success alert-dismissible fade show" style="width: 25%;">

                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                              </button>
                              <strong>Success!</strong><?= $success;?>
                           </div>
                        <?php }
                        else if(!empty($this->session->flashdata('error'))){
                           $error = $this->session->flashdata('error');
                         ?>
                          <div class="alert alert-danger alert-dismissible fade show" style="width: 25%;">

                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                              </button>
                              <strong>Error!</strong> <?= $error;?>
                           </div>
                         <?php }else{} ?> 
                            </div>
                        </div>
                     </div>
               </div>
            </div>
         </div>
         <!--**********************************
            Content body end
            ***********************************-->
         <!--**********************************
            Footer start
            ***********************************-->

<script type="text/javascript">
    function getForm(val,cid,pid) {
      
       $.ajax({

          method:"GET",
          url:"<?= base_url('clients/getform/');?>"+val+'/'+cid+'/'+pid,
          dataType: 'html',
          success:function(data){

              $('#dem').html(data);
             
          }

      });

   }
</script>