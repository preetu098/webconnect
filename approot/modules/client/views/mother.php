<div class="basic-form">
   <?php
   $spouse = $this->qm->all('ri_dependent_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'eid' => $eid, 'reltype' => 'Mother'));

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
         <select class="form-control" name="gender" required style="background:#f8f8f8">
            <option value="">Select gender</option>
            <option value="Male" <?= !empty($spouse->gender) ? (($spouse->gender == 'Male') ? 'selected' : '') : ''; ?>>Male</option>
            <option value="Female" <?= !empty($spouse->gender) ? (($spouse->gender == 'Female') ? 'selected' : '') : ''; ?>>Female</option>
            <option value="Others" <?= !empty($spouse->gender) ? (($spouse->gender == 'Others') ? 'selected' : '') : ''; ?>>Others</option>
         </select>
      </div>

      <div class="mb-3 col-md-6">
         <label class="form-label">DOB</label>
         <input type="date" name="dob" required style="background:#f8f8f8" id="dob4" class="form-control" value="<?= !empty($spouse->dob) ? $spouse->dob : ''; ?>" placeholder="Dob">
      </div>
      <div class="mb-3 col-md-6">
         <label class="form-label">Age</label>
         <input type="text" name="age" required style="background:#f8f8f8" id="age4" class="form-control" value="<?= !empty($spouse->age) ? $spouse->age : ''; ?>" placeholder="Age">
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

      <input type="hidden" name="did" style="background:#f8f8f8" value="<?= !empty($spouse->did) ? $spouse->did : 0; ?>">
      <input type="hidden" name="reltype" style="background:#f8f8f8" value="Mother">

   </div>



   <!--<a href="<?= base_url('user/mother/' . $cid . '/' . $pid . '/' . $eid); ?>" class="btn btn-primary" type="submit">Update Me</a>-->


   <!-- <a href="javascript:;" onclick="window.location='<?= base_url('user/mother/' . $cid . '/' . $pid . '/' . $eid); ?>'" class="btn btn-primary" type="submit">Update Record</a>

   <a href="javascript:;" onclick="deleterec()" class="btn btn-primary" type="submit">Delete</a> -->

   <?php if ($spouse->name) { ?>
         <?php if ($spouse->status != 2) : ?>
            <?php
         $did = !empty($spouse->did) ? $spouse->did : 0;
         ?>
            <input type="hidden" style="background:#f8f8f8" name="mode" value="Updation">
            <button class="btn btn-primary" type="submit">UPDATE MOTHER</button>
            <a href="javascript:;" onclick="deleterec(<?php echo $did; ?>)" class="btn btn-primary" type="submit">Delete</a>
         <?php else : ?>
            <button disabled class="btn btn-primary" type="button"><?php echo getEmployeeStatus($spouse->did, 'Mother')['statustext']; ?></button>
         <?php endif; ?>
      <?php } else { ?>
         <input type="hidden" style="background:#f8f8f8" name="mode" value="New Addition">
         <button class="btn btn-primary" type="submit">ADD MOTHER</button>
      <?php } ?>
      
   </form>
</div>


<script>
   function deleterec() {
      if (confirm('Do you want to delete mother?') == true) {
         window.location = '<?= base_url('employee/delmother/' . $cid . '/' . $pid . '/' . $eid) ?>';
      }
   }
</script>