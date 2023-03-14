

<div class="basic-form">
   <?php 
                                                //   $spouse = $this->qm->all('ri_dependent_tbl','*',array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid,'reltype'=>$rel));
                                                  //$spouse = $this->qm->all('ri_dependent_tbl','*',array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid,'reltype'=>'Kid'));

                                                    foreach ($spouse as $spouse);

                                                   
                                                ?>
   
                                                
                                                <div class="row">
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">Name</label>
                                                      <input type="text" placeholder="Name" disabled="" style="background:#f8f8f8" value="<?= !empty($spouse->name)?$spouse->name:'';?>" name="name" class="form-control">
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
                                                       <select class="form-control" name="gender"  disabled="" style="background:#f8f8f8">
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
                                                       <input type="date" name="dob" disabled="" style="background:#f8f8f8" id="dob2<?= $rel;?>" class="form-control" value="<?= !empty($spouse->dob)?$spouse->dob:'';?>" placeholder="Dob">
                                                   </div>
                                                    <div class="mb-3 col-md-6">
                                                      <label class="form-label">Age</label>
                                                       <input type="text" name="age" disabled="" style="background:#f8f8f8" id="age2<?= $rel;?>" class="form-control" value="<?= !empty($spouse->age)?$spouse->age:'';?>" placeholder="Age">
                                                   </div>
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">Status</label>
                                                       <select class="form-control" disabled style="background:#f8f8f8">
                                                            <option value="1" <?=($spouse->status != '0' && $spouse->mode != 'New Addition')?"selected":"";?>>Active</option>
                                                           <option value="0" <?=($spouse->status == '0' || $spouse->mode == 'New Addition')?"selected":"";?>> In Active</option>
                                                           </select>
                                                   </div>
                                                    <?php
                                                        $did = !empty($spouse->did)?$spouse->did:0;
                                                    ?>
                                                   <input type="hidden" name="did" value="<?= $did; ?>">
                                               
                                                </div>
                                                
                                                <?php if($spouse): ?>
                                                  <?php if($spouse->status != 2): ?>
                                                    <a href="javascript:;" onclick="location.href = '<?= base_url('employee/dependents/'.$cid.'/'.$pid.'/'.$eid);?>?type=Kid';" class="btn btn-primary"> Need Correction? </a>
                                                    <?php if($spouse->status ==4 || $spouse->status==3): ?>
                                                <button type="button" class="btn btn-danger"><?php echo getStatusMap($spouse->status); ?></button>
                                                <?php endif; ?>
                                                  <?php else: ?>
                                                    <button disabled class="btn btn-primary"><?php echo getEmployeeStatus($spouse->did, 'Kid')['statustext']; ?></a>
                                                  <?php endif; ?>
                                                <?php else: ?>
                                                  <a href="javascript:;" onclick="location.href = '<?= base_url('employee/dependents/'.$cid.'/'.$pid.'/'.$eid);?>?type=Kid';" class="btn btn-primary"> Add Kid </a>
                                                <?php endif; ?>
                                               
                                                <!--<a href="base_url('employee/addkid/'.$cid.'/'.$pid.'/'.$eid.'/'.$rel->reltype)" class="btn btn-primary" type="submit">Update Me</a>-->
                                                
                                                 
                                                
                                     
</div>

<script>
    function deleterec(did)
    {
        if(confirm('Do you want to delete kid?')==true){
            window.location='<?=base_url('employee/delkid/'.$cid.'/'.$pid.'/'.$eid.'/Kid')?>?did='+did;
        }
    }
</script>

