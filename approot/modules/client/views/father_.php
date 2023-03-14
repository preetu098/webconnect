<div class="basic-form">
   <?php 
                                                  $spouse = $this->qm->all('ri_dependent_tbl','*',array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid,'reltype'=>'Father'));

                                                    foreach ($spouse as $spouse);

                                                   
                                                ?>
   
                                                
                                                <div class="row">
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">Name</label>
                                                      <input type="text" placeholder="Name" disabled="" style="background:#f8f8f8" value="<?= !empty($spouse->name)?$spouse->name:'';?>" name="name" class="form-control">
                                                   </div>
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">Email</label>
                                                      <input type="email" placeholder="Email" disabled="" style="background:#f8f8f8" value="<?= !empty($spouse->email)?$spouse->email:'';?>" name="email" class="form-control">
                                                   </div>
                                                      <div class="mb-3 col-md-6">
                                                      <label class="form-label">Mobile</label>
                                                      <input type="text" placeholder="Mobile" disabled="" style="background:#f8f8f8" value="<?= !empty($spouse->phone)?$spouse->phone:'';?>" name="phone" class="form-control">
                                                   </div>
                                                      <div class="mb-3 col-md-6">
                                                      <label class="form-label">Gender</label>
                                                       <select class="form-control" name="gender" disabled="" style="background:#f8f8f8">
                                                         <option>Select gender</option>
                                                         <option value="Male" <?= !empty($spouse->gender)?(($spouse->gender == 'Male')?'selected':''):'';?>>Male</option>
                                                         <option value="Female" <?= !empty($spouse->gender)?(($spouse->gender == 'Female')?'selected':''):'';?>>Female</option>
                                                         <option value="Others">Others</option>
                                                     </select>
                                                   </div>
                                                   
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">DOB</label>
                                                       <input type="date" name="dob" id="dob5" class="form-control" value="<?= !empty($spouse->dob)?$spouse->dob:'';?>" placeholder="Dob">
                                                   </div>
                                                    <div class="mb-3 col-md-6">
                                                      <label class="form-label">Age</label>
                                                       <input type="text" name="age" disabled="" style="background:#f8f8f8" id="age5" class="form-control" value="<?= !empty($spouse->age)?$spouse->age:'';?>" placeholder="Age">
                                                   </div>
                                                    
                                                   <input type="hidden" name="did" value="<?= !empty($spouse->did)?$spouse->did:0;?>">
                                               
                                                </div>
                                                
                                                
                                               
                                               <!-- <a href="<?=base_url('employee/father/'.$cid.'/'.$pid.'/'.$eid)?>" class="btn btn-primary" >Update Me</a>-->
                                                
                                                 <a href="javascript:;" onclick="window.location='<?=base_url('employee/father/'.$cid.'/'.$pid.'/'.$eid)?>'" class="btn btn-primary" type="submit">Update Record</a>
                                                
                                                <a href="javascript:;" onclick="deleterec()" class="btn btn-primary" type="submit">Delete</a>
                                                
                                             </form>
</div>
<script>
    function deleterec()
    {
        if(confirm('Do you want to delete mother?')==ture){
             window.location='<?=base_url('employee/delfather/'.$cid.'/'.$pid.'/'.$eid)?>';
        }
    }
</script>