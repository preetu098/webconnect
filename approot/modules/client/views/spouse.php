<div class="basic-form">
   <?php
   $spouse = $this->qm->all('ri_dependent_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'eid' => $eid, 'reltype' => 'Spouse'));

   foreach ($spouse as $spouse);


   ?>
   <form method="POST" action="<?= base_url('client/adddep/'); ?><?= $pid; ?>/<?= $eid; ?>" enctype="multipart/form-data">

      <div class="row">
         <div class="mb-3 col-md-6">
            <label class="form-label">Name</label>
            <input type="text" placeholder="Name" required style="background:#f8f8f8" value="<?= !empty($spouse->name) ? $spouse->name : ''; ?>" name="name" class="form-control">
         </div>
         <div class="mb-3 col-md-6">
            <label class="form-label">Email</label>
            <input type="email" placeholder="Email" required style="background:#f8f8f8" value="<?= !empty($spouse->email) ? $spouse->email : ''; ?>" name="email" class="form-control emailOnly">
         </div>
         <div class="mb-3 col-md-6">
            <label class="form-label">Mobile</label>
            <input type="text" placeholder="Mobile" required style="background:#f8f8f8" value="<?= !empty($spouse->phone) ? $spouse->phone : ''; ?>" name="phone" class="form-control numbersOnly" onkeypress="if(this.value.length==10) return false;">
         </div>
         <div class="mb-3 col-md-6">
            <label class="form-label">Gender</label>
            <select class="form-control" required style="background:#f8f8f8" name="gender">
               <option value="">Select gender</option>
               <option value="Male" <?= ($spouse->gender == 'Male' || $spouse->gender == 'M') ? 'selected' : ''; ?>>Male</option>
               <option value="Female" <?= ($spouse->gender == 'Female' || $spouse->gender == 'F') ? 'selected' : ''; ?>>Female</option>
               <option value="Others">Others</option>
            </select>
         </div>
         <div class="mb-3 col-md-6">
            <label class="form-label">Wedding Date</label>
            <input type="date" name="wedd_date" style="background:#f8f8f8" value="<?= !empty($spouse->wedd_date) ? $spouse->wedd_date : ''; ?>" class="form-control" placeholder="Wedding Date">
         </div>
         <div class="mb-3 col-md-6">
            <label class="form-label">DOB</label>
            <input type="date" name="dob" required style="background:#f8f8f8" id="dob3" class="form-control" value="<?= !empty($spouse->dob) ? $spouse->dob : ''; ?>" placeholder="Dob">
         </div>
         <div class="mb-3 col-md-6">
            <label class="form-label">Age</label>
            <input type="text" name="age" required id="age3" style="background:#f8f8f8" class="form-control" value="<?= !empty($spouse->age) ? $spouse->age : ''; ?>" placeholder="Age">
         </div>
         <?php if (!empty($spouse->did)) : ?>
            <div class="mb-3 col-md-8">
               <div class="row">
                  <div class="col-xl-10">
                     <label class="form-label">Upload Aadhar in case of Name/DOB/Gender correction</label>
                     <input type="file" name="pimage" class="form-control">
                  </div>
                  <?php if (!empty($spouse->pimage)) : ?>
                     <div class="col-xl-2">
                        <img src="<?= base_url('external/uploads/' . $spouse->pimage) ?>" height="50" style="width:100px">
                     </div>
                  <?php endif; ?>
               </div>
            </div>
            <div class="mb-3 col-md-12">
               <div class="row">
                  <div class="col-xl-8">
                     <label class="form-label">Reason</label>
                     <input type="text" name="reson" value="<?= !empty($spouse->reson) ? $spouse->reson : ''; ?>" class="form-control">
                  </div>

               </div>
            </div>
         <?php endif; ?>
         <?php
         $did = !empty($spouse->did) ? $spouse->did : 0;
         ?>
         <input type="hidden" style="background:#f8f8f8" name="did" value="<?= $did; ?>">
         <input type="hidden" style="background:#f8f8f8" name="reltype" value="Spouse">
         <input type="hidden" name="emp_id" value="<?= $emp_id ?>" />
      </div>

      <!-- <a href="javascript:;" onclick="window.location='<?= base_url('employee/updspouse/' . $cid . '/' . $pid . '/' . $eid) ?>'" class="btn btn-primary" type="submit">Update Record</a>-->

      <!---->
      <?php if ($spouse->name) { ?>
         <?php if ($spouse->status != 2) : ?>
            <input type="hidden" style="background:#f8f8f8" name="mode" value="Updation">
            <button class="btn btn-primary" type="submit">UPDATE SPOUSE</button>
            <a href="javascript:;" onclick="deleterec(<?php echo $did; ?>)" class="btn btn-primary" type="submit">Delete</a>
         <?php else : ?>
            <button disabled class="btn btn-primary" type="button"><?php echo getEmployeeStatus($spouse->did, 'Spouse')['statustext']; ?></button>
         <?php endif; ?>
      <?php } else { ?>
         <input type="hidden" style="background:#f8f8f8" name="mode" value="New Addition">
         <button class="btn btn-primary" type="submit">ADD SPOUSE</button>
      <?php } ?>


   </form>
</div>