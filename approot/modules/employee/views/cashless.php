  <div class="content-body" style="background:#fff;">
    <!-- row --> <?php
            $rec = $this->qm->single("ri_clientpolicy_tbl","*",array('cid'=>$cid));
            $emp = $this->qm->single("ri_employee_tbl","*",array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid));
            ?> <div class="container-fluid">
                
             <div class="row page-titles custm-page-ttls">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item active"><a href="<?= base_url('clients/focusedclaim');?>">Focused Claim Status</a> | </li>
                     <li class="breadcrumb-item"><a href="javascript:void(0)">Cashless claim process</a></li>
                  </ol>
                 
               </div>     
                      
      <div class="row">
          
        <div class="col-xl-12 col-md-12 col-sm-12">
            <h4 class="cashless-pro-head">Cashless Claim Process</h4>
            <img src="https://wellconnect.riskbirbal.com/external/images/process-1.png" alt="" class="">
        </div>
        
        <div class="col-xl-12 col-md-12 col-sm-12">
            <div class="cashless-pro-stp">
                <p>
                <sup>*</sup>Important Note- Cashless Hospitalization can be availed only at network Hospital.
            </p>
                <div class="accordion accordion-rounded-stylish accordion-bordered" id="accordion-eleven">
								  <div class="accordion-item">
									<div class="accordion-header accordion-bdr  rounded-lg" id="accord-11One" data-bs-toggle="collapse" data-bs-target="#collapse11One" aria-controls="collapse11One"   aria-expanded="true"  role="button">
										<span class="accordion-header-icon"></span>
									  <span class="accordion-header-text"><h4><span>Step 1:</span>        PRE-AUTHORIZATION BEFORE ADMISSION</h4></span>
									  <span class="accordion-header-indicator"></span>
									</div>
									<div id="collapse11One" class="collapse accordion__body show body-bdr" aria-labelledby="accord-11One" data-bs-parent="#accordion-eleven">
									  <div class="accordion-body-text">
										 <p>Insured member needs to carry a Valid Photo ID Proof and Medical/TPA Card to the Hospital. Then get pre-authorized Hospitalization with the TPA Help Desk where Hospital will request Pre-authorization from the TPA and Insurance Company with prescription and medical Tests of Employee/Patient.(*Note: Employee can get cashless approved up to 7 days before admission.)</p>
									  </div>
									</div>
								  </div>
								  <div class="accordion-item">
									<div class="accordion-header accordion-bdr collapsed rounded-lg" id="accord-11Two" data-bs-toggle="collapse" data-bs-target="#collapse11Two" aria-controls="collapse11Two"   aria-expanded="true"  role="button">
										<span class="accordion-header-icon"></span>
									  <span class="accordion-header-text"><h4><span>Step 2:</span>        ADMISSION</h4></span>
									  <span class="accordion-header-indicator"></span>
									</div>
									<div id="collapse11Two" class="collapse accordion__body body-bdr" aria-labelledby="accord-11Two" data-bs-parent="#accordion-eleven">
									  <div class="accordion-body-text">
										<p>Insurance company/TPA will provide a letter of credit/Cashless with Initial approval and you can get admission in the Hospital by showing Valid photo ID and Medical/TPA Card.(*Note- In case there is any query by TPA or Insurance company that need to be first answered after that you will get initial approval)</p>
									  </div>
									</div>
								  </div>
								  <div class="accordion-item">
									<div class="accordion-header accordion-bdr collapsed rounded-lg" id="accord-11Three" data-bs-toggle="collapse" data-bs-target="#collapse11Three" aria-controls="collapse11Three"   aria-expanded="true"  role="button">
										<span class="accordion-header-icon"></span>
									  <span class="accordion-header-text"><h4><span>Step 3:</span>        TREATMENT</h4></span>
									   <span class="accordion-header-indicator"></span>
									</div>
									<div id="collapse11Three" class="collapse accordion__body body-bdr" aria-labelledby="accord-11Three" data-bs-parent="#accordion-eleven">
									  <div class="accordion-body-text">
										 <p>Insured member gets the treatment and bills will be send directly to the TPA or Insurance company. In case the insured member treatment is lengthen then Claim enhancement will be shared to TPA or Insurance company.</p>
									  </div>
									</div>
								  </div>
								   <div class="accordion-item">
									<div class="accordion-header accordion-bdr collapsed rounded-lg" id="accord-11Three" data-bs-toggle="collapse" data-bs-target="#collapse11Three" aria-controls="collapse11Three"   aria-expanded="true"  role="button">
										<span class="accordion-header-icon"></span>
									  <span class="accordion-header-text"><h4><span>Step 4:</span>        FINAL DISCHARGE</h4></span>
									   <span class="accordion-header-indicator"></span>
									</div>
									<div id="collapse11Three" class="collapse accordion__body body-bdr" aria-labelledby="accord-11Three" data-bs-parent="#accordion-eleven">
									  <div class="accordion-body-text">
										 <p>Hospital will send the final discharge document and summary to the TPA or Insurance Company which will be settled by the Insurance company as per the Policy terms and conditions. Any unapproved amount needs to be paid by the Insured member.(*Note: Cashless Claim without any query will settle in 3 hours after receipt of complete information from Hospital)</p>
									  </div>
									</div>
								  </div>
								</div> 
                            </div>
                         </div>
           
      </div>
      
      
    </div>
  </div>
  
  <script>
  $(document).ready(function () {
    $('#example').DataTable();
});
  </script>
  
  
  <style>
  
      .left-section-box h6 {
    font-size: 1rem;
    font-weight: 500;
    color: #0e3551;
    margin: 0;
}
      .crd-pd {
    padding: 2rem;
}
.crd-pd ul li {
    margin: 15px 0px;
}
.crd-pd ul li a {
    font-size: 28px;
    font-weight: 500;
    color: #088069;
}

.sd-shape {
    animation: movedelement 10s linear infinite;
    width: 75%;
    transform: scale(1.1);
    position: relative;
    z-index: 1;
}
.left-section{
     margin-top: 50px;
}
  </style>