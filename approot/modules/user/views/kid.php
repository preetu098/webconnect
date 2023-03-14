<div class="basic-form">
   <?php 
                                                  $spouse = $this->qm->all('ri_dependent_tbl','*',array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid,'reltype'=>$rel));
                                                  //$spouse = $this->qm->all('ri_dependent_tbl','*',array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid,'reltype'=>'Kid'));

                                                    foreach ($spouse as $spouse);

                                                   
                                                ?>
   <form method="POST" action="<?= base_url('user/addkid/');?><?= $cid;?>/<?= $pid;?>/<?= $eid;?>/<?= $rel;?>" enctype="multipart/form-data">
                                                
                                                <div class="row">
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">Name</label>
                                                      <input type="text" placeholder="Name" value="<?= !empty($spouse->name)?$spouse->name:'';?>" name="name" class="form-control">
                                                   </div>
                                                 <!--   <div class="mb-3 col-md-6">
                                                      <label class="form-label">Email</label>
                                                      <input type="email" placeholder="Email" value="<?= !empty($spouse->email)?$spouse->email:'';?>" name="email" class="form-control">
                                                   </div>
                                                      <div class="mb-3 col-md-6">
                                                      <label class="form-label">Mobile</label>
                                                      <input type="text" placeholder="Mobile" value="<?= !empty($spouse->phone)?$spouse->phone:'';?>" name="phone" class="form-control">
                                                   </div> -->
                                                      <div class="mb-3 col-md-6">
                                                      <label class="form-label">Gender</label>
                                                       <select class="form-control" name="gender">
                                                         <option>Select gender</option>
                                                         <option value="Male" <?= !empty($spouse->gender)?(($spouse->gender == 'Male')?'selected':''):'';?>>Male</option>
                                                         <option value="Female" <?= !empty($spouse->gender)?(($spouse->gender == 'Female')?'selected':''):'';?>>Female</option>
                                                         <option value="Others" <?= !empty($spouse->gender)?(($spouse->gender == 'Others')?'selected':''):'';?>>Others</option>
                                                     </select>
                                                   </div>
                                                  <!--  <div class="mb-3 col-md-6">
                                                      <label class="form-label">Wedding Date</label>
                                                        <input type="date" name="wedd_date" value="<?= !empty($spouse->wedd_date)?$spouse->wedd_date:'';?>" class="form-control" placeholder="Wedding Date">
                                                   </div> -->
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">DOB</label>
                                                       <input type="date" name="dob" id="dob2<?= $rel;?>" class="form-control" value="<?= !empty($spouse->dob)?$spouse->dob:'';?>" placeholder="Dob">
                                                   </div>
                                                    <div class="mb-3 col-md-6">
                                                      <label class="form-label">Age</label>
                                                       <input type="text" name="age" id="age2<?= $rel;?>" class="form-control" value="<?= !empty($spouse->age)?$spouse->age:'';?>" placeholder="Age">
                                                   </div>
                                                    
                                                   <input type="hidden" name="did" value="<?= !empty($spouse->did)?$spouse->did:0;?>">
                                               
                                                </div>
                                                
                                                
                                               
                                                <button class="btn btn-primary" type="submit">Update Me</button>
                                             </form>
</div>
