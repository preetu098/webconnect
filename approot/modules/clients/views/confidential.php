  <div class="content-body" style="background:#fff;">
    <!-- row --> <?php
            $rec = $this->qm->single("ri_clientpolicy_tbl","*",array('cid'=>$cid));
            $emp = $this->qm->single("ri_employee_tbl","*",array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid));
            ?> <div class="container-fluid">
                
                
               
      
       <div class="row">
        <div class="col-xl-12 col-md-12 col-sm-12">
            <h2>Confidential</h2>
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