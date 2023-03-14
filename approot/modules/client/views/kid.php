<div class="basic-form">
  <?php
  //   $spouse = $this->qm->all('ri_dependent_tbl','*',array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid,'reltype'=>$rel));
  //$spouse = $this->qm->all('ri_dependent_tbl','*',array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid,'reltype'=>'Kid'));

  foreach ($spouse as $spouse);
  ?>
  <form method="POST" action="<?= base_url('client/adddep/'); ?><?= $pid; ?>/<?= $eid; ?>/<?= $rel; ?>" enctype="multipart/form-data">

    <div class="row">
      <div class="mb-3 col-md-6">
        <label class="form-label">Name</label>
        <input type="text" placeholder="Name" required style="background:#f8f8f8" value="<?= !empty($spouse->name) ? $spouse->name : ''; ?>" name="name" class="form-control">
      </div>
      <!--   <div class="mb-3 col-md-6">
                                                      <label class="form-label">Email</label>
                                                      <input type="email" placeholder="Email" value="<?= !empty($spouse->email) ? $spouse->email : ''; ?>" name="email" class="form-control">
                                                   </div>
                                                      <div class="mb-3 col-md-6">
                                                      <label class="form-label">Mobile</label>
                                                      <input type="text" placeholder="Mobile" value="<?= !empty($spouse->phone) ? $spouse->phone : ''; ?>" name="phone" class="form-control">
                                                   </div> -->
      <div class="mb-3 col-md-6">
        <label class="form-label">Gender</label>
        <select class="form-control" name="gender" required style="background:#f8f8f8">
          <option value="">Select gender</option>
          <option value="Male" <?= ($spouse->gender == 'Male' || $spouse->gender == 'M') ? 'selected' : ''; ?>>Male</option>
          <option value="Female" <?= ($spouse->gender == 'Female' || $spouse->gender == 'F') ? 'selected' : ''; ?>>Female</option>
          <option value="Others">Others</option>
        </select>
      </div>
      <!--  <div class="mb-3 col-md-6">
                                                      <label class="form-label">Wedding Date</label>
                                                        <input type="date" name="wedd_date" value="<?= !empty($spouse->wedd_date) ? $spouse->wedd_date : ''; ?>" class="form-control" placeholder="Wedding Date">
                                                   </div> -->
      <div class="mb-3 col-md-6">
        <label class="form-label">DOB</label>
        <?php $dobId = rand(1000, 9999) . 'kid'; ?>
        <input type="date" name="dob" required style="background:#f8f8f8" data-age-inp="<?php echo $dobId; ?>" id="dob4<?= $rel; ?>" class="form-control calcage" value="<?= !empty($spouse->dob) ? $spouse->dob : ''; ?>" placeholder="Dob">
      </div>
      <div class="mb-3 col-md-6">
        <label class="form-label">Age</label>
        <input type="text" name="age" required style="background:#f8f8f8" id="<?= $dobId; ?>" class="form-control numbersOnly" value="<?= !empty($spouse->age) ? $spouse->age : ''; ?>" placeholder="Age">
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
      <input type="hidden" name="emp_id" value="<?= $emp_id ?>" />
      <?php
      $did = !empty($spouse->did) ? $spouse->did : 0;
      ?>
      <input type="hidden" name="did" value="<?= $did; ?>">

    </div>
    <input type="hidden" name="reltype" value="Kid" />




    <!--<a href="base_url('employee/addkid/'.$cid.'/'.$pid.'/'.$eid.'/'.$rel->reltype)" class="btn btn-primary" type="submit">Update Me</a>-->

    <!-- <a href="javascript:;" onclick="window.location='<?= base_url('employee/addkid/' . $cid . '/' . $pid . '/' . $eid . '/' . $rel->reltype) ?>'" class="btn btn-primary" type="submit">ADD KID</a>-->

    <!--<a href="javascript:;" onclick="deleterec()" class="btn btn-primary" type="submit">Delete</a>-->

    <?php
    if ($spouse->name) {
    ?>
      <?php if ($spouse->status != 2) : ?>
        <input type="hidden" name="mode" value="Updation">
        <button class="btn btn-primary" type="submit">Update KID</button>
        <a href="javascript:;" onclick="deleterec(<?php echo $did; ?>)" class="btn btn-primary" type="submit">Delete</a>
      <?php else : ?>
        <button disabled class="btn btn-primary" type="button"><?php echo getEmployeeStatus($spouse->did, 'Kid')['statustext']; ?></button>
      <?php endif; ?>
    <?php  } else { ?>
      <input type="hidden" name="mode" value="New Addition">
      <button class="btn btn-primary" type="submit">ADD KID</button>
    <?php } ?>

  </form>
</div>

<script>
  function deleterec(did) {
    if (confirm('Attention! By clicking here Depandant details will be qued for Deletion Endorsement!!') == true) {
      window.location = '<?= base_url('client/deletedep/' . $pid . '/') ?>' + did;
    }
  }
</script>