<section style="background-color: #fff; padding-top: 20px;">
    <div class="container">
        <div class="row">
            <div class="contact-heading">
            <h2>Contact And Escalation Matrix</h2>
           </div>
            <?php $chk = $this->qm->single("fm_escalationmetrix_tbl","*",array('cid'=>$cid,'pid'=>$pid,'is_publish'=>'1','type'=>'riskbirbal'));
            if(isset($chk) && count($chk)>0){ ?>
            <div class="col-md-12">              
		<div class="card con-card-pad">
			 <h4 class="tpa-headng">Riskbirbal Well Connect</h4>
										    <div class="row text-center">
										       
										        <?php 
                                                  $tech = $this->qm->single('ri_clients_tbl','*',array('cid'=>$cid));
                                                  //foreach($tech as $tech)
                                                 ?>
										    
											<div class="">
											    <h3></h3>
                                                                                            <div class="row">
                                                                                                <?php
                                                                                                 $rel = $this->qm->all("fm_escalationmetrix_entry_tbl","*",array('type'=>'riskbirbal','pid'=>$pid,'cid'=>$cid,'is_publish'=>'1'));
                                                                                                 //print_r($rel);
                                                                                                 foreach($rel as $row){
                                                                                                
                                                                                                ?>
                                                                                                <div class="col-md-4">
                                                                                                    <div class="rounded shadow-sm py-5 px-4" style="background-color: #eccdfb !important;">
                                                                                                        <div class="row">
                                                                                                            <div class="col-md-4">
                                                                                                        <img src="<?=base_url()?>external/images/tech-support.png" alt="" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                                                                                                        </div>
                                                                                                        <div class="col-md-8" style="padding: 0;">

                                                                                                            <div class="contact-card">
                                                                                                        <h4 class="mb-0"><?=$row->reltype?></h4>
                                                                                                        <h5 class="mb-0"><?=$row->name?></h5>
                                                                                                        <span class="small text-muted"><a href="mailto:<?=$row->email?>"><?=$row->email?></a></span><br>
                                                                                                        <span class="small text-muted"><a href="tel:91<?=$row->contact?>"><?=$row->contact?></a></span>
                                                                                                        </div>
                                                                                                        </div>
                                                                                                       </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                 <?php } ?>
                                                                                            </div>
                                           
                                            
                                          
<!--                                            <div class="contact-card">
                                                <h3></h3>
                                                  <div class="rounded shadow-sm py-5 px-4" style="background-color: #eccdfb !important;">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                    <img src="<?=base_url()?>external/images/tech-support.png" alt="" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                                                    </div>
                                                    <div class="col-md-8" style="padding: 0;">
                                                        <div class="contact-card">
                                                    <h4 class="mb-0">Second Level</h4>
                                                    <h5 class="mb-0">Sharad</h5>
                                                    <span class="small text-muted">sharad@insurancepandit.com</span><br>
                                                    <span class="small text-muted">9984291139</span>
                                                    </div>
                                                    </div>
                                                   </div>
                                                </div>
                                            </div>
                                            
                                           <div class="contact-card">
                                                <h3></h3>
                                                  <div class="rounded shadow-sm py-5 px-4" style="background-color: #eccdfb !important;">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                    <img src="<?=base_url()?>external/images/tech-support.png" alt="" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                                                    </div>
                                                    <div class="col-md-8" style="padding: 0;">
                                                        <div class="contact-card">
                                                    <h4 class="mb-0">Final Level</h4>
                                                    <h5 class="mb-0">Ravikant</h5>
                                                    <span class="small text-muted">ravikant@insurancepandit.com</span><br>
                                                    <span class="small text-muted">9312303448</span>
                                                    </div>
                                                    </div>
                                                   </div>
                                                </div>
                                            </div>-->
                              </div>
                              
                              
										</div>
									</div>
							
            </div>
            <?php } ?>
             <?php $chk = $this->qm->single("fm_escalationmetrix_tbl","*",array('cid'=>$cid,'pid'=>$pid,'is_publish'=>'1','type'=>'tpa'));
            if(isset($chk) && count($chk)>0){ ?>
            <div class="col-md-12">
                
										<div class="card con-card-pad">
										    <h4 class="tpa-headng"><?=$chk->name?></h4>
										    <div class="row text-center">
										       
										        <?php 
                                                  $tech = $this->qm->single('ri_clients_tbl','*',array('cid'=>$cid));
                                                  //foreach($tech as $tech)
                                                 ?>
										    
											<div class="">
											    <h3></h3>
                                               <div class="row">
                                                                                                <?php
                                                                                                 $rel = $this->qm->all("fm_escalationmetrix_entry_tbl","*",array('type'=>'tpa','pid'=>$pid,'cid'=>$cid,'is_publish'=>'1'));
                                                                                                 //print_r($rel);
                                                                                                 foreach($rel as $row){
                                                                                                
                                                                                                ?>
                                                                                                <div class="col-md-4">
                                                                                                    <div class="rounded shadow-sm py-5 px-4" style="background-color: #eccdfb !important;">
                                                                                                        <div class="row">
                                                                                                            <div class="col-md-4">
                                                                                                        <img src="<?=base_url()?>external/images/tech-support.png" alt="" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                                                                                                        </div>
                                                                                                        <div class="col-md-8" style="padding: 0;">

                                                                                                            <div class="contact-card">
                                                                                                        <h4 class="mb-0"><?=$row->reltype?></h4>
                                                                                                        <h5 class="mb-0"><?=$row->name?></h5>
                                                                                                        <span class="small text-muted"><a href="mailto:<?=$row->email?>"><?=$row->email?></a></span><br>
                                                                                                        <span class="small text-muted"><a href="tel:91<?=$row->contact?>"><?=$row->contact?></a></span>
                                                                                                        </div>
                                                                                                        </div>
                                                                                                       </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                 <?php } ?>
                                                                                            </div>
                                           
                                            
                                          
                                           
                              </div>
                              
                              
										</div>
									</div>
							
            </div>
            <?php } ?>
            <?php $chk = $this->qm->single("fm_escalationmetrix_tbl","*",array('cid'=>$cid,'pid'=>$pid,'is_publish'=>'1','type'=>'insurer'));
            if(isset($chk) && count($chk)>0){ ?>
           <div class="col-md-12">
                
										<div class="card con-card-pad">
										    <h4 class="tpa-headng"><?=$chk->name?></h4>
										    <div class="row text-center">
										       
										        <?php 
                                                  $tech = $this->qm->single('ri_clients_tbl','*',array('cid'=>$cid));
                                                  //foreach($tech as $tech)
                                                 ?>
										    
											<div class="">
											    <h3></h3>
                                                <div class="row">
                                                                                                <?php
                                                                                                 $rel = $this->qm->all("fm_escalationmetrix_entry_tbl","*",array('type'=>'insurer','pid'=>$pid,'cid'=>$cid,'is_publish'=>'1'));
                                                                                                 //print_r($rel);
                                                                                                 foreach($rel as $row){
                                                                                                
                                                                                                ?>
                                                                                                <div class="col-md-4">
                                                                                                    <div class="rounded shadow-sm py-5 px-4" style="background-color: #eccdfb !important;">
                                                                                                        <div class="row">
                                                                                                            <div class="col-md-4">
                                                                                                        <img src="<?=base_url()?>external/images/tech-support.png" alt="" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                                                                                                        </div>
                                                                                                        <div class="col-md-8" style="padding: 0;">

                                                                                                            <div class="contact-card">
                                                                                                        <h4 class="mb-0"><?=$row->reltype?></h4>
                                                                                                        <h5 class="mb-0"><?=$row->name?></h5>
                                                                                                       <span class="small text-muted"><a href="mailto:<?=$row->email?>"><?=$row->email?></a></span><br>
                                                                                                        <span class="small text-muted"><a href="tel:91<?=$row->contact?>"><?=$row->contact?></a></span>
                                                                                                        </div>
                                                                                                        </div>
                                                                                                       </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                 <?php } ?>
                                                                                            </div>
                                            
                                          
                                           
                              </div>
                              
                              
										</div>
									</div>
							
            </div>
            
            <?php } ?>
            
            
        </div>
    </div>
</section>  
  
  
  <style>
      
      .contact-card{
            text-align: initial;
      }
      .con-card-pad{
            padding: 1rem;
      }
      
  </style>
 