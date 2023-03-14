  <div class="content-body" style="background:#fff;">
    <!-- row --> <?php
            $rec = $this->qm->single("ri_clientpolicy_tbl","*",array('cid'=>$cid));
            $emp = $this->qm->single("ri_employee_tbl","*",array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid));
            ?> <div class="container-fluid">
                
        <div class="row page-titles custm-page-ttls">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item active"><a href="<?= base_url('clients/focusedclaim');?>">Focused Claim Status</a> | </li>
                     <li class="breadcrumb-item"><a href="javascript:void(0)">FAQs</a></li>
                  </ol>
                 
               </div>        
                      
      <div class="row">
          
        <div class="col-xl-12">
            <h4>Frequently Asked Questions</h4>
            <div class="accordion accordion-rounded-stylish accordion-bordered" id="accordion-eleven">
								  <div class="accordion-item">
									<div class="accordion-header accordion-bdr rounded-lg" id="accord-11One" data-bs-toggle="collapse" data-bs-target="#collapse11One" aria-controls="collapse11One"   aria-expanded="true"  role="button">
										<span class="accordion-header-icon"></span>
									  <span class="accordion-header-text">Accordion Header One</span>
									  <span class="accordion-header-indicator"></span>
									</div>
									<div id="collapse11One" class="collapse accordion__body show body-bdr" aria-labelledby="accord-11One" data-bs-parent="#accordion-eleven">
									  <div class="accordion-body-text">
										 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.
									  </div>
									</div>
								  </div>
								  <div class="accordion-item">
									<div class="accordion-header accordion-bdr collapsed rounded-lg" id="accord-11Two" data-bs-toggle="collapse" data-bs-target="#collapse11Two" aria-controls="collapse11Two"   aria-expanded="true"  role="button">
										<span class="accordion-header-icon"></span>
									  <span class="accordion-header-text">Accordion Header Two</span>
									  <span class="accordion-header-indicator"></span>
									</div>
									<div id="collapse11Two" class="collapse accordion__body body-bdr" aria-labelledby="accord-11Two" data-bs-parent="#accordion-eleven">
									  <div class="accordion-body-text">
										 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.
									  </div>
									</div>
								  </div>
								  <div class="accordion-item">
									<div class="accordion-header accordion-bdr collapsed rounded-lg" id="accord-11Three" data-bs-toggle="collapse" data-bs-target="#collapse11Three" aria-controls="collapse11Three"   aria-expanded="true"  role="button">
										<span class="accordion-header-icon"></span>
									  <span class="accordion-header-text">Accordion Header Three</span>
									   <span class="accordion-header-indicator"></span>
									</div>
									<div id="collapse11Three" class="collapse accordion__body body-bdr" aria-labelledby="accord-11Three" data-bs-parent="#accordion-eleven">
									  <div class="accordion-body-text">
										 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.
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
  
  