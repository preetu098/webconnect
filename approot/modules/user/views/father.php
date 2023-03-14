<div class="basic-form">
   <?php
   $spouse = $this->qm->all('ri_dependent_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'eid' => $eid, 'reltype' => 'Father'));

   foreach ($spouse as $spouse);


   ?>
   <form method="POST" action="<?= base_url('user/father/'); ?><?= $cid; ?>/<?= $pid; ?>/<?= $eid; ?>" enctype="multipart/form-data">

      <div class="row">
         <div class="mb-3 col-md-6">
            <label class="form-label">Name</label>
            <input type="text" placeholder="Name" value="<?= !empty($spouse->name) ? $spouse->name : ''; ?>" name="name" class="form-control">
         </div>
         <div class="mb-3 col-md-6">
            <label class="form-label">Email</label>
            <input type="email" placeholder="Email" value="<?= !empty($spouse->email) ? $spouse->email : ''; ?>" name="email" class="form-control">
         </div>
         <div class="mb-3 col-md-6">
            <label class="form-label">Mobile</label>
            <input type="text" placeholder="Mobile" value="<?= !empty($spouse->phone) ? $spouse->phone : ''; ?>" name="phone" class="form-control">
         </div>
         <div class="mb-3 col-md-6">
            <label class="form-label">Gender</label>
            <select class="form-control" name="gender">
               <option>Select gender</option>
               <option value="Male" <?= !empty($spouse->gender) ? (($spouse->gender == 'Male') ? 'selected' : '') : ''; ?>>Male</option>
               <option value="Female" <?= !empty($spouse->gender) ? (($spouse->gender == 'Female') ? 'selected' : '') : ''; ?>>Female</option>
               <option value="Others" <?= !empty($spouse->gender) ? (($spouse->gender == 'Others') ? 'selected' : '') : ''; ?>>Others</option>
            </select>
         </div>

         <div class="mb-3 col-md-6">
            <label class="form-label">DOB</label>
            <input type="date" name="dob" id="dob5" class="form-control" value="<?= !empty($spouse->dob) ? $spouse->dob : ''; ?>" placeholder="Dob">
         </div>
         <div class="mb-3 col-md-6">
            <label class="form-label">Age</label>
            <input type="text" name="age" id="age5" class="form-control" value="<?= !empty($spouse->age) ? $spouse->age : ''; ?>" placeholder="Age">
         </div>

         <input type="hidden" name="did" value="<?= !empty($spouse->did) ? $spouse->did : 0; ?>">

      </div>
      <?php
      $did = !empty($spouse->did) ? $spouse->did : 0;
      ?>


      <!-- <button class="btn btn-primary" type="submit">Update Me</button> -->

      <?php if ($spouse->name) { ?>
         <?php if ($spouse->status == 1) : ?>
            <input type="hidden" style="background:#f8f8f8" name="mode" value="Updation">
            <button class="btn btn-primary" type="submit">UPDATE FATHER</button>
            <a href="javascript:;" onclick="deleterec(<?php echo $did; ?>)" class="btn btn-primary" type="submit">Delete</a>
         <?php else : ?>
            <button disabled class="btn btn-primary" type="button"><?php echo getEmployeeStatus($spouse->did, 'Father')['statustext']; ?></button>
         <?php endif; ?>
      <?php } else { ?>
         <input type="hidden" style="background:#f8f8f8" name="mode" value="New Addition">
         <button class="btn btn-primary" type="submit">ADD FATHER</button>
      <?php } ?>
   </form>
</div>