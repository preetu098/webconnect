<!--**********************************
   Content body start
   ***********************************-->
   <div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Clients</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Client Detail</a></li>
                <?php
                $pol = $this->qm->all('ri_clientpolicy_tbl', '*', array('id' => $pid));
                foreach ($pol as $pol)
                    ;
                ?>
                <li class="breadcrumb-item"><a
                        href="javascript:void(0)"><?= ($pol->policy_num == 5283) ? 'Data Collection' : $pol->policy_num; ?></a>
                </li>
            </ol>

        </div>
        <!-- row -->
        <div class="row">
            <?php
            $client = $this->qm->all('ri_clients_tbl', '*', array('cid' => $cid)); foreach ($client as $client)
                ;
            ?>
            <div class="col-lg-12">
                <div class="card overflow-hidden">
                    <div class="text-center p-3 overlay-box "
                        style="background-image: url(<?= base_url('external/uploads/'); ?><?= $client->image; ?>); background-repeat: no-repeat;background-size: cover; background-position: center;">
                        <div class="profile-photo">
                            <img src="<?= base_url('external/uploads/'); ?><?= $client->image; ?>"
                                class="img-fluid rounded-circle" alt="" width="100">
                        </div>
                        <h3 class="mt-3 mb-1 text-white"><?= $client->cname; ?></h3>
                        <p class="text-white mb-0"><?= $client->ccode; ?></p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Last Login</span>
                            <strong class="text-muted"><?php
                            if ($client->last_login == NULL || diffBtDate(getYMDDate($client->last_login)) > 15) {
                                ?><span class="badge bg-danger">Offline</span>
                                <?php } else {
                                ?>
                                    <span class="badge bg-success">Online</span>
                                    <?php //$client->last_login; 
                                        ?>
                                <?php } ?> </strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between"><a target="_blank"
                                href="<?= base_url('client/index'); ?>" class="btn btn-success"><span
                                    class="btn-icon-start text-success"><i class="fa fa-lock"></i>
                                </span>Hr Login</a>
                               
                            <a href="<?= base_url('employee/register/'); ?><?= $cid; ?>/<?= $pid; ?>" target="_blank"
                                class="btn btn-info"><span class="btn-icon-start text-info"><i class="fa fa-user"></i>
                                </span>Employee Register</a>
                                <a href="<?= base_url('Clients/endorsement/'); ?><?= $cid; ?>/<?= $pid; ?>" target="_blank"
                                class="btn btn-info"><span class="btn-icon-start text-info"><i class="fa fa-user"></i>
                                </span>Endorsment Calculations</a>
                        </li>


                    </ul>
<div class="text-center">
                        <h4>Create Companys WellConnect Profile</h4>
                    </div>
                </div>
            </div>
           
           
          <div class="container">
              <div class="accordion accordion-flush" id="accordionFlushExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingOne">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
     <h4 style="text-align:center"> Step1-Define Policy(Relation List)</h4> 
      </button>
    </h2>
    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body">
          
          <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Relation List</h4>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#addrelation"> Add Relation</button>
                        <div class="modal fade" id="addrelation" data-bs-backdrop="addrelation" data-bs-keyboard="false"
                            tabindex="-1" aria-labelledby="addrelationBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form class="form-group" method="POST"
                                        action="<?= base_url('clients/addrelation'); ?>/<?= $cid; ?>/<?= $pid; ?>">
                                        <div class="modal-body">


                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <label class="form-label">Relation Type</label>

                                                    <select class="form-control" name="reltype">

                                                        <option>Select Relation</option>
                                                        <option value="Self">Self</option>
                                                        <option value="Spouse">Spouse</option>
                                                        <option value="Kid">Kid</option>
                                                        <option value="Mother">Mother</option>
                                                        <option value="Father">Father</option>
                                                        <option value="Mother In Law">Mother In Law</option>
                                                        <option value="Father In Law">Father In Law</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="form-label">Max Entries</label>
                                                    <input type="text" name="max_entry" value="" class="form-control">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="form-label">Is Publish</label>
                                                    <select class="form-control" name="is_publish">
                                                        <option>Select</option>
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>

                                                </div>

                                            </div>


                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="basic-list-group">
                            <div class="row">
                                <div class="col-lg-6 col-xl-6">
                                    <div class="list-group mb-4 " id="list-tab" role="tablist">
                                        <?php
                                        $r = 1;
                                        $rel = $this->qm->all('fm_relation_tbl', '*', array('cid' => $cid, 'pid' => $pid));
                                        foreach ($rel as $rel) {
                                            ?>
                                            <a class="list-group-item list-group-item-action <?= ($r == 1) ? 'active' : ''; ?>"
                                                id="list-home-list" data-bs-toggle="list" href="#relation<?= $rel->id; ?>"
                                                role="tab" aria-selected="true"><?= $rel->reltype; ?></a>
                                            <?php $r++;
                                        } ?>
                                        <!--   <a class="list-group-item list-group-item-action" id="list-profile-list" data-bs-toggle="list" href="#list-profile" role="tab" aria-selected="false">Profile</a> 

                                          <a class="list-group-item list-group-item-action" id="list-messages-list" data-bs-toggle="list" href="#list-messages" role="tab" aria-selected="false">Messages</a>

                                          <a class="list-group-item list-group-item-action" id="list-settings-list" data-bs-toggle="list" href="#list-settings" role="tab" aria-selected="false">Settings</a> -->
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xl-6">
                                    <div class="tab-content" id="nav-tabContent">
                                        <?php
                                        $aa = 1;
                                        $rel = $this->qm->all('fm_relation_tbl', '*', array('cid' => $cid, 'pid' => $pid));
                                        foreach ($rel as $rel) {
                                            ?>
                                            <div class="tab-pane fade <?= ($aa == 1) ? 'show active' : ''; ?>"
                                                id="relation<?= $rel->id; ?>">
                                                <h4 class="mb-4">Max Entry : <?= $rel->max_entry; ?></h4>
                                                <h4 class="mb-4">Is Publish :
                                                    <?= $rel->is_publish == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>'; ?>
                                                </h4>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#static<?= $rel->id; ?>"> <i
                                                        class="fas fa-pencil-alt"></i> Edit</button>
                                                <div class="modal fade" id="static<?= $rel->id; ?>"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form class="form-group" method="POST"
                                                                action="<?= base_url('clients/updrelation'); ?>/<?= $rel->id; ?>/<?= $cid; ?>/<?= $pid; ?>">
                                                                <div class="modal-body">

                                                                    <?php
                                                                    $rt = $this->qm->all("fm_relation_tbl", "*", array('id' => $rel->id));
                                                                    foreach ($rt as $rt) {
                                                                        ?>
                                                                        <div class="row">
                                                                            <div class="col-lg-12">
                                                                                <label class="form-label">Relation Type</label>
                                                                                <select class="form-control" name="reltype">

                                                                                    <option>Select Relation</option>
                                                                                    <option value="Self"
                                                                                        <?= ($rt->reltype == 'Self') ? 'selected' : ''; ?>>
                                                                                        Self</option>
                                                                                    <option value="Spouse"
                                                                                        <?= ($rt->reltype == 'Spouse') ? 'selected' : ''; ?>>
                                                                                        Spouse</option>
                                                                                    <option value="Kid"
                                                                                        <?= ($rt->reltype == 'Kid') ? 'selected' : ''; ?>>
                                                                                        Kid</option>
                                                                                    <option value="Mother"
                                                                                        <?= ($rt->reltype == 'Mother') ? 'selected' : ''; ?>>
                                                                                        Mother</option>
                                                                                    <option value="Father"
                                                                                        <?= ($rt->reltype == 'Father') ? 'selected' : ''; ?>>
                                                                                        Father</option>
                                                                                    <option value="Mother In Law"
                                                                                        <?= ($rt->reltype == 'Mother In Law') ? 'selected' : ''; ?>>
                                                                                        Mother In Law</option>
                                                                                    <option value="Father In Law"
                                                                                        <?= ($rt->reltype == 'Father In Law') ? 'selected' : ''; ?>>
                                                                                        Father In Law</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <label class="form-label">Max Entries</label>
                                                                                <input type="text" name="max_entry"
                                                                                    value="<?= $rt->max_entry; ?>"
                                                                                    class="form-control">
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <label class="form-label">Is Publish</label>
                                                                                <select class="form-control" name="is_publish">
                                                                                    <option>Select</option>
                                                                                    <option value="1"
                                                                                        <?= $rt->is_publish == 1 ? 'selected' : ''; ?>>
                                                                                        Yes</option>
                                                                                    <option value="0"
                                                                                        <?= $rt->is_publish == 0 ? 'selected' : ''; ?>>
                                                                                        No</option>
                                                                                </select>

                                                                            </div>

                                                                        </div>
                                                                    <?php } ?>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Update</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $aa++;
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
          
          
          
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
       <h4 style="text-align:center">STEP2-Upload/Update Details of Enrolled Employees</h4>
      </button>
    </h2>
    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body">
           <a href="<?= base_url('clients/employees'); ?>/<?= $cid; ?>/<?= $pid; ?>"
                                class="btn btn-success" aria-expanded="false"><span
                                    class="btn-icon-start text-success"><i class="fa fa-users"></i>
                                </span>Employees </a>
          
      </div>
    </div>
  </div>
  
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingThree">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
               <h4 style="text-align:center">STEP3- Create Escalation Matrix</h4>
              </button>
            </h2>
            <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">
                  
                     <div class="row">
            <!--                   <div class="col-lg-12">-->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">RiskBirbal List</h4>
                        <?php
                        $riskchk = $this->qm->single("fm_escalationmetrix_tbl", "*", array('cid' => $cid, 'pid' => $pid, 'type' => 'riskbirbal'));
                        if ($riskchk->id < 1) {
                            ?>
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="modal"
                                data-bs-target="#riskbirbal"> Add Riskbirbal </button>
                        <?php } ?>
                        <div class="modal fade" id="riskbirbal" data-bs-backdrop="riskbirbal" data-bs-keyboard="false"
                            tabindex="-1" aria-labelledby="addrelationBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form class="form-group" method="POST"
                                        action="<?= base_url('clients/addrelationmetrix'); ?>/<?= $cid; ?>/<?= $pid; ?>">
                                        <input type="hidden" name="type" value="riskbirbal" />
                                        <div class="modal-body">


                                            <div class="row">

                                                <div class="col-lg-6">
                                                    <label class="form-label">Is Publish</label>
                                                    <select class="form-control" name="is_publish">
                                                        <option>Select</option>
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>

                                                </div>

                                                <div class="col-lg-6">
                                                    <label class="form-label">Max Entries</label>
                                                    <input type="text" name="max_entry" value="" class="form-control">
                                                </div>

                                            </div>


                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Add</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>





                    <div class="card-body">
                        <div class="basic-list-group">
                            <div class="row">
                                <div class="col-lg-6 col-xl-6">
                                    <div class="list-group mb-4 " id="list-tab" role="tablist">
                                        <?php
                                        $r = 1;
                                        $rel = $this->qm->all('fm_escalationmetrix_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'type' => 'riskbirbal'));
                                        foreach ($rel as $rel) {
                                            ?>
                                            <a class="list-group-item list-group-item-action <?= ($r == 1) ? 'active' : ''; ?>"
                                                id="list-home-list" data-bs-toggle="list" href="#relation<?= $rel->id; ?>"
                                                role="tab" aria-selected="true">Riskbirbal</a>
                                            <?php $r++;
                                        } ?>

                                    </div>
                                </div>
                                <div class="col-lg-6 col-xl-6">
                                    <div class="tab-content" id="nav-tabContent">
                                        <?php
                                        $aa = 1;
                                        $rel = $this->qm->all('fm_escalationmetrix_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'type' => 'riskbirbal'));
                                        foreach ($rel as $rel) {
                                            ?>
                                            <div class="tab-pane fade <?= ($aa == 1) ? 'show active' : ''; ?>"
                                                id="relation<?= $rel->id; ?>">
                                                <h4 class="mb-4">Max Entry : <?= $rel->max_entry; ?></h4>
                                                <h4 class="mb-4">Is Publish :
                                                    <?= $rel->is_publish == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>'; ?>
                                                </h4>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#static<?= $rel->id; ?>"> <i
                                                        class="fas fa-pencil-alt"></i> Edit</button>
                                                <div class="modal fade" id="static<?= $rel->id; ?>"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form class="form-group" method="POST"
                                                                action="<?= base_url('clients/updrelationmetrix'); ?>/<?= $rel->id; ?>/<?= $cid; ?>/<?= $pid; ?>">
                                                                <input type="hidden" name="type" value="riskbirbal" />
                                                                <div class="modal-body">
                                                                    <?php
                                                                    $rt = $this->qm->all("fm_escalationmetrix_tbl", "*", array('id' => $rel->id, 'type' => 'riskbirbal'));
                                                                    foreach ($rt as $rt) {
                                                                        ?>
                                                                        <div class="row">
                                                                            <!-- <div class="col-lg-12">
                                                                                <label class="form-label">Riskbirbal Wellconnect</label>
                                                                                 <select class="form-control" name="reltype">
                                                                                    
                                                                                    <option>Select Riskbirbal Wellconnect</option>
                                                                                    <option value="PRIMARY CONTACT: CLAIMS" <?= ($rt->reltype == 'PRIMARY CONTACT: CLAIMS') ? 'selected' : ''; ?>>PRIMARY CONTACT: CLAIMS</option>
                                                                                    <option value="PRIMARY CONTACT: ENDORSEMENT" <?= ($rt->reltype == 'PRIMARY CONTACT: ENDORSEMENT') ? 'selected' : ''; ?>>PRIMARY CONTACT: ENDORSEMENT</option>
                                                                                    <option value="PRIMARY ESCALATION: CLAIMS AND ENDORSEMENT" <?= ($rt->reltype == 'PRIMARY ESCALATION: CLAIMS AND ENDORSEMENT') ? 'selected' : ''; ?>>PRIMARY ESCALATION: CLAIMS AND ENDORSEMENT</option>
                                                                                    <option value="PRIMARY ESCALATION: RELATIONSHIP" <?= ($rt->reltype == 'PRIMARY ESCALATION: RELATIONSHIP') ? 'selected' : ''; ?>>PRIMARY ESCALATION: RELATIONSHIP</option>
                                                                                    <option value="SECOND ESCALATION: RELATIONSHIP/CLAIMS/SERVICING" <?= ($rt->reltype == 'SECOND ESCALATION: RELATIONSHIP/CLAIMS/SERVICING') ? 'selected' : ''; ?>>SECOND ESCALATION: RELATIONSHIP/CLAIMS/SERVICING</option>
                                                                                    <option value="FINAL ESCALATION: RELATIONSHIP/CLAIMS/SERVICING" <?= ($rt->reltype == 'FINAL ESCALATION: RELATIONSHIP/CLAIMS/SERVICING') ? 'selected' : ''; ?>>FINAL ESCALATION: RELATIONSHIP/CLAIMS/SERVICING</option>
                                                                                    <option value="OTHER ENTRIES: MANUAL FILL" <?= ($rt->reltype == 'OTHER ENTRIES: MANUAL FILL') ? 'selected' : ''; ?>>OTHER ENTRIES: MANUAL FILL</option>
                                                                                </select>
                                                                            </div> -->
                                                                            <div class="col-lg-6">
                                                                                <label class="form-label">Is Publish</label>
                                                                                <select class="form-control" name="is_publish">
                                                                                    <option>Select</option>
                                                                                    <option value="1"
                                                                                        <?= $rt->is_publish == 1 ? 'selected' : ''; ?>>
                                                                                        Yes</option>
                                                                                    <option value="0"
                                                                                        <?= $rt->is_publish == 0 ? 'selected' : ''; ?>>
                                                                                        No</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <label class="form-label">Max Entries</label>
                                                                                <input type="text" name="max_entry"
                                                                                    value="<?= $rt->max_entry; ?>"
                                                                                    class="form-control">
                                                                            </div>


                                                                        </div>
                                                                    <?php } ?>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Update</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $aa++;
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($riskchk->is_publish == '1') { ?>

                        <div class="card-header">
                            <h4 class="card-title">Allowed Entry</h4>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#riskbirbal123"> Entry </button>
                            <div class="modal fade" id="riskbirbal123" data-bs-backdrop="riskbirbal"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="addrelationBackdropLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form class="form-group" method="POST"
                                            action="<?= base_url('clients/addrelationmetrixnext'); ?>/<?= $cid; ?>/<?= $pid; ?>">
                                            <input type="hidden" name="type" value="riskbirbal" />
                                            <div class="modal-body">


                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <label class="form-label">Riskbirbal Wellconnect</label>

                                                        <select class="form-control" name="reltype">
                                                            <option value="">Select Type</option>
                                                            <option value="PRIMARY CONTACT: CLAIMS"
                                                                <?= ($rt->reltype == 'PRIMARY CONTACT: CLAIMS') ? 'selected' : ''; ?>>
                                                                PRIMARY CONTACT: CLAIMS</option>
                                                            <option value="PRIMARY CONTACT: ENDORSEMENT"
                                                                <?= ($rt->reltype == 'PRIMARY CONTACT: ENDORSEMENT') ? 'selected' : ''; ?>>
                                                                PRIMARY CONTACT: ENDORSEMENT</option>
                                                            <option value="PRIMARY ESCALATION: CLAIMS AND ENDORSEMENT"
                                                                <?= ($rt->reltype == 'PRIMARY ESCALATION: CLAIMS AND ENDORSEMENT') ? 'selected' : ''; ?>>
                                                                PRIMARY ESCALATION: CLAIMS AND ENDORSEMENT</option>
                                                            <option value="PRIMARY ESCALATION: RELATIONSHIP"
                                                                <?= ($rt->reltype == 'PRIMARY ESCALATION: RELATIONSHIP') ? 'selected' : ''; ?>>
                                                                PRIMARY ESCALATION: RELATIONSHIP</option>
                                                            <option value="SECOND ESCALATION: RELATIONSHIP/CLAIMS/SERVICING"
                                                                <?= ($rt->reltype == 'SECOND ESCALATION: RELATIONSHIP/CLAIMS/SERVICING') ? 'selected' : ''; ?>>
                                                                SECOND ESCALATION: RELATIONSHIP/CLAIMS/SERVICING</option>
                                                            <option value="FINAL ESCALATION: RELATIONSHIP/CLAIMS/SERVICING"
                                                                <?= ($rt->reltype == 'FINAL ESCALATION: RELATIONSHIP/CLAIMS/SERVICING') ? 'selected' : ''; ?>>
                                                                FINAL ESCALATION: RELATIONSHIP/CLAIMS/SERVICING</option>
                                                            <option value="OTHER ENTRIES: MANUAL FILL"
                                                                <?= ($rt->reltype == 'OTHER ENTRIES: MANUAL FILL') ? 'selected' : ''; ?>>
                                                                OTHER ENTRIES: MANUAL FILL</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Max Entries</label>
                                                        <input type="text" name="max_entry" value="" class="form-control">
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Is Publish</label>
                                                        <select class="form-control" name="is_publish">
                                                            <option>Select</option>
                                                            <option value="1">Yes</option>
                                                            <option value="0">No</option>
                                                        </select>

                                                    </div>



                                                </div>


                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Add</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>





                        <div class="card-body">
                            <div class="basic-list-group">
                                <div class="row">
                                    <div class="col-lg-6 col-xl-6">
                                        <div class="list-group mb-4 " id="list-tab" role="tablist">
                                            <?php
                                            $r = 1;
                                            $rel = $this->qm->all('fm_escalationmetrix_next_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'type' => 'riskbirbal'));
                                            foreach ($rel as $rel) {
                                                ?>
                                                <a class="list-group-item list-group-item-action <?= ($r == 1) ? 'active' : ''; ?>"
                                                    id="list-home-list" data-bs-toggle="list" href="#relation<?= $rel->id; ?>"
                                                    role="tab" aria-selected="true"><?= $rel->reltype ?></a>
                                                <?php $r++;
                                            } ?>

                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-xl-6">
                                        <div class="tab-content" id="nav-tabContent">
                                            <?php
                                            $aa = 1;
                                            $rel = $this->qm->all('fm_escalationmetrix_next_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'type' => 'riskbirbal'));
                                            foreach ($rel as $rel) {
                                                ?>
                                                <div class="tab-pane fade <?= ($aa == 1) ? 'show active' : ''; ?>"
                                                    id="relation<?= $rel->id; ?>">
                                                    <h4 class="mb-4">Max Entry : <?= $rel->max_entry; ?></h4>
                                                    <h4 class="mb-4">Is Publish :
                                                        <?= $rel->is_publish == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>'; ?>
                                                    </h4>
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#static<?= $rel->id; ?>"> <i
                                                            class="fas fa-pencil-alt"></i> Edit</button>
                                                    <div class="modal fade" id="static123<?= $rel->id; ?>"
                                                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                        aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form class="form-group" method="POST"
                                                                    action="<?= base_url('clients/updrelationmetrix'); ?>/<?= $rel->id; ?>/<?= $cid; ?>/<?= $pid; ?>">
                                                                    <input type="hidden" name="type" value="riskbirbal" />
                                                                    <div class="modal-body">
                                                                        <?php
                                                                        $rt = $this->qm->all("fm_escalationmetrix_tbl", "*", array('id' => $rel->id, 'type' => 'riskbirbal'));
                                                                        foreach ($rt as $rt) {
                                                                            ?>
                                                                            <div class="row">
                                                                                <div class="col-lg-12">
                                                                                    <label class="form-label">Riskbirbal
                                                                                        Wellconnect</label>
                                                                                    <select class="form-control" name="reltype">

                                                                                        <option>Select Riskbirbal Wellconnect
                                                                                        </option>
                                                                                        <option value="PRIMARY CONTACT: CLAIMS"
                                                                                            <?= ($rt->reltype == 'PRIMARY CONTACT: CLAIMS') ? 'selected' : ''; ?>>
                                                                                            PRIMARY CONTACT: CLAIMS</option>
                                                                                        <option value="PRIMARY CONTACT: ENDORSEMENT"
                                                                                            <?= ($rt->reltype == 'PRIMARY CONTACT: ENDORSEMENT') ? 'selected' : ''; ?>>
                                                                                            PRIMARY CONTACT: ENDORSEMENT</option>
                                                                                        <option
                                                                                            value="PRIMARY ESCALATION: CLAIMS AND ENDORSEMENT"
                                                                                            <?= ($rt->reltype == 'PRIMARY ESCALATION: CLAIMS AND ENDORSEMENT') ? 'selected' : ''; ?>>
                                                                                            PRIMARY ESCALATION: CLAIMS AND
                                                                                            ENDORSEMENT</option>
                                                                                        <option
                                                                                            value="PRIMARY ESCALATION: RELATIONSHIP"
                                                                                            <?= ($rt->reltype == 'PRIMARY ESCALATION: RELATIONSHIP') ? 'selected' : ''; ?>>
                                                                                            PRIMARY ESCALATION: RELATIONSHIP
                                                                                        </option>
                                                                                        <option
                                                                                            value="SECOND ESCALATION: RELATIONSHIP/CLAIMS/SERVICING"
                                                                                            <?= ($rt->reltype == 'SECOND ESCALATION: RELATIONSHIP/CLAIMS/SERVICING') ? 'selected' : ''; ?>>
                                                                                            SECOND ESCALATION:
                                                                                            RELATIONSHIP/CLAIMS/SERVICING</option>
                                                                                        <option
                                                                                            value="FINAL ESCALATION: RELATIONSHIP/CLAIMS/SERVICING"
                                                                                            <?= ($rt->reltype == 'FINAL ESCALATION: RELATIONSHIP/CLAIMS/SERVICING') ? 'selected' : ''; ?>>
                                                                                            FINAL ESCALATION:
                                                                                            RELATIONSHIP/CLAIMS/SERVICING</option>
                                                                                        <option value="OTHER ENTRIES: MANUAL FILL"
                                                                                            <?= ($rt->reltype == 'OTHER ENTRIES: MANUAL FILL') ? 'selected' : ''; ?>>
                                                                                            OTHER ENTRIES: MANUAL FILL</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <label class="form-label">Is Publish</label>
                                                                                    <select class="form-control" name="is_publish">
                                                                                        <option>Select</option>
                                                                                        <option value="1"
                                                                                            <?= $rt->is_publish == 1 ? 'selected' : ''; ?>>
                                                                                            Yes</option>
                                                                                        <option value="0"
                                                                                            <?= $rt->is_publish == 0 ? 'selected' : ''; ?>>
                                                                                            No</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <label class="form-label">Max Entries</label>
                                                                                    <input type="text" name="max_entry"
                                                                                        value="<?= $rt->max_entry; ?>"
                                                                                        class="form-control">
                                                                                </div>


                                                                            </div>
                                                                        <?php } ?>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Update</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                $aa++;
                                            }
                                            ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>








                        <div class="row" id="viewmembers" style="padding:10px">
                            <div class="col-md-12 col-sm-12">
                                <div class="card membr-list-crd" style="border:0px !important">
                                    <h2>Riskbirbal Details </h2>
                                    <?php
                                    $cnt = 0;
                                    $rel = $this->qm->all("fm_escalationmetrix_next_tbl", "*", array('type' => 'riskbirbal', 'pid' => $pid, 'cid' => $cid));
                                    foreach ($rel as $row) {
                                        $cnt++;
                                        //if ($row->max_entry > 0) {
                                        for ($z = 0; $z < $row->max_entry; $z++) {
                                            ?>

                                            <div class="accordion accordion-with-icon" id="accordion-riskbiabal<?= $cnt . $z ?>">
                                                <div class="accordion-item">
                                                    <div class="accordion-header rounded-lg collapsed" id="accord-6One1"
                                                        style="border: 0.0625rem solid #4a457d;" data-bs-toggle="collapse"
                                                        data-bs-target="#collapse6One1" aria-controls="collapse6One1"
                                                        aria-expanded="false" role="button">

                                                        <span class="accordion-header-text"
                                                            style="font-size: 16px;"><?= $row->reltype ?></span>
                                                        <span class="accordion-header-indicator"></span>
                                                    </div>
                                                    <div id="collapse6One1" style="padding-right: 45px;"
                                                        class="accordion__body collapse" data-bs-toggle="collapse"
                                                        data-bs-target="#collapseOne" aria-controls="collapseOne"
                                                        aria-expanded="true" role="button" aria-labelledby="accord-6One1"
                                                        data-bs-parent="#accordion-six1">
                                                        <div class="accordion-body-text active"
                                                            style="text-transform: uppercase; color: #000">
                                                            <div class="basic-form">
                                                                <form method="post"
                                                                    action="<?= base_url('clients/addmetrix/' . $cid . '/' . $pid) ?>">
                                                                    <input type="hidden" name="reltype"
                                                                        value="<?= $row->reltype ?>" />
                                                                    <input type="hidden" name="type" value="riskbirbal" />

                                                                    <?php
                                                                    $sd = $this->qm->all("fm_escalationmetrix_entry_tbl", "*", array('type' => 'riskbirbal', 'pid' => $pid, 'cid' => $cid, 'reltype' => $row->reltype));
                                                                    //print_r($sd);
                                                                    if (isset($sd) && count($sd) > 0) {

                                                                        foreach ($sd as $row) {
                                                                            echo "<p>Name: " . $row->name . "<br>";
                                                                            echo "Email: " . $row->email . "<br>";
                                                                            echo "Contact No: " . $row->contact . "</p>";
                                                                        }
                                                                    } else {
                                                                        ?>

                                                                        <div class="col-lg-12 col-md-6">
                                                                            <div class="form-group">
                                                                                <label> Name</label>
                                                                                <!--                        <input type="text" name="question" class="form-control" placeholder=" Question">-->
                                                                                <?php if ($row->reltype != 'OTHER ENTRY') { ?>
                                                                                    <select class="form-control" name="name">
                                                                                        <option>Select Users</option>
                                                                                        <?php $ins = $this->qm->all2("ad_user", "*", array('is_deleted' => '0'));
                                                                                        foreach ($ins as $row1) { ?>
                                                                                            <option
                                                                                                value="<?= $row1->firstname . ' ' . $row1->lastname ?>">
                                                                                                <?= $row1->firstname . ' ' . $row1->lastname ?>
                                                                                            </option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                <?php } else { ?>
                                                                                    <input type="text" required="" name="name"
                                                                                        class="form-control" />
                                                                                <?php } ?>

                                                                            </div>
                                                                            <br>
                                                                        </div>
                                                                        <?php $this->load->view('clients/metrix') ?>

                                                                    <?php } ?>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>

                                        <?php //}
                                        }
                                    }
                                    ?>




                                </div>
                            </div>
                        </div>

                    <?php } ?>
                </div>
            </div>



            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">TPA LIST</h4>
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="modal" data-bs-target="#addtpa">
                            Add TPA </button>
                        <div class="modal fade" id="addtpa" data-bs-backdrop="addtpa" data-bs-keyboard="false"
                            tabindex="-1" aria-labelledby="addrelationBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form class="form-group" method="POST"
                                        action="<?= base_url('clients/addrelationmetrix'); ?>/<?= $cid; ?>/<?= $pid; ?>">
                                        <input type="hidden" name="type" value="tpa" />
                                        <div class="modal-body">


                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label class="form-label">Add TPA Account</label>
                                                    <select class="form-control" name="name">
                                                        <option>Select TPA</option>
                                                        <?php $ins = $this->qm->all2("ad_crm_account", "*", array('account_type_id' => '5'));
                                                        foreach ($ins as $row) {
                                                            ?>
                                                            <option value="<?= $row->account_name ?>">
                                                                <?= $row->account_name ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="form-label">Add TPA</label>

                                                    <select class="form-control" name="reltype">

                                                        <option>Select Type</option>
                                                        <option value="PRIMARY CONTACT">PRIMARY CONTACT</option>
                                                        <option value="SECONDARY CONTACT">SECONDARY CONTACT</option>
                                                        <option value="FINAL ESCALATION">FINAL ESCALATION</option>
                                                        <option value="OTHER ENTRIES">OTHER ENTRIES</option>
                                                    </select>
                                                </div>





                                                <div class="col-lg-6">
                                                    <label class="form-label">Is Publish</label>
                                                    <select class="form-control" name="is_publish">
                                                        <option>Select</option>
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>

                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="form-label">Max Entries</label>
                                                    <input type="text" name="max_entry" value="" class="form-control">
                                                </div>


                                            </div>


                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="basic-list-group">
                            <div class="row">
                                <div class="col-lg-6 col-xl-6">
                                    <div class="list-group mb-4 " id="list-tab" role="tablist">
                                        <?php
                                        $r = 1;
                                        $rel = $this->qm->all('fm_escalationmetrix_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'type' => 'tpa'));
                                        foreach ($rel as $rel) {
                                            ?>
                                            <a class="list-group-item list-group-item-action <?= ($r == 1) ? 'active' : ''; ?>"
                                                id="list-home-list" data-bs-toggle="list" href="#relation<?= $rel->id; ?>"
                                                role="tab" aria-selected="true"><?= $rel->reltype; ?></a>
                                            <?php $r++;
                                        } ?>

                                    </div>
                                </div>
                                <div class="col-lg-6 col-xl-6">
                                    <div class="tab-content" id="nav-tabContent">
                                        <?php
                                        $aa = 1;
                                        $rel = $this->qm->all('fm_escalationmetrix_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'type' => 'tpa'));
                                        foreach ($rel as $rel) {
                                            ?>
                                            <div class="tab-pane fade <?= ($aa == 1) ? 'show active' : ''; ?>"
                                                id="relation<?= $rel->id; ?>">
                                                <h4 class="mb-4">Max Entry : <?= $rel->max_entry; ?></h4>
                                                <h4 class="mb-4">Is Publish :
                                                    <?= $rel->is_publish == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>'; ?>
                                                </h4>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#static<?= $rel->id; ?>"> <i
                                                        class="fas fa-pencil-alt"></i> Edit</button>
                                                <div class="modal fade" id="static<?= $rel->id; ?>"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form class="form-group" method="POST"
                                                                action="<?= base_url('clients/updrelationmetrix'); ?>/<?= $rel->id; ?>/<?= $cid; ?>/<?= $pid; ?>">
                                                                <input type="hidden" name="type" value="tpa" />
                                                                <div class="modal-body">

                                                                    <?php
                                                                    $rt = $this->qm->all("fm_escalationmetrix_tbl", "*", array('id' => $rel->id, 'type' => 'tpa'));
                                                                    foreach ($rt as $rt) {
                                                                        ?>
                                                                        <div class="row">
                                                                            <div class="col-lg-6">
                                                                                <label class="form-label">Add TPA
                                                                                    Account</label>

                                                                                <select class="form-control" name="name">
                                                                                    <option>Select TPA</option>
                                                                                    <?php $ins = $this->qm->all2("ad_crm_account", "*", array('account_type_id' => '5'));
                                                                                    foreach ($ins as $row) {
                                                                                        ?>
                                                                                        <option value="<?= $row->account_name ?>">
                                                                                            <?= $row->account_name ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <label class="form-label">Relation Type</label>
                                                                                <select class="form-control" name="reltype">
                                                                                    <option>Select Relation</option>
                                                                                    <option value="PRIMARY CONTACT"
                                                                                        <?= ($rt->reltype == 'PRIMARY CONTACT') ? 'selected' : ''; ?>>
                                                                                        PRIMARY CONTACT</option>
                                                                                    <option value="SECONDARY CONTACT"
                                                                                        <?= ($rt->reltype == 'SECONDARY CONTACT') ? 'selected' : ''; ?>>
                                                                                        SECONDARY CONTACT</option>
                                                                                    <option value="FINAL ESCALATION"
                                                                                        <?= ($rt->reltype == 'FINAL ESCALATION') ? 'selected' : ''; ?>>
                                                                                        FINAL ESCALATION</option>
                                                                                    <option value="OTHER ENTRIES"
                                                                                        <?= ($rt->reltype == 'OTHER ENTRIES') ? 'selected' : ''; ?>>
                                                                                        OTHER ENTRIES</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <label class="form-label">Is Publish</label>
                                                                                <select class="form-control" name="is_publish">
                                                                                    <option>Select</option>
                                                                                    <option value="1"
                                                                                        <?= $rt->is_publish == 1 ? 'selected' : ''; ?>>
                                                                                        Yes</option>
                                                                                    <option value="0"
                                                                                        <?= $rt->is_publish == 0 ? 'selected' : ''; ?>>
                                                                                        No</option>
                                                                                </select>

                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <label class="form-label">Max Entries</label>
                                                                                <input type="text" name="max_entry"
                                                                                    value="<?= $rt->max_entry; ?>"
                                                                                    class="form-control">
                                                                            </div>


                                                                        </div>
                                                                    <?php } ?>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Update</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $aa++;
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row" id="viewmembers" style="padding:10px">
                        <div class="col-md-12 col-sm-12">
                            <div class="card membr-list-crd" style="border:0px !important">
                                <h4>TPA LIST </h4>
                                <?php
                                $cnt = 0;
                                $rel = $this->qm->all("fm_escalationmetrix_tbl", "*", array('type' => 'tpa', 'pid' => $pid, 'cid' => $cid));
                                foreach ($rel as $row) {
                                    $cnt++;
                                    if ($row->max_entry > 0) {
                                        for ($z = 0; $z < $row->max_entry; $z++) {
                                            ?>

                                            <div class="accordion accordion-with-icon" id="accordion-tpa<?= $cnt ?>">
                                                <div class="accordion-item">
                                                    <div class="accordion-header rounded-lg collapsed" id="accord-6One1"
                                                        style="border: 0.0625rem solid #4a457d;" data-bs-toggle="collapse"
                                                        data-bs-target="#collapse6One1<?= $z ?>"
                                                        aria-controls="collapse6One1<?= $z ?>" aria-expanded="false" role="button">

                                                        <span class="accordion-header-text"
                                                            style="font-size: 16px;"><?= $row->reltype ?></span>
                                                        <span class="accordion-header-indicator"></span>
                                                    </div>
                                                    <div id="collapse6One1<?= $z ?>" style="padding-right: 45px;"
                                                        class="accordion__body collapse" data-bs-toggle="collapse"
                                                        data-bs-target="#collapseOne1<?= $cnt ?>" aria-controls="collapseOne"
                                                        aria-expanded="true" role="button" aria-labelledby="accord-6One1"
                                                        data-bs-parent="#accordion-tpa<?= $cnt ?>">
                                                        <div class="accordion-body-text active"
                                                            style="text-transform: uppercase; color: #000">
                                                            <div class="basic-form">

                                                                <form method="post"
                                                                    action="<?= base_url('clients/addmetrix/' . $cid . '/' . $pid) ?>">
                                                                    <input type="hidden" name="reltype"
                                                                        value="<?= $row->reltype ?>" />
                                                                    <input type="hidden" name="type" value="tpa" />
                                                                    <?php
                                                                    $sd = $this->qm->all("fm_escalationmetrix_entry_tbl", "*", array('type' => 'tpa', 'pid' => $pid, 'cid' => $cid, 'reltype' => $row->reltype));
                                                                    //print_r($sd);
                                                                    if (isset($sd) && count($sd) > 0) {
                                                                        foreach ($sd as $row) {
                                                                            echo "<p>Name: " . $row->name . "<br>";
                                                                            echo "Email: " . $row->email . "<br>";
                                                                            echo "Contact No: " . $row->contact . "</p>";
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <div class="col-lg-12 col-md-6">
                                                                            <div class="form-group">
                                                                                <label> Name</label>
                                                                                <!--                        <input type="text" name="question
                                                    " class="form-control" placeholder=" Question">-->
                                                                                <?php if ($row->reltype != 'OTHER ENTRY') { ?>
                                                                                    <select class="form-control" name="name">
                                                                                        <option>Select Users</option>
                                                                                        <?php

                                                                                        $getchk = $this->qm->single2("ad_crm_account", "*", array('account_name' => $row->name));
                                                                                        $ins = $this->qm->all2("ad_crm_contact", "*", array('account_id' => $getchk->account_id));
                                                                                        foreach ($ins as $row) {
                                                                                            ?>
                                                                                            <option
                                                                                                value="<?= $row->firstname . " " . $row->lastname ?>">
                                                                                                <?= $row->firstname . " " . $row->lastname ?>
                                                                                            </option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                <?php } else { ?>
                                                                                    <input type="text" name="name" required=""
                                                                                        class="form-control" />
                                                                                <?php } ?>

                                                                            </div>
                                                                            <br>
                                                                        </div>
                                                                        <?php $this->load->view('clients/metrix') ?>
                                                                    <?php } ?>
                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Insurer List</h4>
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="modal"
                            data-bs-target="#addinsurer"> Add Insurer </button>
                        <div class="modal fade" id="addinsurer" data-bs-backdrop="addinsurer" data-bs-keyboard="false"
                            tabindex="-1" aria-labelledby="addrelationBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form class="form-group" method="POST"
                                        action="<?= base_url('clients/addrelationmetrix'); ?>/<?= $cid; ?>/<?= $pid; ?>">
                                        <input type="hidden" name="type" value="insurer" />
                                        <div class="modal-body">


                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label class="form-label">Add Risk Birbal</label>

                                                    <select class="form-control" name="reltype">
                                                        <option>Select Relation</option>
                                                        <option value="PRIMARY CONTACT">PRIMARY CONTACT</option>
                                                        <option value="SECONDARY CONTACT">SECONDARY CONTACT</option>
                                                        <option value="FINAL ESCALATION">FINAL ESCALATION</option>
                                                        <option value="OTHER ENTRIES">OTHER ENTRIES</option>
                                                    </select>
                                                </div>

                                                <div class="col-lg-6">
                                                    <label class="form-label">Add Insurer</label>
                                                    <select class="form-control" name="name">
                                                        <option>Select Users</option>
                                                        <?php $ins = $this->qm->all2("ad_crm_account", "*", array('account_type_id' => '1'));
                                                        foreach ($ins as $row) {
                                                            ?>
                                                            <option value="<?= $row->account_name ?>">
                                                                <?= $row->account_name ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>




                                                <div class="col-lg-6">
                                                    <label class="form-label">Is Publish</label>
                                                    <select class="form-control" name="is_publish">
                                                        <option>Select</option>
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                                    </select>

                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="form-label">Max Entries</label>
                                                    <input type="text" name="max_entry" value="" class="form-control">
                                                </div>


                                            </div>


                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Add</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="basic-list-group">
                            <div class="row">
                                <div class="col-lg-6 col-xl-6">
                                    <div class="list-group mb-4 " id="list-tab" role="tablist">
                                        <?php
                                        $r = 1;
                                        $rel = $this->qm->all('fm_escalationmetrix_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'type' => 'insurer'));
                                        foreach ($rel as $rel) {
                                            ?>
                                            <a class="list-group-item list-group-item-action <?= ($r == 1) ? 'active' : ''; ?>"
                                                id="list-home-list" data-bs-toggle="list" href="#relation<?= $rel->id; ?>"
                                                role="tab" aria-selected="true"><?= $rel->reltype; ?></a>
                                            <?php $r++;
                                        } ?>

                                    </div>
                                </div>
                                <div class="col-lg-6 col-xl-6">
                                    <div class="tab-content" id="nav-tabContent">
                                        <?php
                                        $aa = 1;
                                        $rel = $this->qm->all('fm_escalationmetrix_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'type' => 'insurer'));
                                        foreach ($rel as $rel) {
                                            ?>
                                            <div class="tab-pane fade <?= ($aa == 1) ? 'show active' : ''; ?>"
                                                id="relation<?= $rel->id; ?>">
                                                <h4 class="mb-4">Max Entry : <?= $rel->max_entry; ?></h4>
                                                <h4 class="mb-4">Is Publish :
                                                    <?= $rel->is_publish == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>'; ?>
                                                </h4>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#static<?= $rel->id; ?>"> <i
                                                        class="fas fa-pencil-alt"></i> Edit</button>
                                                <div class="modal fade" id="static<?= $rel->id; ?>"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form class="form-group" method="POST"
                                                                action="<?= base_url('clients/updrelationmetrix'); ?>/<?= $rel->id; ?>/<?= $cid; ?>/<?= $pid; ?>">
                                                                <input type="hidden" name="type" value="insurer" />
                                                                <div class="modal-body">

                                                                    <?php
                                                                    $rt = $this->qm->all("fm_escalationmetrix_tbl", "*", array('id' => $rel->id, 'type' => 'insurer'));
                                                                    foreach ($rt as $rt) {
                                                                        ?>
                                                                        <div class="row">
                                                                            <!-- <div class="col-lg-12">
                                                                                <label class="form-label">Relation Type</label>
                                                                                 <select class="form-control" name="reltype">
                                                                                    
                                                                                    <option>Select Relation</option>
                                                                                    <option value="PRIMARY CONTACT" <?= ($rt->reltype == 'PRIMARY CONTACT') ? 'selected' : ''; ?>>PRIMARY CONTACT</option>
                                                                                    <option value="SECONDARY CONTACT" <?= ($rt->reltype == 'SECONDARY CONTACT') ? 'selected' : ''; ?>>SECONDARY CONTACT</option>
                                                                                    <option value="FINAL ESCALATION" <?= ($rt->reltype == 'FINAL ESCALATION') ? 'selected' : ''; ?>>FINAL ESCALATION</option>
                                                                                    <option value="OTHER ENTRIES" <?= ($rt->reltype == 'OTHER ENTRIES') ? 'selected' : ''; ?>>OTHER ENTRIES</option>
                                                                                   
                                                                                </select>
                                                                            </div> -->
                                                                            <div class="col-lg-6">
                                                                                <label class="form-label">Is Publish</label>
                                                                                <select class="form-control" name="is_publish">
                                                                                    <option>Select</option>
                                                                                    <option value="1"
                                                                                        <?= $rt->is_publish == 1 ? 'selected' : ''; ?>>
                                                                                        Yes</option>
                                                                                    <option value="0"
                                                                                        <?= $rt->is_publish == 0 ? 'selected' : ''; ?>>
                                                                                        No</option>
                                                                                </select>

                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <label class="form-label">Max Entries</label>
                                                                                <input type="text" name="max_entry"
                                                                                    value="<?= $rt->max_entry; ?>"
                                                                                    class="form-control">
                                                                            </div>


                                                                        </div>
                                                                    <?php } ?>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Update</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $aa++;
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="row" id="viewmembers" style="padding:10px">
                        <div class="col-md-12 col-sm-12">
                            <div class="card membr-list-crd" style="border:0px !important">
                                <h4>Insurer Details </h4>
                                <?php
                                $cnt = 0;
                                $rel = $this->qm->all("fm_escalationmetrix_tbl", "*", array('type' => 'insurer', 'pid' => $pid, 'cid' => $cid));
                                foreach ($rel as $row) {
                                    $cnt++;
                                    if ($row->max_entry > 0) {
                                        for ($z = 0; $z < $row->max_entry; $z++) {
                                            ?>

                                            <div class="accordion accordion-with-icon" id="accordion-insurer<?= $cnt ?>">
                                                <div class="accordion-item">
                                                    <div class="accordion-header rounded-lg collapsed" id="accord-6One1"
                                                        style="border: 0.0625rem solid #4a457d;" data-bs-toggle="collapse"
                                                        data-bs-target="#collapse6One11<?= $cnt ?>"
                                                        aria-controls="collapse6One11<?= $cnt ?>" aria-expanded="false"
                                                        role="button">

                                                        <span class="accordion-header-text"
                                                            style="font-size: 16px;"><?= $row->reltype ?></span>
                                                        <span class="accordion-header-indicator"></span>
                                                    </div>
                                                    <div id="collapse6One11<?= $cnt ?>" style="padding-right: 45px;"
                                                        class="accordion__body collapse" data-bs-toggle="collapse"
                                                        data-bs-target="#collapseOne" aria-controls="collapseOne"
                                                        aria-expanded="true" role="button" aria-labelledby="accord-6One1"
                                                        data-bs-parent="#accordion-insurer<?= $cnt ?>">
                                                        <div class="accordion-body-text active"
                                                            style="text-transform: uppercase; color: #000">
                                                            <div class="basic-form">


                                                                <form method="post"
                                                                    action="<?= base_url('clients/addmetrix/' . $cid . '/' . $pid) ?>">
                                                                    <input type="hidden" name="reltype"
                                                                        value="<?= $row->reltype ?>" />
                                                                    <input type="hidden" name="type" value="insurer" />

                                                                    <?php
                                                                    $sd = $this->qm->all("fm_escalationmetrix_entry_tbl", "*", array('type' => 'insurer', 'pid' => $pid, 'cid' => $cid, 'reltype' => $row->reltype));
                                                                    //print_r($sd);
                                                                    if (isset($sd) && count($sd) > 0) {
                                                                        foreach ($sd as $row) {
                                                                            echo "<p>Name: " . $row->name . "<br>";
                                                                            echo "Email: " . $row->email . "<br>";
                                                                            echo "Contact No: " . $row->contact . "</p>";
                                                                        }
                                                                    } else {
                                                                        ?>




                                                                        <div class="col-lg-12 col-md-6">
                                                                            <div class="form-group">
                                                                                <label> Name</label>
                                                                                <!--                        <input type="text" name="question" class="form-control" placeholder=" Question">-->
                                                                                <?php if ($row->reltype != 'OTHER ENTRY') { ?>
                                                                                    <select class="form-control" name="name">
                                                                                        <option>Select Users</option>
                                                                                        <?php $ins = $this->qm->all2("ad_crm_account", "*", array('account_type_id' => '1'));
                                                                                        foreach ($ins as $row) {
                                                                                            ?>
                                                                                            <option value="<?= $row->account_name ?>">
                                                                                                <?= $row->account_name ?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                <?php } else { ?>
                                                                                    <input type="text" name="name" required=""
                                                                                        class="form-control" placeholder="" />
                                                                                <?php } ?>

                                                                            </div>
                                                                            <br>
                                                                        </div>

                                                                        <?php $this->load->view('clients/metrix') ?>
                                                                    <?php } ?>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>

                                        <?php }
                                    }
                                }
                                ?>




                            </div>
                        </div>
                    </div>


                </div>





            </div>

        </div>
              </div>
            </div>
          </div>
          
          
          
          
          
           <div class="accordion-item">
                 <h2 class="accordion-header" id="flush-headingFour">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                <h4 style="text-align:center">STEP4-Add Orientation PPT ,Add FAQs,Add Network Hospital List and Blacklist Hospital,Set Claim Summary and Claim Tracking</h4>
              </button>
            </h2>
            <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">
                    <div class="row">
           




            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-block">

                        <div class="btn-group mt-2" role="group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false"><span class="btn-icon-start text-primary"><i
                                        class="fa fa-file-powerpoint"></i>
                                </span>PPT </button>
                            <div class="dropdown-menu" style="margin: 0px;">
                                <button type="button" onclick="getForm(this.value, <?= $cid; ?>, <?= $pid; ?>)"
                                    class="dropdown-item" value="1">Add PPT</button>
                                <button type="button" onclick="getForm(this.value, <?= $cid; ?>, <?= $pid; ?>)"
                                    class="dropdown-item" value="2">View PPT</button>
                            </div>
                        </div>
                        <div class="btn-group mt-2" role="group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false"><span class="btn-icon-start text-primary"><i
                                        class="fa fa-comments"></i>
                                </span>FAQ </button>
                            <div class="dropdown-menu" style="margin: 0px;">
                                <button type="button" onclick="getForm(this.value, <?= $cid; ?>, <?= $pid; ?>)"
                                    class="dropdown-item" value="3">Add</button>
                                <button type="button" onclick="getForm(this.value, <?= $cid; ?>, <?= $pid; ?>)"
                                    class="dropdown-item" value="4">View</button>
                            </div>
                        </div>
                        <div class="btn-group mt-2" role="group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false"><span class="btn-icon-start text-primary"><i
                                        class="fa fa-images"></i>
                                </span>Upload Banner </button>
                            <div class="dropdown-menu" style="margin: 0px;">
                                <button type="button" onclick="getForm(this.value, <?= $cid; ?>, <?= $pid; ?>)"
                                    class="dropdown-item" value="5">Banner</button>

                            </div>
                        </div>

                        <!--<div class="btn-group mt-2" role="group">-->
                        <!--    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"-->
                        <!--        aria-expanded="false"><span class="btn-icon-start text-primary"><i-->
                        <!--                class="fa fa-question"></i>-->
                        <!--        </span>Claim Process </button>-->
                        <!--    <div class="dropdown-menu" style="margin: 0px;">-->
                        <!--        <button type="button" onclick="getForm(this.value, <?= $cid; ?>, <?= $pid; ?>)"-->
                        <!--            class="dropdown-item" value="6">Add</button>-->
                        <!--        <button type="button" onclick="getForm(this.value, <?= $cid; ?>, <?= $pid; ?>)"-->
                        <!--            class="dropdown-item" value="7">View</button>-->
                        <!--    </div>-->
                        <!--</div>-->
                        <div class="btn-group mt-2" role="group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false"><span class="btn-icon-start text-primary"><i
                                        class="fa fa-file"></i>
                                </span>Client Document </button>
                            <div class="dropdown-menu" style="margin: 0px;">
                                <button type="button" onclick="getForm(this.value, <?= $cid; ?>, <?= $pid; ?>)"
                                    class="dropdown-item" value="8">Add</button>
                                <button type="button" onclick="getForm(this.value, <?= $cid; ?>, <?= $pid; ?>)"
                                    class="dropdown-item" value="9">View</button>
                            </div>
                        </div>
                        <div class="btn-group mt-2" role="group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false"><span class="btn-icon-start text-primary"><i
                                        class="fa fa-file"></i>
                                </span>Claim Summary </button>
                            <div class="dropdown-menu" style="margin: 0px;">
                                <button type="button" id="btn-open-csum"
                                    onclick="getForm(this.value, <?= $cid; ?>, <?= $pid; ?>)" class="dropdown-item"
                                    value="10">View</button>
                            </div>
                        </div>
                        <div class="btn-group mt-2" role="group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false"><span class="btn-icon-start text-primary"><i
                                        class="fa fa-file"></i>
                                </span>Claim Tracking </button>
                            <div class="dropdown-menu" style="margin: 0px;">
                                <button type="button" id="btn-open-ctrack"
                                    onclick="getForm(this.value, <?= $cid; ?>, <?= $pid; ?>)" class="dropdown-item"
                                    value="11">View</button>
                            </div>
                        </div>
                        <div class="btn-group mt-2" role="group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false"><span class="btn-icon-start text-primary"><i
                                        class="fa fa-file"></i>
                                </span>Endorsment Calculations </button>
                            <div class="dropdown-menu" style="margin: 0px;">
                                <button type="button" id="btn-open-endclc"
                                    onclick="getForm(this.value, <?= $cid; ?>, <?= $pid; ?>)" class="dropdown-item"
                                    value="12">View</button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body" id="dem">
                        <?php
                        if (!empty($this->session->flashdata('success'))) {

                            $success = $this->session->flashdata('success');
                            ?>
                            <div class="alert alert-success alert-dismissible fade show" style="width: 25%;">

                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                                </button>
                                <strong>Success!</strong><?= $success; ?>
                            </div>
                            <?php
                        } else if (!empty($this->session->flashdata('error'))) {
                            $error = $this->session->flashdata('error');
                            ?>
                                <div class="alert alert-danger alert-dismissible fade show" style="width: 25%;">

                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                                    </button>
                                    <strong>Error!</strong> <?= $error; ?>
                                </div>
                        <?php } else {
                        } ?>
                    </div>
                </div>
            </div>


                  
                  
              </div>
            </div>
          </div>
          
          
          
          
       
          
       
          
        
          
          
          
          
          
          
          
        </div>
    </div>
           
           
           
           
           
           
           
           
           
           
           
           
           
           
           
           
           
            <!-- <div class="col-lg-7">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Welcome Message</h4>
                        <a href="<?= base_url('clients/message'); ?>/<?= $cid; ?>/<?= $pid; ?>" class="btn btn-dark">Add Message</a>
                    </div>
                    <div class="card-body">
                        
                        <div class="default-tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <?php
                                $a = 1;
                                $well = $this->qm->all("welcomemsg_tbl", "*", array('cid' => $cid, 'pid' => $pid));
                                foreach ($well as $well) {
                                    ?>       
                                    <li class="nav-item">
                                        <a class="nav-link <?= ($a == 1) ? 'active' : ''; ?>" data-bs-toggle="tab" href="#message<?= $well->id; ?>"><i class="la la-envelope me-2"></i>   <?= $well->type; ?></a>
                                    </li>
                                    <?php $a++;
                                } ?>
                            </ul>
                            <div class="tab-content">
                                <?php
                                $ab = 1;
                                $well = $this->qm->all("welcomemsg_tbl", "*", array('cid' => $cid, 'pid' => $pid));
                                foreach ($well as $well) {
                                    ?>    
                                    <div class="tab-pane fade <?= ($ab == 1) ? 'show active' : ''; ?>" id="message<?= $well->id; ?>">
                                        <div class="pt-4">

                                            <?= $well->msg; ?><br>
                                            <a href="<?= base_url('clients/editmessage'); ?>/<?= $well->id; ?>/<?= $cid; ?>/<?= $pid; ?>" class="btn btn-primary">
                                                <i class="fas fa-pencil-alt"></i> Edit</a>
                                        </div>
                                    </div>

                                    <?php
                                    $ab++;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
      


        </div>

     


    </div>
</div>
<!--**********************************
   Content body end
   ***********************************-->
<!--**********************************
   Footer start
   ***********************************-->

<script type="text/javascript">
function getForm(val, cid, pid) {

    $.ajax({

        method: "GET",
        url: "<?= base_url('clients/getform/'); ?>" + val + '/' + cid + '/' + pid,
        dataType: 'html',
        success: function(data) {

            $('#dem').html(data);

        }

    });
}
<?php
if (isset($_GET['t']) && !empty($_GET['t'])) {
    ?>
    setTimeout(() => {
        document.getElementById('btn-open-<?php echo $_GET['t']; ?>').click();
    }, 2000);
    <?php
}
?>
</script>