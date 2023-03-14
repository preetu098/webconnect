<div class="basic-form">
   <!--<form method="POST" action="<?= base_url('employee/updself/');?><?= $cid;?>/<?= $pid;?>/<?= $eid;?>" enctype="multipart/form-data">-->
                                                <?php 
                                                  $uemp = $this->qm->all('ri_employee_tbl','*',array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid));
                                                  //print_r($uemp);
                                                    foreach ($uemp as $uemp) {
                                                ?>
                                                <div class="row">
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">Name</label>
                                                      <input type="text" disabled style="background:#f8f8f8" placeholder="Name" value="<?= $uemp->name;?>" name="name" class="form-control">
                                                   </div>
                                                   <div class="mb-3 col-md-6">
                                                        <label class="form-label">Employee ID</label>
                                                        <input type="text" disabled class="form-control" style="background:#f8f8f8" value="<?= $uemp->emp_id;?>" placeholder="Your Employee ID">
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label">Health Card No.</label>
                                                        <input type="text" disabled class="form-control" style="background:#f8f8f8" value="<?= $uemp->card;?>" placeholder="Health Card No.">
                                                    </div>
                                                     <div class="mb-3 col-md-6">
                                                        <label class="form-label">Sum Insured</label>
                                                        <input type="text" disabled class="form-control" style="background:#f8f8f8" value="<?= $uemp->sum_insured;?>" placeholder="Contact HR to know">
                                                    </div>
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">Email</label>
                                                      <input type="email" placeholder="Email" disabled style="background:#f8f8f8" value="<?= $uemp->email;?>" name="email" class="form-control">
                                                   </div>
                                                      <div class="mb-3 col-md-6">
                                                      <label class="form-label">Mobile</label>
                                                      <input type="text" placeholder="Mobile" disabled style="background:#f8f8f8" value="<?= $uemp->mobile;?>" name="mobile" class="form-control">
                                                   </div>
                                                      <div class="mb-3 col-md-6">
                                                      <label class="form-label">Gender</label>
                                                       <select class="form-control" name="gender" disabled style="background:#f8f8f8">
                                                         <option>Select gender(<?php echo $uemp->gender?>)</option>
                                                         <option value="Male" <?= ($uemp->gender=='Male' || $uemp->gender=='M' || $uemp->gender=='male')?'selected':'';?>>Male</option>
                                                         <option value="Female" <?= ($uemp->gender=='Female' || $uemp->gender=='F')?'selected':'';?>>Female</option>
                                                         <option value="Others">Others</option>
                                                     </select>
                                                   </div>
                                                   <!--<div class="mb-3 col-md-6">
                                                      <label class="form-label">Wedding Date</label>
                                                        <input type="date" name="wedd_date" value="<?= $uemp->wedd_date;?>" class="form-control" placeholder="Wedding Date">
                                                   </div>-->
                                                   <div class="mb-3 col-md-6" >
                                                      <label class="form-label">DOB</label>
                                                       <input type="date" name="dob" disabled style="background:#f8f8f8" id="dob" class="form-control" value="<?= $uemp->dob?>" placeholder="Dob">
                                                   </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label">Date of Joining</label>
                                                        <input type="text" disabled class="form-control" style="background:#f8f8f8" value="<?= date_format(date_create($uemp->doj),"d-m-Y");?>" placeholder="Date of joining">
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                      <label class="form-label">Age</label>
                                                       <input type="text" name="age" id="age"  disabled style="background:#f8f8f8" class="form-control" value="<?= $uemp->age;?>" placeholder="Age">
                                                   </div>
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">Status</label>
                                                       <select class="form-control" disabled style="background:#f8f8f8">
                                                           <option value="1" <?=($uemp->status != '0' && $emp->mode != 'New Addition')?"selected":"";?>>Active</option>
                                                           <option value="0" <?=($uemp->status == '0' || $emp->mode == 'New Addition')?"selected":"";?>> In Active</option>
                                                           </select>
                                                   </div>
                                                    <!--<div class="mb-3 col-md-12">
                                                      <div class="row">
                                                         <div class="col-xl-8">
                                                      <label class="form-label">Upload Adhar in case of Name/DOB/Gender correction</label>
                                                       <input type="file" disabled style="background:#f8f8f8" name="pimage" class="form-control">
                                                        </div>
                                                        
                                                        </div>
                                                   </div>-->
                                               
                                                </div>
                                                <?php } ?>
                                                
                                               <?php if($uemp->status != 2): ?>
                                                <a href="javascript:;" onclick="location.href = '<?= base_url('employee/dependents/'.$cid.'/'.$pid.'/'.$eid);?>?type=Self';" class="btn btn-primary"> Need Correction? </a>
                                                
                                                <?php if($uemp->status ==4 || $uemp->status==3): ?>
                                                <button type="button" class="btn btn-danger"><?php echo getStatusMap($uemp->status); ?></button>
                                                <?php endif; ?>
                                                <?php else: ?>
                                                   <button disabled class="btn btn-primary"><?php echo getEmployeeStatus($uemp->eid, 'Self')['statustext']; ?></a>
                                                <?php endif; ?>
                                            <!-- </form>-->
</div>
