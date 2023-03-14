<div class="basic-form">
   <?php 
                                                  $spouse = $this->qm->all('ri_dependent_tbl','*',array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid,'reltype'=>'Father'));

                                                    foreach ($spouse as $spouse);

                                                   
                                                ?>
   <?php $did = !empty($spouse->did)?$spouse->did:0; ?>
   <form method="POST" action="<?= base_url('employee/father/');?><?= $cid;?>/<?= $pid;?>/<?= $eid;?>" enctype="multipart/form-data">
                                                <div class="row">
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">Name</label>
                                                      <input type="text" placeholder="Name" disabled="" style="background:#f8f8f8" value="<?= !empty($spouse->name)?$spouse->name:'';?>" name="name" class="form-control" required>
                                                   </div>
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">Email</label>
                                                      <input type="email" placeholder="Email" disabled="" style="background:#f8f8f8" value="<?= !empty($spouse->email)?$spouse->email:'';?>" name="email" class="form-control" required>
                                                   </div>
                                                      <div class="mb-3 col-md-6">
                                                      <label class="form-label">Mobile</label>
                                                      <input type="number" placeholder="Mobile" disabled="" style="background:#f8f8f8" value="<?= !empty($spouse->phone)?$spouse->phone:'';?>" name="phone" class="form-control" required>
                                                   </div>
                                                      <div class="mb-3 col-md-6">
                                                      <label class="form-label">Gender</label>
                                                       <select class="form-control" name="gender" disabled="" style="background:#f8f8f8" required>
                                                         <option value="">Select gender</option>
                                                         <option value="Male" <?= !empty($spouse->gender)?(($spouse->gender == 'Male')?'selected':''):'';?>>Male</option>
                                                         <option value="Female" <?= !empty($spouse->gender)?(($spouse->gender == 'Female')?'selected':''):'';?>>Female</option>
                                                         <option value="Others" <?= !empty($spouse->gender)?(($spouse->gender == 'Others')?'selected':''):'';?>>Others</option>
                                                     </select>
                                                   </div>
                                                   
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">DOB</label>
                                                       <input type="date" name="dob" id="dob5" class="form-control" value="<?= !empty($spouse->dob)?$spouse->dob:'';?>" placeholder="Dob" required>
                                                   </div>
                                                    <div class="mb-3 col-md-6">
                                                      <label class="form-label">Age</label>
                                                       <input type="text" name="age" disabled="" style="background:#f8f8f8" id="age5" class="form-control" value="<?= !empty($spouse->age)?$spouse->age:'';?>" placeholder="Age" required>
                                                   </div>
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">Status</label>
                                                       <select class="form-control" disabled style="background:#f8f8f8">
                                                       <option value="1" <?=($spouse->status != '0' && $spouse->mode != 'New Addition')?"selected":"";?>>Active</option>
                                                           <option value="0" <?=($spouse->status == '0' || $spouse->mode == 'New Addition')?"selected":"";?>> In Active</option>
                                                           </select>
                                                   </div>
                                                    
                                                   <input type="hidden" name="did" value="<?= !empty($spouse->did)?$spouse->did:0;?>">
                                               
                                                </div>
                                                
                                                <?php if($spouse->status != 2): ?>
                                                   <a href="javascript:;" onclick="location.href = '<?= base_url('employee/dependents/'.$cid.'/'.$pid.'/'.$eid);?>?type=Father';" class="btn btn-primary"> Need Correction? </a>
                                                   <?php if($spouse->status ==4 || $spouse->status==3): ?>
                                                <button type="button" class="btn btn-danger"><?php echo getStatusMap($spouse->status); ?></button>
                                                <?php endif; ?>
                                                <?php else: ?>
                                                   <button disabled class="btn btn-primary"><?php echo getEmployeeStatus($spouse->did, 'Father')['statustext']; ?></a>
                                                <?php endif; ?>
                                                
                                             </form>
</div>
<script>
    function deleterec()
    {
        if(confirm('Do you want to delete mother?')==true){
             window.location='<?=base_url('employee/delfather/'.$cid.'/'.$pid.'/'.$eid)?>';
        }
    }
</script>