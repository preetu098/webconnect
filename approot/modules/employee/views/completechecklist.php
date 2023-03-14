  <div class="content-body" style="background:#fff;">
    <!-- row --> <?php
            $rec = $this->qm->single("ri_clientpolicy_tbl","*",array('cid'=>$cid));
            $emp = $this->qm->single("ri_employee_tbl","*",array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid));
            ?> <div class="container-fluid">
                
        <div class="row page-titles custm-page-ttls">
                  <!--<ol class="breadcrumb">
                     <li class="breadcrumb-item active"><a href="<?= base_url('clients/focusedclaim');?>">Focused Claim Status</a> | </li>
                     <li class="breadcrumb-item"><a href="javascript:void(0)">Complete Doc Checklist</a></li>
                  </ol>-->
                 
               </div>         
       
      
       <div class="row">
          
        
        <div class="col-xl-12 col-md-12 col-sm-12">
            
            <h3 class="bsic-check-list-head">Basic Document Checklist</h3>
            <hr>
            <ul class="bsic-check-list">
                <li style="font-size: 1.3rem;"><i class="fas fa-check-circle"></i> Duly filled claim form with sign and lodged amount.</li>
                <li style="font-size: 1.3rem;"><i class="fas fa-check-circle"></i> Prescription details by treating doctor/Surgeon.</li>
                <li style="font-size: 1.3rem;"><i class="fas fa-check-circle"></i> Discharge Card or Discharge summary in original.</li>
                <li style="font-size: 1.3rem;"><i class="fas fa-check-circle"></i> Original Main Hospital bill with Bill No. and Bill Break-up (with detailed break-up of various heads like Room Rent/OT Charges/ Nursing Charges etc)</li>
                <li style="font-size: 1.3rem;"><i class="fas fa-check-circle"></i> Duly filled claim form B signed by the Hospital/Treating Doctor.</li>
                <li style="font-size: 1.3rem;"><i class="fas fa-check-circle"></i> All original bills and Payment receipts with receipt number.</li>
                <li style="font-size: 1.3rem;"><i class="fas fa-check-circle"></i> Investigation Reports.</li>
                <li style="font-size: 1.3rem;"><i class="fas fa-check-circle"></i> X-ray, ECG/Films if any</li>
                <li style="font-size: 1.3rem;"><i class="fas fa-check-circle"></i> Valid ID proof of Employee/ Patient</li>
                <li style="font-size: 1.3rem;"><i class="fas fa-check-circle"></i> Cancelled Cheque of Employee with pre-printed name on it.</li>
                <li style="font-size: 1.3rem;"><i class="fas fa-check-circle"></i> Original Implant Certificate(if applicable)</li>
            </ul>
            
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



.bsic-check-list {
    
}

.bsic-check-list li{
    font-size: 1.17rem;
    margin-bottom: 1rem;
}

.bsic-check-list li i{
    color: #ff6550;
    margin-right: 0.5rem;
}

.bsic-check-list-head {
    font-size: 2.4rem;
    font-weight: 700;
    color: #1562ac;
    margin: 2rem 0rem;
    text-align: center;
}

  </style>