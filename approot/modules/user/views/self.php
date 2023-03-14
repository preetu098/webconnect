<div class="basic-form">
   <form method="POST" action="<?= base_url('user/updself/');?><?= $cid;?>/<?= $pid;?>/<?= $eid;?>" enctype="multipart/form-data">
                                                <?php 
                                                  $uemp = $this->qm->all('ri_employee_tbl','*',array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid));
                                                    foreach ($uemp as $uemp) {
                                                ?>
                                                <div class="row">
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">Name</label>
                                                      <input type="text" placeholder="Name" value="<?= $uemp->name;?>" name="name" class="form-control">
                                                   </div>
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">Email</label>
                                                      <input type="email" placeholder="Email" value="<?= $uemp->email;?>" name="email" class="form-control">
                                                   </div>
                                                      <div class="mb-3 col-md-6">
                                                      <label class="form-label">Mobile</label>
                                                      <input type="text" placeholder="Mobile" value="<?= $uemp->mobile;?>" name="mobile" class="form-control">
                                                   </div>
                                                      <div class="mb-3 col-md-6">
                                                      <label class="form-label">Gender</label>
                                                       <select class="form-control" name="gender">
                                                         <option>Select gender</option>
                                                         <option value="Male" <?= ($uemp->gender=='Male')?'selected':'';?>>Male</option>
                                                         <option value="Female" <?= ($uemp->gender=='Female')?'selected':'';?>>Female</option>
                                                         <option value="Others" <?= ($uemp->gender=='Others')?'selected':'';?>>Others</option>
                                                     </select>
                                                   </div>
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">Wedding Date</label>
                                                        <input type="date" name="wedd_date" value="<?= $uemp->wedd_date;?>" class="form-control" placeholder="Wedding Date">
                                                   </div>
                                                   <div class="mb-3 col-md-6">
                                                      <label class="form-label">DOB</label>
                                                       <input type="date" name="dob" id="dob" class="form-control" value="<?= $uemp->dob;?>" placeholder="Dob">
                                                   </div>
                                                    <div class="mb-3 col-md-6">
                                                      <label class="form-label">Age</label>
                                                       <input type="text" name="age" id="age" class="form-control" value="<?= $uemp->age;?>" placeholder="Age">
                                                   </div>
                                                    <div class="mb-3 col-md-6">
                                                      <div class="row">
                                                         <div class="col-xl-8">
                                                      <label class="form-label">Profile Image</label>
                                                       <input type="file" name="pimage" class="form-control">
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <img src="<?= base_url('external/uploads/');?><?= ($uemp->pimage==NULL)?'pro.png':$uemp->pimage;?>">
                                                         </div>
                                                        </div>
                                                   </div>

                                               
                                                </div>
                                                <?php } ?>
                                                
                                               
                                                <button class="btn btn-primary" type="submit">Update Me</button>
                                             </form>
</div>
