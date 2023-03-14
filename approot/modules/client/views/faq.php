  <div class="content-body" style="background:#fff;">
    <!-- row --> <?php
            $rec = $this->qm->single("ri_clientpolicy_tbl","*",array('cid'=>$cid));
            $emp = $this->qm->single("ri_employee_tbl","*",array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid));
            ?> <div class="container-fluid">
                
        <div class="row page-titles custm-page-ttls">
                  <ol class="breadcrumb">
                     <!--<li class="breadcrumb-item active"><a href="<?= base_url('clients/focusedclaim');?>">Focused Claim Status</a> | </li>-->
                     <li class="breadcrumb-item"><a href="javascript:void(0)">FAQs</a></li>
                  </ol>
                 
               </div>        
                      
      <div class="row">
          
        <div class="col-xl-12">
            <h4>Frequently Asked Questions</h4>
           <div class="accordion accordion-danger-solid accordion-bordered" id="accordion-two">
                                    <?php
                                    $sn = 1; 
                                       $faq = $this->qm->all('ri_faq_tbl','*',array('cid'=>$cid,'pid'=>$pid));
                                       foreach ($faq as $faq) {
                                          
                                       

                                    ?>
                                    <div class="accordion-item">
                                       <div class="accordion-header rounded-lg collapsed" id="accord-2One<?= $faq->id;?>" data-bs-toggle="collapse" data-bs-target="#collapse2One<?= $faq->id;?>" aria-controls="collapse2One<?= $faq->id;?>" aria-expanded="false" role="button">
                                          <span class="accordion-header-text"><?= $faq->question;?></span>
                                          <span class="accordion-header-indicator"></span>
                                       </div>
                                       <div id="collapse2One<?= $faq->id;?>" class="accordion__body collapse" aria-labelledby="accord-2One<?= $faq->id;?>" data-bs-parent="#accordion-two" style="">
                                          <div class="accordion-body-text">
                                             <?= $faq->answer;?>
                                          </div>
                                       </div>
                                    </div>
                                    <?php $sn++; } ?>
                                    
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
  
  