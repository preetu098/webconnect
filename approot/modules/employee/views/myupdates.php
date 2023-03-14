<div class="content-body">
            <div class="container-fluid">
				
				<div class="row page-titles">
					<ol class="breadcrumb">
						<li class="breadcrumb-item active"><a href="index.php">Home ></a></li>
						<li class="breadcrumb-item"><a href="javascript:void(0)">My Updates</a></li>
					</ol>
                </div>
                <!-- row -->


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">My Updates</h4>
								<!--<form class="months-fil">
									<input type="date" id="birthday" name="birthday">
								</form>-->
								
								</h4>
								
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
								
                                     <table id="example3_" class="table" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                
                                                <th>Employee</th>
                                                <th>Dependant</th>
                                                <th>Relation &<br>Gender</th>
                                                <th>Mode</th>
                                                <th>Status</th>
                                                <th>Doc Uploaded</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                //$res = $this->qm->all("ri_employee_tbl","*",array('cid'=>$cid,'mode'=>'addition'));
                                                $res = $this->qm->all("ri_employee_tbl","*"," cid='$cid' && pid='$pid' && eid='$eid' && status=2");
                                                foreach($res as $res){
                                                    $com = $this->qm->single("ri_clientpolicy_tbl","*",array('cid'=>$cid));
                                                ?>
                                            <tr>
                                               
                                                <td><?=$res->emp_name?></td>
                                                <td><?=$res->emp_name?></td>
                                                <td>Self /<br><?=$res->gender?></td>
                                                <td><?=$res->mode?></td>
                                                <td><a href="<?=base_url('client/addemployee/'.$pid.'/'.$res->eid)?>" class="badge badge-success"><?=($res->status==3)?"Hr Approval Pending":(($res->status==2)?"Under process":"")?></a></td>
                                                <td>N/A</td>
                                                
                                            </tr>
                                            <?php
                                            $tot = $this->qm->all("ri_dependent_tbl","*",array('cid'=>$cid,'eid'=>$res->$eid));
                                            foreach($tot as $rr){ ?>
                                                 
                                                <td><?=$res->emp_name?></td>
                                                <td><?=$rr->name?></td>
                                                <td><?=$rr->reltype?><br><?=$rr->gender?></td>
                                                <td><?=$res->mode?></td>
                                                <td><a href="<?=base_url('client/addemployee/'.$pid.'/'.$res->eid)?>" class="badge badge-success"><?=($res->status==3)?"Hr Approval Pending":(($res->status==2)?"Under process":"")?></a></td>
                                                <td>N/A</td>
                                           <?php }
                                            } ?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
				</div>
            </div>
        </div>