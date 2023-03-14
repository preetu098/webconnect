<div class="content-body">
   <div class="container-fluid">
      <div class="row page-titles">
         <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Employee / Depandants</a></li>

         </ol>
      </div>

      <div class="row">
         <div class="col-xl-12">
            <div class="card">
               <div class="card-header d-block">
                  <h4 class="card-title">Make Correction and Add / Delete Dependents</h4>
                  <?php
                  if (!empty($this->session->flashdata('succes'))) {

                     $succes = $this->session->flashdata('succes');
                  ?>
                     <div class="alert alert-success alert-dismissible fade show" style="width: 50%;float: right;margin-top: -35px;">

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                        </button>
                        <strong>Success!</strong><?= $succes; ?>
                     </div>
                  <?php } else if (!empty($this->session->flashdata('err'))) {
                     $err = $this->session->flashdata('err');
                  ?>
                     <div class="alert alert-danger alert-dismissible fade show" style="width: 50%;float: right;margin-top: -35px;">

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                        </button>
                        <strong>Error!</strong> <?= $err; ?>
                     </div>
                  <?php } else {
                  } ?>
               </div>
               <div class="card-body">


                  <div class="col-sm-12">
                     <div class="row">
                     <div class="col-sm-6">
                        <?php
                        $s = 1;
                        $rel = $this->qm->all('fm_relation_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'is_publish' => 1));
                        $usedKids = [];
                        $kidData = $this->qm->all('ri_dependent_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'eid' => $eid, 'reltype' => 'Kid'));
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
                                    <div id="collapse6One<?= $s; ?>" class="accordion__body collapse <?= ($_GET['type'] == $rel->reltype) ? 'show' : '' ?>" aria-labelledby="accord-6One<?= $s; ?>" data-bs-parent="#accordion-six<?= $s; ?>" style="">
                                       <div class="accordion-body-text">
                                          <?php
                                          $data['cid'] = $cid;
                                          $data['pid'] = $pid;
                                          $data['eid'] = $eid;
                                          $data['rel'] = $rel->reltype . $i;
                                          if ($rel->reltype == 'Self') {
                                             $this->load->view('employee/self_edit', $data);
                                          } else if ($rel->reltype == 'Spouse') {
                                             $this->load->view('employee/spouse_edit', $data);
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
                                             $this->load->view('employee/kid_edit', $data);
                                          } else if ($rel->reltype == 'Father') {
                                             $this->load->view('employee/father_edit', $data);
                                          } else if ($rel->reltype == 'Mother') {
                                             $this->load->view('employee/mother_edit', $data);
                                          } else if ($rel->reltype == 'Father In Law') {
                                             $this->load->view('employee/fatherinlaw_edit', $data);
                                          } else if ($rel->reltype == 'Mother In Law') {
                                             $this->load->view('employee/motherinlaw_edit', $data);
                                          } else {
                                             echo "Some Error Occurred";
                                          }
                                          ?>
                                       </div>
                                    </div>
                                 </div>


                              </div>

                        <?php }
                        } ?>
                     </div>
                     <div class="col-sm-6">
                           <div class="point-box">
                              <h4>Points Worth Noting</h4>

                              <h5>Correction</h5>
                              <p><i class="fa fa-check" style="color: #225ca3;"></i>Any correction request should be backed by documentary proof. Kindly upload a copy of government-approved document such as a voter ID/ Valid Passport/ Aadhar Card/ Driving License.</p>
                              <p><i class="fa fa-check" style="color: #225ca3;"></i>All corrections requests will be processed after your HR approval (In-built system functionality)</p>
                              <p><i class="fa fa-check" style="color: #225ca3;"></i>Correction is processed by the Insurer through an endorsement. The requested correction will reflect in "Well Connect" by the 15th of the corresponding month.</p>
                              <h5>Dependant Additions</h5>
                              <p><i class="fa fa-check" style="color: #225ca3;"></i>Mid Term Addition is only possible in case of childbirth and in the event of marriage only.</p>
                              <p><i class="fa fa-check" style="color: #225ca3;"></i>A new-born Baby should be added to the policy as soon as possible and a maximum of 90 days from the date of birth.</p>
                              <p><i class="fa fa-check" style="color: #225ca3;"></i>The newlywed spouse should be added to the policy within 30 Days of marriage.</p>
                              <p><i class="fa fa-check" style="color: #225ca3;"></i>Additions are processed by the Insurer through an endorsement. The requested additions will reflect in "Well Connect" by the 15th of the corresponding month.</p>
                              <h5>Dependant Deletion</h5>
                              <p><i class="fa fa-check" style="color: #225ca3;"></i>Deletion of Dependants are possible in special cases such as any unfortunate death or Divorce.</p>
                              <p><i class="fa fa-check" style="color: #225ca3;"></i>Deletion does not mean deletion of data from the system, it means deleting the coverage from the policy which requires a procedural deletion endorsement by the insurer. The requested deletion will reflect in "Well Connect" by the 15th of the corresponding month.</p>
                           </div>
                     </div>
                     </div>
                  </div>




               </div>
            </div>
         </div>


      </div>
   </div>
</div>
</div>