
         <div class="accordion accordion-primary" id="accordion-one">
             <div class="row">                          
 <?php
                                    $sn = 1; 
                                       $faq = $this->qm->all('ri_faq_tbl','*',array('cid'=>$cid,'pid'=>$pid));
                                       foreach ($faq as $faq) {
                                          
                                       

                                    ?>
           <div class="col-lg-4">                                  
            <div class="accordion-item">
               <div class="accordion-header  rounded-lg" id="headingOne<?= $faq->id;?>" data-bs-toggle="collapse" data-bs-target="#collapseOne<?= $faq->id;?>" aria-controls="collapseOne" aria-expanded="true" role="button">
                  <span class="accordion-header-icon"></span>
                  <span class="accordion-header-text"><?= $faq->question;?></span>
                  <span class="accordion-header-indicator"></span>
               </div>
               <div id="collapseOne<?= $faq->id;?>" class="collapse <?= ($sn==1)?'show':'';?>" aria-labelledby="headingOne<?= $faq->id;?>" data-bs-parent="#accordion-one">
                  <div class="accordion-body-text">
                     <?= $faq->answer;?><br><br>
                         <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#faq<?= $faq->id;?>"> <i class="fas fa-pencil-alt"></i> Edit</button>

                         <div class="modal fade" id="faq<?= $faq->id;?>" data-bs-backdrop="faq" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                       <div class="modal-dialog">
                         <div class="modal-content">
                         <form class="form-group" method="POST" action="<?= base_url('clients/editfaq');?>/<?= $faq->id;?>/<?= $cid;?>/<?= $pid;?>">
                           <div class="modal-body">

                            <?php 
                        $rt = $this->qm->all("ri_faq_tbl","*",array('id'=>$faq->id));
                        foreach ($rt as $rt) {
                          
                    ?>
                                <div class="row">
                                   <div class="col-lg-12">
                                       <label class="form-label">Question</label>
                                       <input type="text" name="question" value="<?= $rt->question;?>" class="form-control">
                                   </div>
                                  <div class="col-lg-12">
                                       <label class="form-label">Answer</label>
                                       <textarea class="form-control" name="answer"><?= $rt->answer;?></textarea>
                                   </div>
                                   
                                </div>
                             <?php } ?>
                            
                           </div>
                           <div class="modal-footer">
                             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                             <button type="submit" class="btn btn-primary">Update</button>
                           </div>
                           </form>
                         </div>
                       </div>
                     </div>
                  </div>

               </div>
            </div>
            </div>
           <?php $sn++; } ?> 
          
    
         </div>
   
</div>