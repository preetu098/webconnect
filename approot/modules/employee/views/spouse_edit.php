<div class="content-bod" style="background:#fff;">
            
			<div class="container-fluid">
					<div class="row">
							<div class="col-xl-12 card-body">
								

<div class="basic-form">
   <?php 
                                                  $spouse = $this->qm->all('ri_dependent_tbl','*',array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid,'reltype'=>'Spouse'));

                                                    foreach ($spouse as $spouse);

                                                   
                                                ?>
   <form method="POST" action="<?= base_url('employee/adddep/'); ?><?= $cid; ?>/<?= $pid; ?>/<?= $eid; ?>" enctype="multipart/form-data">
                                                
                                                <div class="row">
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">Name</label>
                                                      <input type="text" placeholder="Name" value="<?= !empty($spouse->name)?$spouse->name:'';?>" name="name" class="form-control" required>
                                                   </div>
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">Email</label>
                                                      <input type="email" placeholder="Email" value="<?= !empty($spouse->email)?$spouse->email:'';?>" name="email" class="form-control" required>
                                                   </div>
                                                      <div class="mb-3 col-md-6">
                                                      <label class="form-label">Mobile</label>
                                                      <input type="text" placeholder="Mobile" value="<?= !empty($spouse->phone)?$spouse->phone:'';?>" name="phone" class="form-control" required>
                                                   </div>
                                                      <div class="mb-3 col-md-6">
                                                      <label class="form-label">Gender</label>
                                                       <select class="form-control" name="gender" required>
                                                         <option value="">Select gender</option>
                                                         <option value="Male" <?= !empty($spouse->gender)?(($spouse->gender == 'Male')?'selected':''):'';?>>Male</option>
                                                         <option value="Female" <?= !empty($spouse->gender)?(($spouse->gender == 'Female')?'selected':''):'';?>>Female</option>
                                                         <option value="Others" <?= !empty($spouse->gender)?(($spouse->gender == 'Others')?'selected':''):'';?>>Others</option>
                                                     </select>
                                                   </div>
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">Wedding Date</label>
                                                        <input type="date" name="wedd_date" value="<?= !empty($spouse->wedd_date)?$spouse->wedd_date:'';?>" class="form-control" placeholder="Wedding Date">
                                                   </div>
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">DOB</label>
                                                       <input type="date" name="dob" id="dob2" class="form-control" value="<?= !empty($spouse->dob)?$spouse->dob:'';?>" placeholder="Dob" required>
                                                   </div>
                                                    <div class="mb-3 col-md-6">
                                                      <label class="form-label">Age</label>
                                                       <input type="number" name="age" id="age2" class="form-control" value="<?= !empty($spouse->age)?$spouse->age:'';?>" placeholder="Age" required>
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
                                                   <input type="hidden" name="reltype" value="Spouse">
                                                </div>
                                                <?php if ($spouse->name) { ?>
                                                <?php if ($spouse->status != 2) : ?>
                                                   <input type="hidden" style="background:#f8f8f8" name="mode" value="Correction">
                                                   <button class="btn btn-primary" type="submit">UPDATE SPOUSE</button>
                                                   <a href="javascript:;" onclick="deleterec2(<?php echo $did; ?>,<?php echo $pid; ?>,<?php echo $cid; ?>,<?php echo $eid; ?>)" class="btn btn-primary" type="button">Delete</a>
                                                <?php else : ?>
                                                   <button disabled class="btn btn-primary" type="button"><?php echo getEmployeeStatus($spouse->did, 'Spouse')['statustext']; ?></button>
                                                <?php endif; ?>
                                             <?php } else { ?>
                                                <input type="hidden" style="background:#f8f8f8" name="mode" value="New Addition">
                                                <button class="btn btn-primary" type="submit">ADD SPOUSE</button>
                                             <?php } ?>
                                             </form>
                                   </div>
                                   
                                   
                                   </div></div></div></div>
