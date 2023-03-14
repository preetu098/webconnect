<div class="content-body" style="background:#fff;">
            
			<div class="container-fluid">
					<div class="row">
							<div class="col-xl-6 col-sm-12 card-body">
							    <h2>Make Correction</h2>

<div class="basic-form">
   <form method="POST" action="<?= base_url('employee/updself/');?><?= $cid;?>/<?= $pid;?>/<?= $eid;?>" enctype="multipart/form-data">
                                                <?php 
                                                
                                                  $uemp = $this->qm->single('ri_employee_tbl','*',array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid));
                                                  //print_r($uemp);
                                                    //foreach ($uemp as $uemp) {
                                                ?>
                                                <div class="row">
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">Name</label>
                                                      <input type="text"  placeholder="Name" required value="<?= $uemp->name;?>" name="name" class="form-control">
                                                   </div>
                                                   <div class="mb-3 col-md-6" title="Please contact HR to change Employee ID">
                                                        <label class="form-label">Employee ID</label>
                                                        <input type="text" disabled class="form-control" style="background:#f8f8f8" value="<?= $uemp->emp_id;?>" placeholder="Your Employee ID">
                                                        <input type="hidden" name="emp_id" value="<?= $uemp->emp_id;?>" >
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
                                                      <input type="email" placeholder="Email" required  value="<?= $uemp->email;?>" name="email" class="form-control">
                                                   </div>
                                                      <div class="mb-3 col-md-6">
                                                      <label class="form-label">Mobile</label>
                                                      <input type="text" placeholder="Mobile" required value="<?= $uemp->mobile;?>" name="mobile" class="form-control">
                                                   </div>
                                                      <div class="mb-3 col-md-6">
                                                      <label class="form-label">Gender</label>
                                                       <select class="form-control" required name="gender" >
                                                         <option>Select gender(<?php echo $uemp->gender?>)</option>
                                                         <option value="Male" <?= ($uemp->gender=='Male' || $uemp->gender=='M')?'selected':'';?>>Male</option>
                                                         <option value="Female" <?= ($uemp->gender=='Female' || $uemp->gender=='F')?'selected':'';?>>Female</option>
                                                         <option value="Others" <?= ($uemp->gender=='Others' || ($uemp->gender!='Male' && $uemp->gender!='M' && $uemp->gender!='F' && $uemp->gender!='Female'))?'selected':'';?>>Others</option>
                                                     </select>
                                                   </div>
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">Wedding Date</label>
                                                        <input type="date" name="wedd_date" value="<?= $uemp->wedd_date;?>" class="form-control" placeholder="Wedding Date">
                                                   </div>
                                                   <div class="mb-3 col-md-6" >
                                                      <label class="form-label">DOB</label>
                                                       <input type="date" name="dob" required id="dob1" class="form-control" value="<?= $uemp->dob;?>" placeholder="Dob">
                                                   </div>
                                                    <div class="mb-3 col-md-6" title="Contact HR to Update">
                                                        <label class="form-label">Date of Joining</label>
                                                        <input type="text" class="form-control" disabled style="background:#f8f8f8"  value="<?= date_format(date_create($uemp->doj),"d-m-Y");?>" placeholder="">
                                                        
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                      <label class="form-label">Age</label>
                                                       <input type="text" name="age" required id="age1"   class="form-control" value="<?= $uemp->age;?>" placeholder="Age">
                                                   </div>
                                                   <div class="mb-3 col-md-12">
                                                      <div class="row">
                                                         <div class="col-xl-8">
                                                      <label class="form-label">Reason</label>
                                                       <input type="text" value="<?= $uemp->reson;?>" name="reson" class="form-control">
                                                        </div>
                                                        
                                                        </div>
                                                   </div>
                                                    <div class="mb-3 col-md-12">
                                                      <div class="row">
                                                         <div class="col-xl-8">
                                                      <label class="form-label">Upload Aadhar in case of Name/DOB/Gender correction</label>
                                                       <input type="file"  name="pimage" class="form-control">
                                                        </div>
                                                        <?php if(!empty($uemp->pimage)): ?>
                                                          <div class="col-xl-2">
                                                                <img src="<?= base_url('external/uploads/'.$uemp->pimage) ?>" height="50" style="width:100px">
                                                                </div>
                                                          <?php endif; ?>
                                                        
                                                        </div>
                                                   </div>

                                               
                                                </div>
                                                <?php //} ?>
                                                
                                                <?php if($uemp->status != 2): ?>
                                                    <button class="btn btn-primary" type="submit">Update Record</button>
                                                <?php else: ?>
                                                   <button disabled class="btn btn-primary"><?php echo getEmployeeStatus($uemp->eid, 'Self')['statustext']; ?></a>
                                                <?php endif; ?>
                                                
                                             </form>
</div>

</div>



    
<style>
    
    .point-box{
    border: 1px solid #2f5ea3;
    padding: 10px 25px 10px 25px;
    background-color: #cde6ff;
    border-radius: 10px;
    text-align: justify;
    }
    .point-box p{
        font-size: 12px;
    }
    
    .point-box p i{
        margin-right: 5px;
    }
    
    .point-box p span{
        margin-left: 16px;
    }
    
</style>
</div></div></div>