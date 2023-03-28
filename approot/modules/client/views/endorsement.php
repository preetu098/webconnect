<div class="content-body">
    <div class="container-fluid">
        <!--<div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="<?=base_url('')?>">Home ></a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Endorsements</a></li>
            </ol>
        </div>-->
        <!-- row -->
        <div class="row">
            <div class="col-xl-9 col-md-9 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Endorsements in Process</h4>
                        <!--<form class="months-fil">
                            <input type="date" id="birthday" name="birthday">
                        </form>-->
                        <form method="post">
                            <table class="table emplyee-filtr-bx" style="margin: 0;">
                                <tr>
                                    <td>
                                        <input type="text" name="emp_search" value="<?= (isset($_POST['emp_search'])) ? $_POST['emp_search'] : ''; ?>" placeholder="Employee ID/Name/Mode" class="form-control inpt_field" />
                                    </td>
                                    <td><input type="submit" class="btn btn-sm add_emply" value="Apply Filter" /><a href="<?= base_url('client/endorsement/' . $pid) ?>" class="btn btn-info btn-sm restbtn">Reset</a></td>
                                </tr>
                            </table>
                        </form>
                        <a href="<?=base_url('client/downloadend/'.$pid)?>/2" class="btn btn-outline-info btn-rounded btn-sm fs-18">Download</a>
                        <a href="javascript:void(0)" id="proceed_endorsment" class="btn btn-outline-info btn-rounded btn-sm fs-18">Proceed For Endorsment</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                                <table id="example_" class="table display endorsementtable" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Emp Id</th>
                                        <th>Employee</th>
                                        <th>Dependant</th>
                                        <th>Relation &<br>Gender</th>
                                        <th>Mode</th>
                                        <th>Hr Approval Date</th>
                                        <th>Status</th>
                                        <th>Doc Upload</th>                                                
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $res = $this->qm->all("ri_employee_tbl","*",array('cid'=>$cid,'mode'=>'addition'));
                                        foreach($res as $res){
                                            $com = $this->qm->single("ri_clientpolicy_tbl","*",array('cid'=>$cid));
                                        ?>
                                    <tr>
                                        <td><?=$res->emp_id?></td>
                                        <td><?=$res->emp_name?></td>
                                        <td><?=$res->emp_name?></td>
                                        <td>Self /<br><?=$res->gender?></td>
                                        <td><?=$res->mode?></td>
                                        <td><?=getDMYDate($res->hr_approval_date, false) ?></td>
                                        <td><a href="javascript:;" class="badge badge-success"><?=($res->status==3)?"Hr Approval Pending":(($res->status==2)?"Under process":"")?></a></td>
                                        <td>
                                        <?php if(!empty($res->pimage)): ?>
                                            <a target="_blank" href="<?= base_url('external/uploads/'.$res->pimage) ?>">View</a>
                                        <?php else: ?>
                                            N/A
                                        <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php 
                                    }  
                                    foreach($resDep as $rr){
                                        $empRes = $this->qm->single("ri_employee_tbl","*",array('eid'=>$rr->eid, 'relation'=>'Self', 'cid'=>$cid, 'pid'=>$pid));
                                    ?>
                                    <tr>
                                            <td><?=$rr->emp_id?></td>
                                        <td><?php echo ($empRes) ? $empRes->emp_name : ''; ?></td>
                                        <td><?=$rr->name?></td>
                                        <td><?=$rr->reltype?><br><?=$rr->gender?></td>
                                        <td><?=$rr->mode?></td>
                                        <td><?= getDMYDate($rr->hr_approval_date, false) ?></td>
                                        <td><a href="javascript:;" class="badge badge-success"><?=($rr->status==3)?"Hr Approval Pending":(($rr->status==2)?"Under process":"")?></a></td>
                                        <td>N/A</td>
                                    </tr>
                                    <?php }
                                        ?>
                                </tbody>
                            </table>
                            <p><?php //echo $links; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-3 col-sm-12">
                <div class="card">
                    <div class="endos-downlod">
                        <div class="row">
                            <div class="col-xl-12 col-sm-12">
                                <h4><i class="fas fa-download"></i> Booked Endorsement</h4>
                                <hr>
                                <ul>
                                    <?php
                                    $cnt=0;
                                    $gp = $this->qm->all("ri_clientpolicy_tbl","*",array('cid'=>$cid,'id'=>$pid));
                                    foreach($gp as $gp){
                                        $cnt++;
                                    $pol = $this->qm->single("ad_policy","*",array('policy_no'=>$gp->policy_num));
                                    $end = $this->qm->all("ad_policy_endorsement","*",array('policy_id'=>$pol->policy_id));
                                    foreach($end as $end){
                                        $rrrrr=$this->qm->get_end_files($end->endorsement_id);
                                        //print_r($rrrrr);
                                        //for($x;$x<count($rrrrr);$x++){
                                            //if(!empty($rrrrr['file'][$x])){
                                        
                                    ?>
                                            <li><a href="https://crm.riskbirbal.com/assets/files/endorsement/<?=$rrrrr[0]->file_name?>" download target="_blank"><i class="fas fa-download"></i>END-<?=$cnt?> (<?=$end->endorsement_no?>)</a></li>
                                    <?php } } //} ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
