
<div class="content-bod" style="background:#fff;">
            
			<div class="container-fluid">
					<div class="row">
							<div class="col-xl-12 card-body">
							    
							    
<div class="basic-form">
   <?php 
                                                  //$spouse = $this->qm->all('ri_dependent_tbl','*',array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid,'reltype'=>'Kid'));

                                                    foreach ($spouse as $spouse);

                                                   
                                                ?>
   <form method="POST" action="<?= base_url('employee/adddep/'); ?><?= $cid; ?>/<?= $pid; ?>/<?= $eid; ?>" enctype="multipart/form-data">
                                                
                                                <div class="row">
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">Name</label>
                                                      <input type="text" placeholder="Name" required value="<?= !empty($spouse->name)?$spouse->name:'';?>" name="name" class="form-control">
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
                                                       <select required class="form-control" name="gender">
                                                         <option value="">Select gender</option>
                                                         <option value="Male" <?= ($spouse->gender == 'Male')?'selected':''?>>Male</option>
                                                         <option value="Female" <?= ($spouse->gender == 'Female')?'selected':'';?>>Female</option>
                                                         <option value="Others" >Others</option>
                                                     </select>
                                                   </div>
                                                  <!--  <div class="mb-3 col-md-6">
                                                      <label class="form-label">Wedding Date</label>
                                                        <input type="date" name="wedd_date" value="<?= !empty($spouse->wedd_date)?$spouse->wedd_date:'';?>" class="form-control" placeholder="Wedding Date">
                                                   </div> -->
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">DOB</label>
                                                       <input type="date" required name="dob" id="dob2<?= $rel;?>" class="form-control" value="<?= !empty($spouse->dob)?$spouse->dob:'';?>" placeholder="Dob">
                                                   </div>
                                                    <div class="mb-3 col-md-6">
                                                      <label class="form-label">Age</label>
                                                       <input type="text" required name="age" id="age2<?= $rel;?>" class="form-control" value="<?= isset($spouse->age)?$spouse->age:'';?>" placeholder="Age">
                                                   </div>

                                                   <?php if(!empty($spouse->did)): ?>
                                                      <div class="mb-3 col-md-8">
                                                         <div class="row">
                                                            <div class="col-xl-10">
                                                                  <label class="form-label">Upload Aadhar in case of Name/DOB/Gender correction</label>
                                                                  <input type="file" name="pimage" class="form-control">
                                                            </div>
                                                            <?php if(!empty($spouse->pimage)): ?>
                                                            <div class="col-xl-2">
                                                                  <img src="<?= base_url('external/uploads/'.$spouse->pimage) ?>" height="50" style="width:100px">
                                                                  </div>
                                                            <?php endif; ?>
                                                         </div>
                                                      </div>
                                                   <div class="mb-3 col-md-12">
                                                      <div class="row">
                                                         <div class="col-xl-8">
                                                      <label class="form-label">Reason</label>
                                                       <input type="text"  name="reson" value="<?= !empty($spouse->reson)?$spouse->reson:'';?>" class="form-control">
                                                        </div>
                                                        
                                                        </div>
                                                   </div>
                                                   <?php endif; ?>
                                                    
                                                   <?php
                                                      $did = !empty($spouse->did) ? $spouse->did : 0;
                                                   ?>
                                                   <input type="hidden" style="background:#f8f8f8" name="did" value="<?= $did; ?>">
                                                   <input type="hidden" name="emp_id" value="<?= (isset($emp_id)) ? $emp_id : '' ?>">
                                                   <input type="hidden" name="reltype" value="Kid">
                                               
                                                </div>
                                                
                                                
                                               
                                                <?php
                                             if($spouse->name){
                                                ?>
                                                <?php if ($spouse->status != 2) : ?>
                                                   <input type="hidden" name="mode" value="Correction">
                                                   <button class="btn btn-primary" type="submit">Update KID</button>
                                                   <a href="javascript:;" onclick="deleterec2(<?php echo $did; ?>,<?php echo $pid; ?>,<?php echo $cid; ?>,<?php echo $eid; ?>)" class="btn btn-primary" type="submit">Delete</a>
                                                <?php else: ?>
                                                   <button disabled class="btn btn-primary" type="button"><?php echo getEmployeeStatus($spouse->did, 'Kid')['statustext']; ?></button>
                                                <?php endif; ?>
                                             <?php  }else{ ?>
                                             <input type="hidden" name="mode" value="New Addition">
                                             <button class="btn btn-primary" type="submit">ADD KID</button>
                                             <?php } ?>
                                             </form>
</div>
</div></div></div></div>