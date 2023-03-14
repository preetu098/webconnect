  <div class="content-body" style="background:#fff;">
    <?php
            $rec = $this->qm->single("ri_clientpolicy_tbl","*",array('cid'=>$cid));
            $policy_data = $this->qm->single("ri_clientpolicy_tbl","*",array('cid'=>$cid, 'id'=>$pid));
            $emp = $this->qm->single("ri_employee_tbl","*",array('cid'=>$cid,'pid'=>$pid));
            $dock = $this->qm->all("client_doc_tbl","*",array('cid'=>$cid,'pid'=>$pid,'doc_cate'=>'1'));
            $comp = $this->qm->single("ri_clients_tbl","*",array('cid'=>$cid));
            ?> <div class="container-fluid">
                
                
                      
      <div class="row">
          <?php
          $ht=0;
            $pp=$this->qm->single("ri_clientpolicy_tbl","*",array('cid'=>$cid));
            //foreach($pp as $pp){
            $policy = $this->qm->single2("ad_policy","*",array('policy_no'=>$rec->policy_num));
            //print_r($policy);
            $hc = $this->qm->all2("ad_policy_health_claim","*",array('policy_id'=>$policy->policy_id));
            //print_r($hc);
            //$ht = $ht+count($hc);
            //}
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
                            <h2 style="font-weight: 900; text-align: center; color: #1e5fa5;"><?=count($hc);?></h2>
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
										    <?php //print_r($dock)?>
											<ul>
											    <?php foreach($dock as $dock){ ?>
												<li><a href="<?=$dock->docu_link?>" target="_blank"><i class="fa fa-info-circle" style="margin-right: 8px;"></i> <?=$dock->docu_name?></a></li>
												<?php } ?>
												<li><a href="<?= base_url('client/cashless'.'/'.$pid.'/'.$eid);?>"><i class="fa fa-address-card"></i>  Cashless claim process</a></li>
												<li><a href="<?= base_url('client/reimbursement'.'/'.$pid.'/'.$eid);?>"><i class="fa fa-address-card"></i>  Reimbursement claim Process</a></li>
												<li><a href="<?= base_url('client/completechecklist'.'/'.$pid.'/'.$eid);?>"><i class="fa fa-address-card"></i>  Basic Document checklist</a></li>
												<li><a href="#trackclaim"><i class="fa fa-address-card"></i>  Track your Claims</a></li>
												<li><a href="<?= base_url('client/faq'.'/'.$pid.'/'.$eid);?>"><i class="fa fa-question-circle" style="margin-right: 8px;"></i>  FAQs</a></li>
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
                                            //Print_r($hc);
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
    <?php if($policy_data && (!empty($policy_data->date_is_publish) || !empty($policy_data->icr_is_publish) || !empty($policy_data->amincl_is_publish) || !empty($policy_data->amsetcl_is_publish) || !empty($policy_data->amrecl_is_publish) || !empty($policy_data->amcacl_is_publish))): ?>
     <div class="row">
          
          <div class="col-xl-12 col-sm-12">
              <h2 style="font-weight: 900; color: #1e5fa5;">Claim Summary</h2>
              <?php if($policy_data && !empty($policy_data->date_is_publish)): ?>
                <h3>As on Date : <?php echo ($policy_data && !empty($policy_data->claim_summary_date)) ? date('d M, Y',strtotime($policy_data->claim_summary_date)) :'N/A'; ?><h3>
              <?php endif; ?>
              <?php if($policy_data && !empty($policy_data->icr_is_publish)): ?>
                <h6 style="font-weight: 600; color: #ff6550; font-size: 1.2rem;"> Incurred Claims Ratio (ICR %): <?php echo ($policy_data && !empty($policy_data->claim_summary_icr)) ? $policy_data->claim_summary_icr.'%' :'N/A'; ?></h6>
              <?php endif; ?>
          </div>
          
        <?php if($policy_data && !empty($policy_data->amincl_is_publish)): ?>
            <div class="col-xl-6">
                <div class="card claim-mn-bx">
                    <div class="card-body" style="padding: 3rem 2rem;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="left-section-box">
                                    <div class="row">
                                        <div class="col-xl-6 col-md-6 col-sm-12">
                                            
                                    <ul class="claim-sumry-list">
                                        <li>Total Number Of Incurred Claims</li>
                                        <li><span><?php echo ($policy_data && !empty($policy_data->claim_summary_noincl)) ? $policy_data->claim_summary_noincl :'N/A'; ?></span></li>
                                    </ul> 
                                        </div>
                                        <div class="col-xl-6 col-md-6 col-sm-12">
                                            
                                    <ul class="claim-sumry-list">
                                        <li> Amount of Incurred Claims</li>
                                        <li><span><?php echo ($policy_data && !empty($policy_data->claim_summary_amincl)) ? 'Rs.'.$policy_data->claim_summary_amincl :'N/A'; ?></span></li>
                                    </ul> 
                                        </div>
                                    </div>   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if($policy_data && !empty($policy_data->amsetcl_is_publish)): ?>
            <div class="col-xl-6">
                <div class="card claim-mn-bx">
                    <div class="card-body" style="padding: 3rem 2rem;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="left-section-box">
                                    <div class="row">
                                        <div class="col-xl-6 col-md-6 col-sm-12">
                                            
                                    <ul class="claim-sumry-list">
                                        <li>Number Of Settled Claims</li>
                                        <li><span><?php echo ($policy_data && !empty($policy_data->claim_summary_nosetcl)) ? $policy_data->claim_summary_nosetcl :'N/A'; ?></span></li>
                                    </ul> 
                                        </div>
                                        <div class="col-xl-6 col-md-6 col-sm-12">
                                            
                                    <ul class="claim-sumry-list">
                                        <li>Amount of Settled Claims</li>
                                        <li><span><?php echo ($policy_data && !empty($policy_data->claim_summary_amsetcl)) ? 'Rs.'.$policy_data->claim_summary_amsetcl :'N/A'; ?></span></li>
                                    </ul> 
                                        </div>
                                    </div>   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if($policy_data && !empty($policy_data->amrecl_is_publish)): ?>
            <div class="col-xl-6">
                <div class="card claim-mn-bx">
                    <div class="card-body" style="padding: 3rem 2rem;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="left-section-box">
                                    <div class="row">
                                        <div class="col-xl-6 col-md-6 col-sm-12">
                                            
                                    <ul class="claim-sumry-list">
                                        <li>Number Of Outstanding Reimbursement Claims</li>
                                        <li><span><?php echo ($policy_data && !empty($policy_data->claim_summary_norecl)) ? $policy_data->claim_summary_norecl :'N/A'; ?></span></li>
                                    </ul> 
                                        </div>
                                        <div class="col-xl-6 col-md-6 col-sm-12">
                                            
                                    <ul class="claim-sumry-list">
                                        <li>Amount of Outstanding Reimbursement Claims</li>
                                        <li><span><?php echo ($policy_data && !empty($policy_data->claim_summary_amrecl)) ? 'Rs.'.$policy_data->claim_summary_amrecl :'N/A'; ?></span></li>
                                    </ul> 
                                        </div>
                                    </div>   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if($policy_data && !empty($policy_data->amcacl_is_publish)): ?>
            <div class="col-xl-6">
                <div class="card claim-mn-bx">
                    <div class="card-body" style="padding: 3rem 2rem;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="left-section-box">
                                    <div class="row">
                                        <div class="col-xl-6 col-md-6 col-sm-12">
                                            
                                    <ul class="claim-sumry-list">
                                        <li>Number Of Outstanding Cashless Claims</li>
                                        <li><span><?php echo ($policy_data && !empty($policy_data->claim_summary_nocacl)) ? $policy_data->claim_summary_nocacl :'N/A'; ?></span></li>
                                    </ul> 
                                        </div>
                                        <div class="col-xl-6 col-md-6 col-sm-12">
                                            
                                    <ul class="claim-sumry-list">
                                        <li>Amount of Outstanding Cashless Claims</li>
                                        <li><span><?php echo ($policy_data && !empty($policy_data->claim_summary_amcacl)) ? 'Rs.'.$policy_data->claim_summary_amcacl :'N/A'; ?></span></li>
                                    </ul> 
                                        </div>
                                    </div>   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
      </div>
      <?php endif; ?>
      
      
   <div class="row" id="trackclaim">
          
          <div class="col-xl-12 col-sm-12">
              <h2 style="font-weight: 900; color: #1e5fa5;">Track Your Claim</h2>
          </div>
          
          <?php if($policy_data && !empty($policy_data->track_login_publish)): ?>
          <div class="col-xl-6">
         <div class="card claim-mn-bx" style="background: #f7fffe;">
            <div class="card-body trck_claim-dtail" style="padding: 2rem 2rem;">
                <h2>Track Your Claim By Login</h2>
                    <h3>Important Information For Login</h3>
                    <!--<h5>Heath E-Card / UHID / Madical Card .: <?=$emp->card?></h5>
                    
                    <h4>Policy No .: <span><?=$rec->policy_num?></span></h4>-->
                    <h5>User Id: <?php echo ($policy_data && !empty($policy_data->claim_track_id)) ? $policy_data->claim_track_id :'N/A'; ?><br> Password: <?php echo ($policy_data && !empty($policy_data->claim_track_pass)) ? $policy_data->claim_track_pass :'N/A'; ?></h5>
                    <a target="_blank" href="<?php echo ($policy_data && !empty($policy_data->claim_track_url)) ? $policy_data->claim_track_url :'javascript:void(0)'; ?>"  target="_blank" class="btn btn-primary">Click Here</a>
                    
            </div>
        </div>
        </div>
        <?php endif; ?>
        <div class="col-md-6" >
            <div class="card claim-mn-bx" style="background: #f7fffe;">
            <div class="card-body trck_claim-dtail" style="padding: 2rem 2rem;">
                <h2>Track Claim Directly</h2>
                <br>
                <a target="_blank" href="<?= base_url('client/confidential/'.$pid.'/'.$eid);?>" class="btn btn-primary">Click Here</a>
            </div>
        </div>
        </div>
      </div>  
    
      
      
  <div class="row">
        <div class="col-xl-12 col-sm-12">
            <p class="list-detail-clik">
                    For Detailed Information Contact Riskbirbal Well Connect Executive <a href="<?=base_url('client/contactus/')?>">Click Here</a>
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
  
  