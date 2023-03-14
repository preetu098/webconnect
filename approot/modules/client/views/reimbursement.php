  <div class="content-body" style="background:#fff;">
    <!-- row --> <?php
            $rec = $this->qm->single("ri_clientpolicy_tbl","*",array('cid'=>$cid));
            $emp = $this->qm->single("ri_employee_tbl","*",array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid));
            ?> <div class="container-fluid">
                
        <div class="row page-titles custm-page-ttls">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item active"><a href="<?= base_url('clients/focusedclaim');?>">Focused Claim Status</a> | </li>
                     <li class="breadcrumb-item"><a href="javascript:void(0)">Reimbursement claim process</a></li>
                  </ol>
                 
               </div>        
               
      
       <div class="row">
          
        <div class="col-xl-12 col-md-12 col-sm-12">
            <h4 class="cashless-pro-head">Reimbursement Claim Process</h4>
            <img src="https://wellconnect.riskbirbal.com/external/images/process-2.png" alt="" class="">
        </div>
        
        <div class="col-xl-12 col-md-12 col-sm-12">
            <div class="cashless-pro-stp">
            <p>
                <sup>*</sup>Important Note- Only opt for Non- Network Hospital in Case of Emergency. Reimbursement Claim will be settled as per the Policy terms and Conditions.
            </p>
            <div class="accordion accordion-rounded-stylish accordion-bordered" id="accordion-eleven">
								  <div class="accordion-item">
									<div class="accordion-header accordion-bdr  rounded-lg" id="accord-pro-1" data-bs-toggle="collapse" data-bs-target="#collapse-pro-1" aria-controls="collapse-pro-1"   aria-expanded="true"  role="button">
										<span class="accordion-header-icon"></span>
									  <span class="accordion-header-text"><h4><span>Step 1:</span>        INTIMATION OF CLAIM</h4></span>
									  <span class="accordion-header-indicator"></span>
									</div>
									<div id="collapse-pro-1" class="collapse accordion__body show body-bdr" aria-labelledby="accord-pro-1" data-bs-parent="#accordion-eleven">
									  <div class="accordion-body-text">
										 <p>Insured member needs to intimate the HR or Intermediatory (A&M Brokers) within the 24 hours of Admission in Non-Network Hospital. Get the help from intermediatory upon admission for proper utilization of the policy to avoid any unnecessary deductions.</p>
									  </div>
									</div>
								  </div>
								  <div class="accordion-item">
									<div class="accordion-header accordion-bdr collapsed rounded-lg" id="accord-pro-2" data-bs-toggle="collapse" data-bs-target="#collapse-pro-2" aria-controls="collapse-pro-2"   aria-expanded="true"  role="button">
										<span class="accordion-header-icon"></span>
									  <span class="accordion-header-text"><h4><span>Step 2:</span>        COLLECTION AND SUBMISSION OF ORIGINAL MEDICAL DOCUMENT</h4></span>
									  <span class="accordion-header-indicator"></span>
									</div>
									<div id="collapse-pro-2" class="collapse accordion__body body-bdr" aria-labelledby="accord-pro-2" data-bs-parent="#accordion-eleven">
									  <div class="accordion-body-text">
										<p>After getting treatment Insured need to collect all the original bills along with payment receipts, Bills Summary and reports etc from the Hospital and submit it all along with Claim Form to TPA within 15-20 days from the Date of discharge.(Always provide the Document as per the attached Document Checklist)</p>
									  </div>
									</div>
								  </div>
								  <div class="accordion-item">
									<div class="accordion-header accordion-bdr collapsed rounded-lg" id="accord-pro-3" data-bs-toggle="collapse" data-bs-target="#collapse-pro-3" aria-controls="collapse-pro-3"   aria-expanded="true"  role="button">
										<span class="accordion-header-icon"></span>
									  <span class="accordion-header-text"><h4><span>Step 3:</span>        REVIEW BILLS AND MEDICAL APPROVAL</h4></span>
									   <span class="accordion-header-indicator"></span>
									</div>
									<div id="collapse-pro-3" class="collapse accordion__body body-bdr" aria-labelledby="accord-pro-3" data-bs-parent="#accordion-eleven">
									  <div class="accordion-body-text">
										 <p>TPA or Insurance company will review the documents and check the admissibility as per the policy terms and condition which can take 7-10 days for Scrutiny. After this Claim will be Medically approved from TPA or Insurance Company. In case there is any query or deficiency, insured needs to provide answer, which will be reviewed again. If claim gets repudiated then insured will be notified about the same.</p>
									  </div>
									</div>
								  </div>
								   <div class="accordion-item">
									<div class="accordion-header accordion-bdr collapsed rounded-lg" id="accord-11fr" data-bs-toggle="collapse" data-bs-target="#collapse-pro-4" aria-controls="collapse-pro-4"   aria-expanded="true"  role="button">
										<span class="accordion-header-icon"></span>
									  <span class="accordion-header-text"><h4><span>Step 4:</span>        FINAL SETTLEMENT FROM TPA OR INSURANCE COMPANY</h4></span>
									   <span class="accordion-header-indicator"></span>
									</div>
									<div id="collapse-pro-4" class="collapse accordion__body body-bdr" aria-labelledby="accord-11fr" data-bs-parent="#accordion-eleven">
									  <div class="accordion-body-text">
										 <p>Once the claim is Medically approved and all the queries are resolved. Insurance Company will settle the claim through NEFT to the Employee Directly within 5-7 working days.
            <br />
            <br />
            Disclaimer: TAT may vary as per the TPA and Insurance Company.
            </p>
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