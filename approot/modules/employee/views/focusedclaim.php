  <div class="content-body" style="background:#fff;">
    <?php
            $rec = $this->qm->single("ri_clientpolicy_tbl","*",array('cid'=>$cid));
            $emp = $this->qm->single("ri_employee_tbl","*",array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid));
            $dock = $this->qm->all("client_doc_tbl","*",array('cid'=>$cid,'pid'=>$pid,'doc_cate'=>'1'));
            $comp = $this->qm->single("ri_clients_tbl","*",array('cid'=>$cid));
            ?> <div class="container-fluid">
                
                
                      
      <div class="row">
          <?php
            $pp=$this->qm->single("ri_clientpolicy_tbl","*",array('cid'=>$cid,'id'=>$pid));
            //print_r($pp);
            $policy = $this->qm->single2("ad_policy","*",array('policy_no'=>$pp->policy_num));
            $hc = $this->qm->all2("ad_policy_health_claim","*",array('policy_id'=>$policy->policy_id,'employee_no'=>$emp->emp_id));
        ?>
          
        <div class="col-xl-6">
         <div class="card">
                  <div class="card-body" style="padding: 3rem 2rem;">
            <div class="row">
                <div class="col-md-7">
                    <div class="left-section-box">
                            <h3><?=$comp->cname?></h3>
                            <h3><?=$rec->policy_num?></h3>
                            <h2 style="font-weight: 900; color: #1e5fa5;">Total Focused Claims</h2>
                            <h2 style="font-weight: 900; text-align: center; color: #1e5fa5;"><?=count($hc)?></h2>
                            <br />
                            
                            
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="left-section">
                             <img src="https://wellconnect.riskbirbal.com/external/images/avatar/claim.png" alt="" class="sd-shape">
                    </div>
                   
                   
                </div>
                <div class="" style="margin-top: 20px;">
                    <p style="font-size: 1.3rem;">Reimbursement Claims for which you want Riskbirbal Wellconnect team to focus extra ordinarily.</p>
                </div>
            </div>
            
            </div>
        </div>
        </div>
            
            
        <div class="col-xl-6">
          
          
            
            <div class="row">
									<div class="col-md-12 col-sm-12">
										<div class="card crd-pd" style="">
											<ul>
											    <?php foreach($dock as $dock){ ?>
												<li><a href="<?=$dock->docu_link?>" target="_blank"><i class="fa fa-info-circle" style="margin-right: 8px;"></i> <?=$dock->docu_name?></a></li>
												<?php } ?>
												<li><a href="<?= base_url('employee/cashless'.'/'.$cid.'/'.$pid.'/'.$eid);?>"><i class="fa fa-address-card"></i>  Cashless claim process</a></li>
												<li><a href="<?= base_url('employee/reimbursement'.'/'.$cid.'/'.$pid.'/'.$eid);?>"><i class="fa fa-address-card"></i>  Reimbursement claim Process</a></li>
												<li><a href="<?= base_url('employee/completechecklist'.'/'.$cid.'/'.$pid.'/'.$eid);?>"><i class="fa fa-address-card"></i>  Basic Document checklist</a></li>
												<li><a href="#trackclaim"><i class="fa fa-address-card"></i>  Track your Claims</a></li>
												<li><a href="<?= base_url('employee/faq'.'/'.$cid.'/'.$pid.'/'.$eid);?>"><i class="fa fa-question-circle" style="margin-right: 8px;"></i>  FAQs</a></li>
											</ul>
										</div>
									</div>
								</div>
            
        </div>
        
        
      </div>
      
      <div class="row">
          <div class="col-md-12">
           <div class="card">
                  <div class="card-body">
           <div class="">
                                    <table id="example2" class="display" style="min-width: 845px;">
                                        <thead>
                                            <tr>
                                                <th>Employee Id</th>
                                                <th>Employee Name</th>
                                                <th>Patient Name</th>
                                                <th>Claimed Amount</th>
                                                <th>Status</th>
                                                <th>Expected end date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach($hc as $hc){
                                            ?>
                                            <tr>
                                                <td><?=$hc->employee_no?></td>
                                                <td><?=$hc->emp_name?></td>
                                                <td><?=$hc->patient_name?></td>
                                                <td><?=$hc->initial_assessment?></td>
                                                <td><a href="javascript:;" class="btn btn-success"><?=$hc->claim_status?></a></td>
                                                <?php
                                                $tt = $this->qm->single2("ad_crm_process","*",array('process_id'=>$hc->process_id));
                                                ?>
                                                <td><?=date_format(date_create($tt->expected_end_date),"d/m/Y H:i:s")?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                        <!--<tfoot>
                                            <tr>
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Office</th>
                                                <th>Age</th>
                                                <th>Start date</th>
                                                <th>Salary</th>
                                            </tr>
                                        </tfoot>-->
                                    </table>
                                </div>
    
        </div>
        </div>
      </div>
      </div>
      
   
    <div class="row" id="trackclaim">
          
          <div class="col-xl-12 col-sm-12">
              <h2 style="font-weight: 900; color: #1e5fa5;">Track Your Claim</h2>
          </div>
          
          <div class="col-xl-6">
         <div class="card claim-mn-bx" style="background: #f7fffe;">
            <div class="card-body trck_claim-dtail" style="padding: 2rem 2rem;">
                <h2>Track Your Claim By Login</h2>
                    <h3>Important Information For Login</h3>
                    <h4>Health E-Card / UHID / Medical Card .: <?=$emp->card?></h4>
                    
                    <h5>Policy No .: <span><?=$rec->policy_num?></span></h5>
                    <a href="https://www.rakshatpa.com/WebPortal/Login/Anonymous/checkClaim"  target="_blank" class="btn btn-primary">Click Here</a>
                    
            </div>
        </div>
        </div>
        <div class="col-md-6" >
            <div class="card claim-mn-bx" style="background: #f7fffe;">
            <div class="card-body trck_claim-dtail" style="padding: 2rem 2rem;">
                <h2>Track Claim Directly</h2>
                <br>
                <a href="<?= base_url('employee/confidential/'.$cid.'/'.$pid.'/'.$eid);?>" class="btn btn-primary">Click Here</a>
            </div>
        </div>
        </div>
      </div>  
    
      
      
    <div class="row">
        <div class="col-xl-12 col-sm-12">
            <p class="list-detail-clik">
                    For Detailed Information Contact Riskbirbal Well Connect Executive <a href="<?=base_url('employee/contactus/'.$cid.'/'.$pid.'/'.$eid)?>">Click Here</a>
                    </p>
        </div>
    </div>
      
      
    </div>
  </div>
  
  <script>
  $(document).ready(function () {
    $('#example').DataTable();
});
  </script>
  
  