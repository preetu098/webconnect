<div class="basic-form">
   <?php 
                                                  $spouse = $this->qm->all('ri_dependent_tbl','*',array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid,'reltype'=>'Spouse'));

                                                    foreach ($spouse as $spouse);

                                                   
                                                ?>
   <form method="POST" action="<?= base_url('employee/updspouse/');?><?= $cid;?>/<?= $pid;?>/<?= $eid;?>" enctype="multipart/form-data">
                                                
                                                <div class="row">
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">Name</label>
                                                      <input type="text" placeholder="Name"  disabled="" style="background:#f8f8f8" value="<?= !empty($spouse->name)?$spouse->name:'';?>" name="name" class="form-control" required>
                                                   </div>
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">Email</label>
                                                      <input type="email" placeholder="Email"  disabled="" style="background:#f8f8f8" value="<?= !empty($spouse->email)?$spouse->email:'';?>" name="email" class="form-control" required>
                                                   </div>
                                                      <div class="mb-3 col-md-6">
                                                      <label class="form-label">Mobile</label>
                                                      <input type="text" placeholder="Mobile"  disabled="" style="background:#f8f8f8" value="<?= !empty($spouse->phone)?$spouse->phone:'';?>" name="phone" class="form-control" required>
                                                   </div>
                                                      <div class="mb-3 col-md-6">
                                                      <label class="form-label">Gender</label>
                                                       <select class="form-control"  disabled="" style="background:#f8f8f8" name="gender" required>
                                                         <option value="">Select gender</option>
                                                         <option value="Male" <?= ($spouse->gender == 'Male' || $spouse->gender == 'M')?'selected':'';?>>Male</option>
                                                         <option value="Female" <?= ($spouse->gender == 'Female' || $spouse->gender == 'F')?'selected':''?>>Female</option>
                                                         <option value="Others" >Others</option>
                                                     </select>
                                                   </div>
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">Wedding Date</label>
                                                        <input type="date" name="wedd_date"  disabled="" style="background:#f8f8f8" value="<?= !empty($spouse->wedd_date)?$spouse->wedd_date:'';?>" class="form-control" placeholder="Wedding Date" required>
                                                   </div>
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">DOB</label>
                                                       <input type="date" name="dob"  disabled="" style="background:#f8f8f8" id="dob1" class="form-control" value="<?= !empty($spouse->dob)?$spouse->dob:'';?>" placeholder="Dob" required>
                                                   </div>
                                                    <div class="mb-3 col-md-6">
                                                      <label class="form-label">Age</label>
                                                       <input type="text" name="age" id="age1"  disabled="" style="background:#f8f8f8" class="form-control" value="<?= !empty($spouse->age)?$spouse->age:'';?>" placeholder="Age" required>
                                                   </div>
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">Status</label>
                                                       <select class="form-control" disabled style="background:#f8f8f8">
                                                           <option value="1" <?=($spouse->status != '0' && $spouse->mode != 'New Addition')?"selected":"";?>>Active</option>
                                                           <option value="0" <?=($spouse->status == '0' || $spouse->mode == 'New Addition')?"selected":"";?>> In Active</option>
                                                           </select>
                                                   </div>
                                                   <?php $did = !empty($spouse->did)?$spouse->did:0; ?>
                                                    
                                                   <input type="hidden"  disabled="" style="background:#f8f8f8" name="did" value="<?= $did; ?>">
                                               
                                                </div>

                                                <?php if($spouse->status != 2): ?>
                                                   <a href="javascript:;" onclick="location.href = '<?= base_url('employee/dependents/'.$cid.'/'.$pid.'/'.$eid);?>?type=Spouse';" class="btn btn-primary"> Need Correction? </a>
                                                   <?php if($spouse->status ==4 || $spouse->status==3): ?>
                                                <button type="button" class="btn btn-danger"><?php echo getStatusMap($spouse->status); ?></button>
                                                <?php endif; ?>
                                                <?php else: ?>
                                                   <button disabled class="btn btn-primary"><?php echo getEmployeeStatus($spouse->did, 'Spouse')['statustext']; ?></a>
                                                <?php endif; ?>
                                               
                                                <!--<button class="btn btn-primary" type="submit">Update Me</button>-->
                                             </form>
</div>

<!-- <script>
    function deleterec(did)
    {
        if(confirm('Attention! By clicking here Depandant details will be qued for Deletion Endorsement!!')==ture){
        window.location='<?=base_url('employee/delspouse/'.$cid.'/'.$pid.'/'.$eid)?>?did='+did;
        }
    }
</script> -->
