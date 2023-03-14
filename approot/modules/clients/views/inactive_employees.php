
         <div class="content-body">
            <div class="container-fluid">
               <div class="row page-titles">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item active"><a href="javascript:void(0)">Clients</a></li>
                     <li class="breadcrumb-item"><a href="javascript:void(0)">Employees</a></li>
                  </ol>

               </div>

                <?php 
                     $cl = $this->qm->all("ri_clientpolicy_tbl","*",array('id'=>$pid));
                     foreach ($cl as $cl);
                     ?><div class="col-12 card-header">
                           <h4 class="card-title">Client Name : - <?= $cl->cname;?></h4>
                           <h4 class="card-title">Policy Number : - <?= $cl->policy_num;?></h4>
                           <a href="<?= base_url('clients/employees');?>/<?= $cid;?>/<?= $pid;?>" class="btn btn-danger">Back To Employees</a>
                        </div>
               <div class="row">
                  <div class="col-12">
                     <div class="card">
                        <div class="card-header">
                           
                           <h4 class="card-title">Client List</h4>
                           

                           <?php 
                                 if(!empty($this->session->flashdata('success'))){

                                    $success = $this->session->flashdata('success');
                              ?>
                           <div class="alert alert-success alert-dismissible fade show" style="width: 25%;">

                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                              </button>
                              <strong>Success!</strong><?= $success;?>
                           </div>
                        <?php }
                        else{} ?> 
                           <!-- <div class="btn-group">
                           <a href="<?= base_url('clients/addemployee');?>/<?= $cid;?>/<?= $pid;?>" class="btn btn-primary">Add Employees</a>
                           &nbsp;
                           <a href="<?= base_url('clients/uploademployee');?>/<?= $cid;?>/<?= $pid;?>" class="btn btn-info">Upload Employees</a>
                           </div> -->

                        </div>
                        <div class="card-body">
                           <div class="table-responsive">
                              <table id="example" class="display" style="min-width: 845px">
                                 <thead>
                                    <tr>
                                       <th>Created On</th>
                                       <th>Card</th>
                                       <th>User/Password</th>
                                       <th>Emp Id</th>
                                      
                                       <th>Emp. Name</th>
                                       <th>Emp. Info</th>
                                       <th>Dependents</th>
                                       <th>DOB/Age</th>
                                       
                                       <th>Status</th>
                                       <th>Mode</th>

                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                   <?php
                                       $s = 1; 
                                       $emp = $this->qm->all('ri_employee_tbl','*',array('cid'=>$cid,'pid'=>$pid));
                                       foreach ($emp as $emp) {
                                         
                                         if($emp->status == 0){
                                    ?>
                                    <tr>
                                       <td><?= $emp->up_time;?></td>
                                       
                                       <td><a style="width: 50px;" href="<?= base_url('external/uploads/');?><?= $emp->card;?>" download>
                                       <img src="<?= base_url('external/uploads/');?><?= $emp->card;?>" style='width: 100px;'></a></td>
                                       <td>User - <?= $emp->username;?><br>Pass - <?= $emp->password;?></td>
                                      <td><?= $emp->emp_id;?></td>
                                       <td><?= $emp->emp_name;?></td>
                                       <td style="width: 195px;">Email - <?= $emp->email;?><br>
                                          Phone - <?= $emp->mobile;?><br>
                                          Relation - <?= $emp->relation;?><br>
                                          Gender - <?= $emp->gender;?><br>
                                          Wedd. Date - <?= $emp->wedd_date;?>
                                       </td>

                                       <?php 
                                          $fam = $this->qm->all('ri_dependent_tbl','*',array('cid'=>$cid,'pid'=>$pid,'eid'=>$emp->eid));
                                          $count = count($fam);
                                       ?>

                                       <td> <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#pop-<?= $s;?>"><?= $count;?></button>
                                          <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="pop-<?= $s;?>"aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Dependents</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                  
                                                   <table class="table table-responsive-sm">
                                                      <thead>
                                                         <tr>
                                                            <th>#</th>
                                                            <th>Relation</th>
                                                            <th>Info</th>
                                                            <th>Dob/Age</th>
                                                            <th>Status</th>
                                                         </tr>
                                                      </thead>
                                                      <tbody>
                                                         <?php 
                                                            $e = 1;
                                                            $rel = $this->qm->all('ri_dependent_tbl','*',array('cid'=>$cid,'pid'=>$pid,'eid'=>$emp->eid));
                                                            foreach($rel as $rel){
                                                         ?>
                                                         <tr>

                                                            <th><?= $e;?></th>
                                                            <td><?= $rel->reltype;?></td>
                                                            <td>Name :- <?= $rel->name;?><br>
                                                               Email :- <?= $rel->email;?><br>
                                                               Phone :- <?= $rel->phone;?>
                                                            </td>
                                                            <td>Dob :- <?= date('d M, Y',strtotime($rel->dob));?><br>
                                                               Age :- <?= $rel->age;?><br>
                                                               <?php 
                                                                  if($rel->wedd_date!=Null){
                                                                     echo "Wedding Date :- ". date('d M, Y',strtotime($rel->wedd_date));
                                                                  }
                                                                  else{

                                                                  }
                                                               ?>
                                                            </td>
                                                            <td class="color-primary"><?php 
                                                            if($rel->status == 1){
                                                               echo'<span class="badge badge-success light">New Member Addition</span>';
                                                            }
                                                            else{
                                                               echo'<span class="badge badge-info light">Family Data Correction</span>';
                                                            }
                                                         ?></td>
                                                            
                                                         </tr>

                                                        <?php $e++; } ?>
                                                      </tbody>
                                                   </table>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>

                                       </td>
                                       <td>D.O.B - <?= $emp->dob;?><br>Age - <?= $emp->age;?></td>
                                       
                                       <td><?php if($emp->status == 1){echo '<span class="badge badge-success light">Active</span>';}else{echo '<span class="badge badge-danger light">Inactive</span>';}?></td>
                                       <td><?= $emp->mode;?></td>
                                      
                                       <td>
                                       <div class="dropdown ms-auto text-end">
                                          <div class="btn-link" data-bs-toggle="dropdown" aria-expanded="true">
                                             <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                             </div>
                                             <div class="dropdown-menu dropdown-menu-end" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(-92px, 27px);" data-popper-placement="bottom-end">
                                              <a href="<?= base_url('clients/editemployee/');?><?= $cid;?>/<?= $pid;?>/<?= $emp->eid;?>" class="dropdown-item"><i class="fas fa-pencil-alt"></i> Edit Employee</a>
                                              <a href="<?= base_url('user/login/');?><?= $cid;?>/<?= $pid;?>/<?= $emp->eid;?>"target="_blank" class="dropdown-item"><i class="fas fa-lock"></i> Login</a>
                                              <a  data-toggle="tooltip" href="<?= base_url('user/login/');?><?= $cid;?>/<?= $pid;?>/<?= $emp->eid;?>" class="dropdown-item"><i class="fas fa-copy"></i> Copy Url</a>
                                             </div>
                                          </div>
                                       </td>
                                     <!--   <td>
                                           
                                       </td> -->
                                    </tr>
                                  
                                   <?php 
                                }
                                   $s++; } ?>
                                 </tbody>
                                
                           </div>
                              </table>
  
                                  
                        </div>
                     </div>
                  </div>
                  
                  
                  
                 
               </div>
            </div>
         </div>
      


      