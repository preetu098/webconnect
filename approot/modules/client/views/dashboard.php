  <style>
  	/*For checkbox*/

  	.checkbox-alias {
  		background-color: #dcdde3;
  		display: inline-block;
  		z-index: 1;
  		position: relative;
  		transition: all 250ms ease-out;
  		cursor: pointer;
  		height: 390px;
  		border-radius: 18px;
  		width: 100%;
  	}

  	.invisible-checkboxes input[type=radio] {
  		display: none;
  	}

  	.invisible-checkboxes input[type=radio]:checked+.checkbox-alias {
  		/*background-color: #8fea3c;*/
  		box-shadow: 0px 0px 10px 1px #f7e008;

  	}
  </style>
  <?php $pol = ""; //print_r($_SESSION); 
	?>

  <div class="content-body">
  	<!-- row -->lass
  	<div class="container-fluid">
  		<h4 style="font-size: 1.7rem;
    font-weight: 600;
    color: #654a9a;">Policies</h4>
  		<div class="">

  			<div class="row kanban-bx">
  				<?php
					$myid = $pol = $policy_numm = "";
					//print_r($result);
					$ctt = 0;
					$pid = 0;
					foreach ($result as $k => $row) {
						$type = $this->qm->single("ad_policy_type", "*", array('policy_type_id' => $row->policy_type));
						$ctt++;
						if ($ctt == '1') {
							$myid = $row->id;
							$pol = $row->policy_no;
						}
						$policy_numm = $row->policy_no;
					?>
  					<div class="col">
  						<div class="kanbanPreview-bx">
  							<div class="draggable-zone invisible-checkboxes  dropzoneContainer">
  								<input type="radio" name="rGroup" <?= ($row->id == $this->uri->segment(3)) ? "checked" : "" ?> class="checkboxnew" value="<?= $myid ?>" id="r<?= $myid ?>" />
  								<label class="checkbox-alias" for="r<?= $myid ?>">
  									<div class="card draggable-handle draggable" style="background: #f8f8f8 !important; border: 0 !important;">
  										<div class="card-body" style="padding: 0.875rem; margin: -13px;">
  											<div class="col-md-12">
  												<div class="plcy-card">
  													<div class="row">
  														<div class="col-md-9">
  															<a href="<?= base_url('client/dashboard/' . $row->id) ?>">
  																<h4 style="font-size: 18px;"><?= $row->cname ?></h4>
  															</a>
  															<p style="font-size: 14px;"><?= $type->policy_type_name ?></p>
  														</div>
  														<div class="col-md-3">
  														</div>
  													</div>
  													<div class="row">
  														<!--<div class="col-md-3">
											<h6>Corporate Neame</h6>
											
										</div>-->
  														<div class="col-md-4">
  															<h6>Policy Number</h6>
  															<a href="<?= base_url('client/dashboard/' . $row->id) ?>">
  																<h4><?= $row->policy_num ?></h4>
  															</a>
  														</div>

  														<div class="col-md-3">
  															<h6>TPA Name</h6>
  															<div class="brand-logo">
  																<p><?= $row->tpa ?></p>
  															</div>
  														</div>
  														<div class="col-md-4">

  															<div class="brand-logo">
  																<center><img src="<?= base_url('external/uploads/' . $row->iimage) ?>" style="width:100px !important;height:100px;"></center>
  															</div>
  															<!--<h4 style="padding-left: 5px;">ICICI</h4>-->
  														</div>
  													</div>

  												</div>

  												<div class="row">

  													<div class="col-md-12">
  														<div class="plcy-card plcy-card-bottom">

  															<div class="row">
  																<div class="col-md-3">
  																	<h4>Valid From</h4>
  																	<h6><?= date_format(date_create($row->sdate), "d-m-Y"); ?></h6>
  																</div>
  																<div class="col-md-3">
  																	<h4>Valid Till</h4>
  																	<h6><?= date_format(date_create($row->edate), "d-m-Y") ?></h6>
  																</div>
  																<div class="col-md-3">
  																	<h4>Sum Insured (s)</h4>
  																	<h6><?= $row->suminsured ?></h6>
  																</div>
  																<?php
																	$poli = $this->qm->single2("ad_policy", "*", array('policy_no' => $row->policy_num));
																	$tests = $this->qm->get_files($poli->policy_id);
																	$link = "https://crm.riskbirbal.com/assets/files/policy/" . $tests->file_name;
																	$cdn = $cd0 = 0;
																	$cd = $this->qm->all2("ad_policy_bank_trans", "*", array('bank_id' => $poli->cd_bank_id, 'category' => 'C'));
																	foreach ($cd as $cd) {
																		if ($cd->trans_type == 'IN') {
																			$cdn = $cdn + $cd->amount;
																		} else {
																			$cd0 = $cd0 + $cd->amount;
																		}
																	}
																	?>

  																<div class="col-md-3">
  																	<h4>CD Balance</h4>
  																	<?php if($row->policy_num=='238894514'){?>
  																	    <h6>35598</h6>
  																	<?php }else{ ?>
  																	<h6><?= ($cdn - $cd0) ?></h6>
  																	<?php } ?>
  																</div>
  															</div>
  														</div>
  													</div>
  												</div>
  												<div class="row">
  													<div class="col-md-12">
  														<div class="card-btn-section" style="background:#136eca">
  															<div class="card-btn-left">
  																<a href="<?= base_url('client/focusedclaim/' . $row->id) ?>" class="btn btn-outline-primary btn-rounded fs-18 card-slider-btn">Claims Status</a>
  																<a href="<?= base_url('client/endorsement/' . $row->id) ?>" class="btn btn-outline-primary btn-rounded fs-18 card-slider-btn">Endorsements</a>
  																<a href="<?= $link ?>" class="btn btn-outline-primary btn-rounded fs-18 card-slider-btn" download>Download Policy</a>
  																<a data-bs-toggle="modal" data-bs-target="#pop<?= $k + 1 ?>" class="btn btn-outline-primary btn-rounded fs-18 card-slider-btn">View PPT </a>
  															</div>
  														</div>
  													</div>
  												</div>
  											</div>
  										</div>
  									</div>
  								</label>

  							</div>
  						</div>
  					</div>
  					<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="pop<?= $k + 1 ?>" aria-hidden="true">
  						<div class="modal-dialog modal-lg">
  							<div class="modal-content">
  								<div class="modal-header">
  									<h5 class="modal-title">PPT</h5>
  									<button type="button" class="btn-close" data-bs-dismiss="modal">
  									</button>
  								</div>
  								<div class="modal-body">
  									<div class="col-md-12 col-sm-12">
  										<div class="ppt-slide-bx">
  											<div id="carouselExampleIndicators<?= $k + 1 ?>" class="carousel slide" data-bs-ride="carousel" style="padding: 42px;">
  												<div class="carousel-indicators">
  													<?php
														$cnt = 0;
														$img = $this->qm->all('upload_ppt_ri', '*', array('cid' => $row->cid, 'pid' => $row->id));
														foreach ($img as $img) {
															$cnt++;
														?>
  														<button type="button" data-bs-target="#carouselExampleIndicators<?= $k + 1 ?>" data-bs-slide-to="<?= $cnt ?>" <?= ($cnt == '2') ? 'class="active" aria-current="true"' : ""; ?> class="" aria-label="Slide <?= $cnt ?>"></button>
  													<?php } ?>
  												</div>
  												<div class="carousel-inner">
  													<?php
														$ss = 1;
														$img = $this->qm->all('upload_ppt_ri', '*', array('cid' => $row->cid, 'pid' => $row->id));
														foreach ($img as $img) {

														?>
  														<div class="carousel-item <?= ($ss == 1) ? 'active' : ''; ?>">
  															<img class="d-block" src="<?= base_url('external/uploads/'); ?><?= $img->ppt; ?>" style="width: 100%; background-size: contain;">
  														</div>
  													<?php
															$ss++;
														} ?>
  												</div>
  												<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators<?= $k + 1 ?>" data-bs-slide="prev">
  													<span class="carousel-control-prev-icon" aria-hidden="true"></span>
  													<span class="visually-hidden">Previous</span>
  												</button>
  												<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators<?= $k + 1 ?>" data-bs-slide="next">
  													<span class="carousel-control-next-icon" aria-hidden="true"></span>
  													<span class="visually-hidden">Next</span>
  												</button>
  											</div>
  										</div>
  									</div>
  								</div>
  							</div>
  						</div>
  					</div>
  				<?php

						if ($this->uri->segment(2) == 'dashboard' && $this->uri->segment(3) == '' && !empty($row)) {
							redirect("client/dashboard/" . $row->id);
						}
					} ?>

  			</div>
  		</div>


  		<div class="invt-emply-bx">
  			<div class="row">
  				<!-- <div class="col-xl-12 col-sm-12">
					                <h4>Invite employees</h4>
					            </div>-->
  				<div class="col-xl-6 col-sm-12">
  					<p>Download active list, e-card, employee enrollment and much more...</p>
  					<a href="<?= base_url('client/employees/' . $myid) ?>" class="btn btn-primary btn-rounded fs-18">Manage employees</a>
  				</div>
  				<div class="col-xl-6 col-sm-12">
  					<p>Invite employees to register on "well connect" to avail amazing policy benefits.</p>
  					<!--<button type="button" class="btn btn-primary fs-18" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                     Invite employees to register
                                 </button>-->
  					<button type="button" class="btn btn-primary fs-18" data-bs-toggle="modal" data-bs-target="#inviteempmodal">
  						Invite employees to register
  					</button>
  				</div>

  			</div>
  		</div>

  		<!--<div class="row">
						<div class="col-md-12">
							<div class="see-btn">
							    <a href="<?= base_url('client/employees/' . $myid) ?>" class="btn btn-primary btn-rounded fs-18">Manage employees</a>
									<!--<a href="manage-employee.php" class="btn btn-primary btn-rounded fs-18">Manage employees</a>-->


  		<!--<a href="<?= base_url('client/addemployee/' . $myid) ?>" class="btn btn-outline-primary btn-rounded fs-18">Add Employee</a>-->
  		<!--	</div>
						</div>
					</div>-->

  		<form method="post" id="mailajob">
  			<input type="hidden" id="appr-inp" name="approve" value="1">
  			<div class="col-12">
  				<div class="card">

  					<div class="card-header">
  						<h4 class="card-title">
  							<!-- Policy No.:<?= $policy_numm ?>-->

  							<span>Recent Updates</span>
  						</h4>

  						<div class="see-btn batabase-table-btn" style="margin-bottom: 20px;">
  							<a href="javascript:void(0);" onclick="document.getElementById('mailajob').submit();" class="btn btn-outline-info btn-rounded fs-18">Approve</a>
  							<a href="javascript:void(0);" onclick="document.getElementById('appr-inp').value='0';document.getElementById('mailajob').submit();" class="btn btn-outline-info btn-rounded fs-18">Reject</a>
  							<!--<a href="<?= base_url('employee/approveall/' . $pid . '/') ?>"  class="btn btn-outline-primary btn-rounded fs-18" id="approve">Approve all</a>-->
  							<!--<a href="javascript:void(0);"  class="btn btn-outline-primary btn-rounded fs-18">Delete</a>-->
  							<a href="<?= base_url('client/downloadend/' . $myid . '/3') ?>" class="btn btn-outline-info btn-rounded fs-18">Download</a>
  						</div>

  					</div>
  					<div class="card-body" style="padding: 0.875rem;">
  						<div class="table-responsive">
  							<table id="example2" class="table" class="display" style="min-width: 845px">
  								<thead>
  									<tr>
  										<th><input type="checkbox" value="all" id="selectall" /></th>
  										<th>Employee Id</th>
  										<th>Employee</th>
  										<th>Dependant</th>
  										<th>Relation &<br>Gender</th>
  										<th>Mode</th>
  										<th>Status</th>
  										<th>Doc Upload</th>
  										<th>Updated At</th>
  									</tr>
  								</thead>
  								<tbody>
  									<?php
										//$res = $this->qm->all("ri_employee_tbl","*",array('cid'=>$cid,'mode'=>'addition'));
										$res = $this->qm->all("ri_employee_tbl", "*", " cid='$cid' && status=3");
										foreach ($res as $res) {
											$com = $this->qm->single("ri_clientpolicy_tbl", "*", array('cid' => $cid));
										?>
  										<tr>
  											<td><input type="checkbox" value="<?= $res->eid ?>" name="eid[]" class="checkboxall" /></td>
  											<td><?= $res->emp_id ?></td>
  											<td><?= $res->emp_name ?></td>
  											<td><?= $res->emp_name ?></td>
  											<td>Self /<br><?= $res->gender ?></td>
  											<td><?= $res->mode ?></td>
  											<td><a href="<?= base_url('client/addemployee/' . $myid . '/' . $res->eid) ?>" class="badge badge-success"><?= ($res->status == 3) ? "Hr Approval Pending" : (($res->status == 2) ? "Under process" : "") ?></a></td>
  											<td>
  												<?php if (!empty($res->pimage)) : ?>
  													<a target="_blank" href="<?= base_url('external/uploads/' . $res->pimage) ?>">View</a>
  												<?php else : ?>
  													N/A
  												<?php endif; ?>
  											</td>
  											<td><?php echo getDMYDate($res->up_time, false); ?></td>
  										</tr>

  									<?php
										}
										$tot = $this->qm->all("ri_dependent_tbl", "*", " cid='$cid' && status=3");
										//print_r($tot);
										foreach ($tot as $rr) {
											$zz = $this->qm->single("ri_employee_tbl", "*", array('cid' => $cid, 'emp_id' => $rr->emp_id));
										?>
  										<tr>
  											<td><input type="checkbox" value="<?= $rr->did ?>" name="did[]" class="checkboxall" /></td>
  											<td><?= $zz->emp_id ?></td>
  											<td><?= $zz->emp_name ?></td>
  											<td><?= $rr->name ?></td>
  											<td><?= ($rr->reltype == 'Kid1' || $rr->reltype == 'Kid2' || $rr->reltype == 'Kid3') ? "Kid /" : $rr->reltype . " /" ?><br><?= $rr->gender ?></td>
  											<td><?= $rr->mode ?></td>
  											<td><a href="<?= base_url('client/addemployee/' . $myid . '/' . $rr->eid) ?>" class="badge badge-success"><?= ($rr->status == 3) ? "Hr Approval Pending" : (($rr->status == 2) ? "Under process" : "") ?></a></td>
  											<td>
  												<?php if (!empty($rr->pimage)) : ?>
  													<a target="_blank" href="<?= base_url('external/uploads/' . $rr->pimage) ?>">View</a>
  												<?php else : ?>
  													N/A
  												<?php endif; ?>
  											</td>
  											<td><?php echo getDMYDate($rr->updated_on, false); ?></td>
  										</tr>
  									<?php
										} ?>

  								</tbody>
  							</table>
  						</div>
  					</div>
  				</div>
  			</div>
  		</form>
  	</div>
  </div>
  </div>


  <div class="modal fade" id="inviteempmodal" tabindex="-1" aria-labelledby="inviteempmodalLabel" aria-hidden="true">
  	<div class="modal-dialog">
  		<div class="modal-content">
  			<div class="modal-header">
  				<h5 class="modal-title" id="inviteempmodalLabel">Upload Excel</h5>
  				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  			</div>
  			<div class="modal-body">
  				<form id="upload-emp-form" method="post" enctype="multipart/form-data">
  					<input type="hidden" name="cid" value="<?php echo $cid; ?>">
  					<input type="hidden" name="pid" value="<?php echo $myid; ?>">
  					<label for="img">Select image:</label>
  					<input type="file" id="employee" name="excel_upload"></br>
  					<h6>Note:-Download Template <a href="<?php echo base_url(); ?>external/employee_format.xlsx"><i class="fa fa-download"></i></a></h6>
  					<span class='error'></span><br>
  					<label for="img">HR Message:</label>
  					<textarea class="form-control" name="hr_message"></textarea>
  				</form>
  				<br>
  				<label for="img">Progress:</label>
  				<div class="progress emp-invite-progress">
  					<div class="progress-bar" style="width: 0%" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
  				</div>
  			</div>
  			<div class="modal-footer">
  				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
  				<button type="button" class="btn btn-primary upload-emp-invite-excel">Send Invites</button>
  			</div>
  		</div>
  	</div>
  </div>


  <script>
  	$(document).ready(function() {
  		// $("input[type='button']").click(function(){
  		var radioValue = $("input[name='eid[]']:checked").val();
  		if (radioValue) {
  			alert("Your are a - " + radioValue);
  		}
  		//});
  	});
  </script>