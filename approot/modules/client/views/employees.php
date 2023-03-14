<div class="content-body">
   <div class="container-fluid">
      <div class="row page-titles">
         <ol class="breadcrumb">
            <!--<li class="breadcrumb-item active"><a href="javascript:void(0)">Client</a></li>-->
            <!--<li class="breadcrumb-item"><a href="javascript:void(0)">Employees</a></li>-->
         </ol>

         <?php
         $whe = "cid='$cid' && pid='$pid' && ((status='1' OR status='3') AND mode != 'Deletion' AND mode != 'New Addition')";

         $spouse = $parents = $kid = $inlaw =  0;
         $rest = $this->qm->all("ri_employee_tbl", "*", $whe);
         foreach ($rest as $res) {
            $whn = $whe . " AND eid=" . $res->eid;
            $depp = $this->qm->all("ri_dependent_tbl", "*", $whn);
            foreach ($depp as $dt) {
               //echo $dt->reltype;
               if ($dt->reltype == 'Spouse') {
                  $spouse = $spouse + 1;
               }
               if (($dt->reltype == 'Father' || $dt->reltype == 'Mother')) {
                  $parents = $parents + 1;
               }
               if ($dt->reltype == 'Kid') {
                  $kid = $kid + 1;
               }
               if ($dt->reltype == 'Father In Law' || $dt->reltype == 'Mother In Law') {
                  $inlaw = $inlaw + 1;
               }
            }
         }
         ?>
         <h4 class="ttl-emplye-dymic-velue">
            TOTAL EMPLOYEES: <span class="badge badge-primary light"><?= count($rest); ?></span>
            <?php
            $parentStatShow = false;
            $parentLawStatShow = false;
            $aaa = $this->qm->all("fm_relation_tbl", "*", array('cid' => $cid, 'pid' => $pid, 'is_publish' => 1));
            foreach ($aaa as $row) {
               if ($row->reltype == 'Spouse') {
            ?> |
                  SPOUSE: <span class="badge badge-primary light"><?= $spouse; ?></span> |
               <?php }
               if ($row->reltype == 'Kid') { ?>
                  KIDS: <span class="badge badge-primary light"><?= $kid; ?></span> |
               <?php }
               if (($row->reltype == 'Mother' || $row->reltype == 'Father') && !$parentStatShow) {
                  $parentStatShow = true; ?>
                  PARENTS: <span class="badge badge-primary light"><?= $parents; ?></span>
               <?php }
               if (($row->reltype == 'Mother In Law' || $row->reltype == 'Father In Law') && !$parentLawStatShow) {
                  $parentLawStatShow = true; ?>
                  PARENTS IN LAW: <span class="badge badge-primary light"><?= $inlaw; ?></span> |
            <?php }
            } ?></span>
            TOTAL LIVES: <span class="badge badge-primary light"><?= count($rest) + $spouse + $kid + $parents + $inlaw; ?></span>


            <!---<div style="float:right;">
								    <form method="post">
    								    <table class="table" style="background-color:#cfcfcf;">
    								        <tr>
    								            <td><input type="text" name="empid" style="width: 250px;" value="<?= (isset($_POST['empid'])) ? $_POST['empid'] : ''; ?>" placeholder="multiple employee ids eg: 1,2,3"  class="form-control"/></td>
    								            <td><input type="text" name="emp_name" value="<?= (isset($_POST['emp_name'])) ? $_POST['emp_name'] : ''; ?>" placeholder="Employee Name" class="form-control"/></td>
    								            <td><input type="submit" class="btn btn-success" value="Apply Filter" /></td>
    								            <td><a href="<?= base_url('client/employees/' . $pid) ?>" class="btn btn-info">Reset</a></td>
    								        </tr>
    								    </table>
								    </form>
								    </div>-->


      </div>

      <div class="row page-titles">
         <div class="col-xl-5 col-sm-12">
            <h3>Manage Employees</h3>
         </div>
         <div class="col-xl-7 col-sm-12">
            <form method="post">
               <table class="table emplyee-filtr-bx" style="margin: 0;">
                  <tr>
                     <td><input type="text" name="empid" style="width: 250px;" value="<?= (isset($_POST['empid'])) ? $_POST['empid'] : ''; ?>" placeholder="multiple employee ids eg: 1,2,3" class="form-control inpt_field" /></td>
                     <td><input type="text" name="emp_name" value="<?= (isset($_POST['emp_name'])) ? $_POST['emp_name'] : ''; ?>" placeholder="Employee Name" class="form-control inpt_field" /></td>
                     <td><input type="submit" class="btn add_emply" value="Apply Filter" /><a href="<?= base_url('client/employees/' . $pid) ?>" class="btn btn-info restbtn">Reset</a></td>
                     <!--<td><a href="<?= base_url('client/employees/' . $pid) ?>" class="btn btn-info">Reset</a></td>-->
                  </tr>
               </table>
            </form>
         </div>

      </div>


      <div class="row">
         <div class="col-12">
            <div class="card">




               <?php
               $cl = $this->qm->all("ri_clientpolicy_tbl", "*", array('id' => $pid));
               foreach ($cl as $cl);
               ?>
               <div class="card-header">
                  <h4 class="card-title"><?= $cl->cname; ?></h4>
                  <h4 class="card-title">Policy Number - <?= ($cl->policy_num == 5283) ? 'Data Collection' : $cl->policy_num; ?></h4>
                  <!--<h4 class="card-title">Client List</h4>-->
                  <?php
                  if (!empty($this->session->flashdata('success'))) {

                     $success = $this->session->flashdata('success');
                  ?>
                     <div class="alert alert-success alert-dismissible fade show" style="width: 25%;">

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                        </button>
                        <strong>Success!</strong><?= $success; ?>
                     </div>
                  <?php } else {
                  } ?>
                  <a href="<?= base_url('clients/downloademp'); ?>/<?= $cid; ?>/<?= $pid; ?>/?empid=<?= $this->input->post('empid') ?>&emp_name=<?= $this->input->post('emp_name') ?>" class="btn btn-info">Download Excel</a>
                  <div class="btn-group">
                     <a href="<?= base_url('client/addemployee'); ?>/<?= $pid; ?>" class="btn btn-primary">Add Employee</a>
                     &nbsp;
                     <a href="<?= base_url('client/uploademployee'); ?>/<?= $pid; ?>" class="btn btn-info">Upload Employees</a>


                  </div>
                  <!--<button  class="btn btn-info" onclick="ExportToExcel()">Upload Employees</button>-->
               </div>
               <div class="card-body">
                  <div class="table-responsive">
                     <table id="example_" class="table display" style="min-width: 845px">
                        <thead>
                           <tr>
                              <th>Created On</th>
                              <th>E-Card</th>
                              <th>User</th>
                              <th>Emp Id</th>
                              <th>Emp. Name</th>
                              <th>Emp. Info</th>
                              <th>Dependants</th>
                              <th>DOB/Age</th>
                              <th>Status</th>
                              <th>Mode</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $s = 1;
                           //$emp = $this->qm->all('ri_employee_tbl','*',array('cid'=>$cid,'pid'=>$pid));
                           foreach ($emp as $emp) {

                              if ($emp->status == 1) {
                           ?>
                                 <tr>
                                    <td><?= getDMYDate($emp->created_on, false); ?></td>

                                    <td><a style="width: 50px; color:blue;" href="<?= base_url('external/uploads/policy_cards/' . $cid . '_' . $pid . '/'); ?><?= str_replace('#','%23',$emp->card); ?>.pdf" download>
                                          <?= $emp->card ?>
                                       </a></td>
                                    <td>User - <?= $emp->username; ?>
                                       <!--<br>Pass - <?= $emp->password; ?>-->
                                    </td>
                                    <td><?= $emp->emp_id; ?></td>
                                    <td><?= $emp->emp_name; ?></td>
                                    <td style="width: 195px;">
                                       <!--Email - <?= $emp->email; ?><br>
                                          Phone - <?= $emp->mobile; ?><br>-->
                                       <?= $emp->relation; ?><br>
                                       <?= $emp->gender; ?><br>
                                       <?php ?>
                                       <?php
                                       if ($emp->wedd_date != '1970-01-01') {
                                          echo "Wedding Date - " . date('d M, Y', strtotime($emp->wedd_date));
                                       } else {
                                       }
                                       ?>
                                    </td>

                                    <?php
                                    $fam = $this->qm->all('ri_dependent_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'eid' => $emp->eid, 'status' => '1'));
                                    $count = count($fam);
                                    ?>

                                    <td> <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#pop-<?= $s; ?>"><?= $count; ?></button>
                                       <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="pop-<?= $s; ?>" aria-hidden="true">
                                          <div class="modal-dialog modal-lg">
                                             <div class="modal-content">
                                                <div class="modal-header">
                                                   <h5 class="modal-title">Dependants</h5>
                                                   <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                   </button>
                                                </div>
                                                <div class="modal-body">

                                                   <table class="table table-responsive-sm">
                                                      <thead>
                                                         <tr>
                                                            <th>#</th>
                                                            <th>Relation</th>
                                                            <th>E-card</th>
                                                            <th>Info</th>
                                                            <th>Dob/Age</th>
                                                            <th>Delete</th>
                                                            <th>Status</th>

                                                         </tr>
                                                      </thead>
                                                      <tbody>
                                                         <?php
                                                         $e = 1;
                                                         $rel = $this->qm->all('ri_dependent_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'eid' => $emp->eid, 'status' => '1'));
                                                         foreach ($rel as $rel) {
                                                         ?>
                                                            <tr>

                                                               <td><?= $e; ?></td>
                                                               <td><?= ($rel->reltype == 'Kid1' || $rel->reltype == 'Kid2' || $rel->reltype == 'Kid3') ? "Kid" : $rel->reltype . $rel->rel_index ?></td>
                                                               <td><a style="width: 50px; color:blue;" href="<?= base_url('external/uploads/policy_cards/' . $cid . '_' . $pid . '/'); ?><?= str_replace('#','',$rel->card); ?>.pdf" download>
                                                                     <?= $rel->card ?>
                                                                  </a></td>
                                                               <td>Name :- <?= $rel->name; ?><br>
                                                                  Email :- <?= $rel->email; ?><br>
                                                                  Phone :- <?= $rel->phone; ?>
                                                               </td>
                                                               <td>Dob :- <?= date('d M, Y', strtotime($rel->dob)); ?><br>
                                                                  Age :- <?= $rel->age; ?><br>
                                                                  <?php
                                                                  if ($rel->wedd_date != '1970-01-01') {
                                                                     echo "Wedding Date :- " . date('d M, Y', strtotime($rel->wedd_date));
                                                                  } else {
                                                                  }
                                                                  ?>
                                                               </td>
                                                               <td>
                                                                  <a href="javascript:;" onclick="deltet('<?= $cid ?>','<?= $pid ?>','<?= $rel->did; ?>')" onclick="delete"><i class="fa fa-trash"></i></a>
                                                               </td>
                                                               <td class="color-primary"><?php
                                                                                          if ($rel->status == 1) {
                                                                                             echo '<span class="badge badge-success light">Active</span>';
                                                                                          } else {
                                                                                             echo '<span class="badge badge-danger light">Inactive</span>';
                                                                                          }
                                                                                          ?></td>
                                                               <td>



                                                            </tr>

                                                         <?php $e++;
                                                         } ?>
                                                      </tbody>
                                                   </table>
                                                </div>

                                             </div>
                                          </div>
                                       </div>

                                    </td>
                                    <td style="width: 100%;">D.O.B - <?= date('d M, Y', strtotime($emp->dob)); ?><br>Age - <?= $emp->age; ?></td>

                                    <td><?php if ($emp->status == 1) {
                                             echo '<span class="badge badge-success light">Active</span>';
                                          } else {
                                             echo '<span class="badge badge-danger light">Inactive</span>';
                                          } ?></td>
                                    <td><?= $emp->mode; ?></td>

                                    <td>
                                       <div class="dropdown ms-auto text-end">
                                          <div class="btn-link" data-bs-toggle="dropdown" aria-expanded="true">
                                             <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                   <rect x="0" y="0" width="24" height="24"></rect>
                                                   <circle fill="#000000" cx="5" cy="12" r="2"></circle>
                                                   <circle fill="#000000" cx="12" cy="12" r="2"></circle>
                                                   <circle fill="#000000" cx="19" cy="12" r="2"></circle>
                                                </g>
                                             </svg>
                                          </div>
                                          <div class="dropdown-menu dropdown-menu-end" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(-92px, 27px);" data-popper-placement="bottom-end">
                                             <a href="<?= base_url('client/updself/'); ?><?= $pid; ?>/<?= $emp->eid; ?>" class="dropdown-item"><i class="fas fa-pencil-alt"></i> Actions</a>

                                             <!--<a  data-toggle="tooltip" href="<?= base_url('client/updself/'); ?><?= $pid; ?>/<?= $emp->eid; ?>"  class="dropdown-item"><i class="fa fa-users"></i> Add Depandant</a>-->
                                             <a href="<?= base_url('employee/loggedin/'); ?><?= $cid; ?>/<?= $pid; ?>/<?= $emp->eid; ?>/<?= $emp->username; ?>/<?= $emp->password; ?>" target="_blank" class="dropdown-item"><i class="fas fa-lock"></i> Employee Login</a>
                                             <a data-toggle="tooltip" href="<?= base_url('employee/login/'); ?><?= $cid; ?>/<?= $pid; ?>/<?= $emp->eid; ?>" class="dropdown-item copy"><i class="fas fa-copy"></i> Copy Url</a>
                                             <a data-toggle="tooltip" href="javascript:;" onclick="delte('<?= $cid ?>','<?= $pid ?>','<?= $emp->eid; ?>','self')" class="dropdown-item"><i class="fa fa-trash"></i> Delete Endorsement</a>
                                          </div>
                                       </div>
                                    </td>
                                    <!--   <td>
                                           
                                       </td> -->
                                 </tr>

                           <?php
                              }
                              $s++;
                           } ?>
                        </tbody>

                  </div>
                  </table>
                  <p><?php echo $links; ?></p>
               </div>
            </div>
         </div>
      </div>




   </div>
</div>
</div>

<div class="modal fade" id="deleteempmodal" tabindex="-1" aria-labelledby="deleteempmodalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="deleteempmodalLabel">Delete</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form id="delete-emp-form" enctype="multipart/form-data">
               <input type="hidden" name="cid">
               <input type="hidden" name="pid">
               <input type="hidden" name="eid">
               <label for="img">DOL:</label>
               <input type="date" class="form-control" id="dol" name="dol">
               <span class='error'></span><br>
               <label for="img">Reason:</label>
               <textarea class="form-control" name="reson"></textarea>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" onclick="doDelEmp()" class="btn btn-primary delete-emp-invite-excel">Submit</button>
         </div>
      </div>
   </div>
</div>

<script>
   <?php
   if (!empty($this->session->flashdata('popuperr'))) { ?>
      alert('<?php echo $this->session->flashdata('popuperr'); ?>');
   <?php } ?>

   function delte(cid, pid, eid, brg) {
      $('#deleteempmodal').find('input[name="pid"]').val(pid);
      $('#deleteempmodal').find('input[name="cid"]').val(cid);
      $('#deleteempmodal').find('input[name="eid"]').val(eid);
      $('#deleteempmodal').modal('show');
   }

   function doDelEmp() {
      msg = $('#deleteempmodal').find('input[name="dol"]').val();
      reson = $('#deleteempmodal').find('textarea[name="reson"]').val();
      pid = $('#deleteempmodal').find('input[name="pid"]').val();
      cid = $('#deleteempmodal').find('input[name="cid"]').val();
      eid = $('#deleteempmodal').find('input[name="eid"]').val();
      if (msg == '' || reson == '') {
         alert('Please fill Date of leaving and Reason');
         return false;
      }
      window.location.href = "<?= base_url('client/deleteemployee/') ?>" + pid + "/" + eid + "/Self/" + msg + "?reson=" + reson;
   };


   function deltet(cid, pid, did) {
      //alert(arg+'/'+brg);
      if (confirm('Attention! By clicking here Depandant details will be qued for Deletion Endorsement!!') == true) {
         window.location = "<?= base_url('client/deletedep/') ?>" + pid + "/" + did;
      }
   }
</script>