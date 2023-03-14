<div class="content-body">
   <div class="container-fluid">
      <div class="row page-titles">
         <ol class="breadcrumb">
            <?php
            $empll = $this->qm->single("ri_clients_tbl", "*", array('cid' => $cid));
            $policy = $this->qm->single("ri_clientpolicy_tbl", "*", array('cid' => $cid)); ?>
            <li class="breadcrumb-item active">
               <?= $empll->cname ?>
            </li>
            <li class="breadcrumb-item">Policy No: <?= $policy->policy_num ?></li>
         </ol>
      </div>
      <div class="row">
         <?php
         $em = $this->qm->single("ri_employee_tbl", "*", array('eid' => $eid));
         ?>
         <div class="col-xl-12 col-lg-12">
            <div class="card">
               <div class="card-header">
                  <h4 class="card-title">Add Employee</h4>
                  <a href="<?= base_url() ?>employee/register/<?= $cid ?>/<?= $pid ?>" class="btn btn-primary btn-right copy">Click here to copy URL to send via your mail</a>
                  <!--Copy URL and send via mail to invite:-->
                  <?php
                  if (!empty($this->session->flashdata('error'))) {
                     $error = $this->session->flashdata('error');
                  ?>
                     <div class="alert alert-danger alert-dismissible fade show" style="width: 25%;">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                        </button>
                        <strong>Error!</strong> <?= $error; ?>
                     </div>
                  <?php } else {
                  } ?>
                  <?php
                  if (!empty($this->session->flashdata('success'))) {
                     $success = $this->session->flashdata('success');
                  ?>
                     <div class="alert alert-success alert-dismissible fade show" style="width: 25%;">

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                        </button>
                        <strong></strong> <?= $success; ?>
                     </div>
                  <?php } else {
                  } ?>
               </div>
               <div class="card-body">
                  <div class="basic-form">
                     <form method="POST" action="<?= base_url('client/addemp'); ?>/<?= $pid; ?>" enctype="multipart/form-data">
                        <div class="row">
                           <div class="row">
                              <input hidden value="<?= $em->eid ?? ''; ?>" name="eid">
                              <div class="mb-3 col-md-6">
                                 <label class="form-label">Name *</label>
                                 <input type="text" placeholder="Name" <?= ($eid > 0) ? "" : "" ?> required value="<?= $em->name; ?>" name="name" class="form-control">
                              </div>
                              <div class="mb-3 col-md-6" title="Please contact HR to change Employee ID">
                                 <label class="form-label">Employee ID *</label>
                                 <input type="text" class="form-control" <?= ($eid > 0) ? "" : "" ?> name="emp_id" onkeyup="findemp(this.value)" required value="<?= $em->emp_id; ?>" placeholder="Employee ID">
                                 <div id="checknew"></div>
                              </div>
                              <!--<div class="mb-3 col-md-6">
                                    <label class="form-label">Health Card No.</label>
                                    <input type="text" disabled class="form-control" style="background:#f8f8f8" value="<?= $em->card; ?>" placeholder="Health Card No.">
                                 </div>-->
                              <div class="mb-3 col-md-6">
                                 <label class="form-label">Sum Insured *</label>
                                 <input type="text" class="form-control" <?= ($eid > 0) ? "" : "" ?> name="sum_insured" required value="<?= $em->sum_insured; ?>" placeholder="Sum Insured">
                              </div>
                              <div class="mb-3 col-md-6">
                                 <label class="form-label">Email</label>
                                 <input type="email" placeholder="Email" <?= ($eid > 0) ? "" : "" ?> value="<?= $em->email; ?>" name="email" class="form-control emailOnly">
                              </div>
                              <div class="mb-3 col-md-6">
                                 <label class="form-label">Mobile</label>
                                 <input type="text" placeholder="Mobile" maxlength="11" <?= ($eid > 0) ? "" : "" ?> value="<?= $em->mobile; ?>" pattern="[0-9]{10}" name="mobile" class="form-control numbersOnly" onkeypress="if(this.value.length==10) return false;">
                              </div>
                              <div class="mb-3 col-md-6">
                                 <label class="form-label">Gender*</label>
                                 <select class="form-control" required name="gender" <?= ($eid > 0) ? "" : "" ?>>
                                    <option value="">Select Gender</option>
                                    <option value="Male" <?= ($em->gender == 'M' || $em->gender == 'Male') ? "selected" : "" ?>>Male</option>
                                    <option value="Female" <?= ($em->gender == 'F' || $em->gender == 'Female') ? "selected" : "" ?>>Female</option>
                                    <option value="Others">Others</option>
                                 </select>
                              </div>
                              <!--<div class="mb-3 col-md-6">
                                    <label class="form-label">Wedding Date</label>
                                       <input type="date" name="wedd_date" value="<?= $uemp->wedd_date; ?>" class="form-control" placeholder="Wedding Date">
                                 </div>-->
                              <div class="mb-3 col-md-6">
                                 <label class="form-label">DOB *</label>
                                 <input type="date" name="dob" id="dob" required <?= ($eid > 0) ? "" : "" ?> class="form-control" value="<?= $em->dob; ?>" placeholder="DOB">
                              </div>
                              <div class="mb-3 col-md-6" title="Contact HR to Update">
                                 <label class="form-label">Date of Joining *</label>
                                 <input type="date" class="form-control" required name="doj" <?= ($eid > 0) ? "" : "" ?> value="<?= $em->doj; ?>" placeholder="Date of Joining">

                              </div>
                              <div class="mb-3 col-md-6">
                                 <label class="form-label">Age *</label>
                                 <input type="number" name="age" <?= ($eid > 0) ? "" : "" ?> id="age" required maxlength="3" class="form-control" value="<?= $em->age; ?>" placeholder="Age">
                              </div>
                              <div class="mb-3 col-md-6"></div>
                              <div class="mb-3 col-md-4"></div>
                              <div class="mb-2 col-md-4">
                                 <br>
                                 <?php if (empty($eid)) { ?>
                                    <button class="btn btn-primary" type="submit">Add Employee</button>
                                 <?php }
                                 if ($eid > 0) { ?>
                                    <?php if ($em->status == 2) : ?>
                                       <button class="btn btn-primary" disabled type="button"><?php echo getStatusMap($em->status); ?></button>
                                    <?php else : ?>
                                       <button class="btn btn-primary" type="submit">Update Employee</button>
                                    <?php endif; ?>
                                    <a hidden href="javascript:;" class="btn btn-primary" onclick="checkme()">Add Dependant</a>
                                 <?php } ?>
                              </div>
                              <div class="mb-3 col-md-4"></div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
         <?php if (!empty($eid)) : ?>
            <div class="card-body" style="display:block;" id="showmyrec">
               <h2>Add Dependants</h2>
               <?php
               $s = 1;
               $rel = $this->qm->all('fm_relation_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'is_publish' => 1, 'reltype!=' => 'Self'));

               $usedKids = [];
               $kidData = $this->qm->all('ri_dependent_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'eid' => $eid, 'reltype' => 'Kid'));
               //print_r($rel);
               foreach ($rel as $rel) {
                  $max = $rel->max_entry;
                  for ($i = 0; $i < $max; $i++, $s++) {
               ?>
                     <div class="accordion accordion-with-icon" id="accordion-six<?= $s; ?>">
                        <div class="accordion-item">
                           <div class="accordion-header rounded-lg collapsed" id="accord-6One<?= $s; ?>" data-bs-toggle="collapse" data-bs-target="#collapse6One<?= $s; ?>" aria-controls="collapse6One<?= $s; ?>" aria-expanded="false" role="button">
                              <span class="accordion-header-text"><?= $rel->reltype; ?></span>
                              <span class="accordion-header-indicator"></span>
                           </div>
                           <div id="collapse6One<?= $s; ?>" class="accordion__body collapse" aria-labelledby="accord-6One<?= $s; ?>" data-bs-parent="#accordion-six<?= $s; ?>" style="">
                              <div class="accordion-body-text">
                                 <?php
                                 $data['cid'] = $cid;
                                 $data['pid'] = $pid;
                                 $data['eid'] = $eid;
                                 $data['emp_id'] = $em->emp_id;
                                 $data['rel'] = $rel->reltype;
                                 if ($rel->reltype == 'Spouse') {
                                    $this->load->view('client/spouse', $data);
                                 } else if ($rel->reltype == 'Kid') {
                                    $kidV = [];
                                    foreach ($kidData as $kdata) {
                                       if (!in_array($kdata->did, $usedKids)) {
                                          $usedKids[] = $kdata->did;
                                          $kidV[] = $kdata;
                                          break;
                                       }
                                    }
                                    $data['spouse'] = $kidV;
                                    $this->load->view('client/kid', $data);
                                 } else if ($rel->reltype == 'Father') {
                                    $this->load->view('client/father', $data);
                                 } else if ($rel->reltype == 'Mother') {
                                    $this->load->view('client/mother', $data);
                                 } else if ($rel->reltype == 'Father In Law') {
                                    $this->load->view('client/fatherinlaw', $data);
                                 } else if ($rel->reltype == 'Mother In Law') {
                                    $this->load->view('client/motherinlaw', $data);
                                 } else {
                                    echo "Some Error Occurred";
                                 }
                                 ?>
                              </div>
                           </div>
                        </div>
                  <?php }
               } ?>
                     </div>
            </div>
         <?php endif; ?>
      </div>
   </div>
</div>
</div>
<div class="modal fade" id="deletedepmodal" tabindex="-1" aria-labelledby="deletedepmodalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="deletedepmodalLabel">Delete</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form id="delete-dep-form" enctype="multipart/form-data">
               <input type="hidden" name="did">
               <label for="img">DOL:</label>
               <input type="date" class="form-control" id="dol" name="dol">
               <span class='error'></span><br>
               <label for="img">Reason:</label>
               <textarea class="form-control" name="reson"></textarea>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" onclick="doDelDep()" class="btn btn-primary delete-dep-invite-excel">Submit</button>
         </div>
      </div>
   </div>
</div>

<script>
   function checkme() {
      $('#showmyrec').toggle();
   }

   function findemp(arg) {
      $('#checknew').load("<?= base_url('client/checkval/') ?>" + arg + "/<?= $pid ?>");
   }
</script>

<script>
   function deleterec(did) {
      $('#deletedepmodal').find('input[name="did"]').val(did);
      $('#deletedepmodal').modal('show');
   }

   function doDelDep() {
      msg = $('#deletedepmodal').find('input[name="dol"]').val();
      reson = $('#deletedepmodal').find('textarea[name="reson"]').val();
      if (msg == '' || reson == '') {
         alert('Please fill Date of leaving and Reason');
         return false;
      }
      did = $('#deletedepmodal').find('input[name="did"]').val();
      window.location.href = "<?= base_url('client/deletedep/' . $pid . '/') ?>" + did + "?reson=" + reson + "&dol=" + msg;
   };
</script>