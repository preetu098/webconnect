  <div class="content-body" style="background:#fff;">
    <!-- row --> <?php
            $rec = $this->qm->single("ri_clientpolicy_tbl","*",array('cid'=>$cid));
            $emp = $this->qm->single("ri_employee_tbl","*",array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid));
            ?> <div class="container-fluid">
                
                
                      
      <div class="row">
          
        <div class="col-xl-4 col-md-4 col-sm-12">
            <div class="card">sdasddsa</div>
        </div>
            
        <div class="col-xl-4 col-md-4 col-sm-12">
            <div class="card">sdasddsa</div>
        </div>
        
        <div class="col-xl-4 col-md-4 col-sm-12">
            <div class="card">sdasddsa</div>
        </div>
        
      </div>
      
      
      
      
    </div>
  </div>
  
  <script>
  $(document).ready(function () {
    $('#example').DataTable();
});
  </script>
  
  