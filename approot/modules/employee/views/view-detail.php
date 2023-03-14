  <div class="content-body" style="background:#fff;">
            <!-- row -->
            <?php
            $rec = $this->qm->single("ri_clientpolicy_tbl","*",array('cid'=>$cid));
            $type = $this->qm->single("ad_policy_type","*",array('policy_type_id'=>$rec->policy_type));
            $emp = $this->qm->single("ri_employee_tbl","*",array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid));
            ?>
			<div class="container-fluid">
					<div class="row">
							<div class="col-xl-6">
								<div class="row">
									<div class="col-xl-12">
										<div class="card tryal-gradient2">	
											<div class="card-body tryal tryal-1 prfile-detail row">
												<div class="col-xl-7 col-sm-6">
												<h3><?=$type->policy_type_name?></h3>
												<!--<img src="<?=base_url()?>external/uploads/<?=$rec->iimage?>" 
												class="img-responsive for-insrnc-logo" style="height: 100px;width: 100px;"/>-->
												 
												    
        											<?php //} ?>
													<div class="row">
    												  <div class="col-xl-6 col-sm-6">
    													<h6>Name</h6>
    													<h4><?=$emp->emp_name?></h4>
    													<h6>Policy Number</h6>
    													<h4><?=$rec->policy_num?></h4>
    													<h6>Policy Sum Insured</h6>
													   <h2><?=$emp->sum_insured?></h2>
    												</div>
													
    												<div class="col-xl-6 col-sm-6">
    													   <div class="end-plicy-date">
    													   <h6>Valid From</h6>
    													   <h4><?=date_format(date_create($rec->sdate),"d-m-Y");?></h4>
            												<h6>Valid Till</h6>
            												<h4><?=date_format(date_create($rec->edate),"d-m-Y");?></h4>
            												
            											</div>
    												</div>
													
													</div>
													
												</div>
												<div class="col-xl-5 col-sm-6">
												   <!-- <?php if($emp->gender=='M' || $emp->gender=='Male'){ ?>
													    <img src="<?=base_url()?>external/images/user-card.png" alt="" class="sd-shape">
													<?php }else{ ?>
													    <img src="<?=base_url()?>external/images/user-card-f.png" alt="" class="sd-shape">
													<?php } ?> -->
                                                    
													  <?php if(!empty($rec->iimage) ){ ?>
                                                        <img src="<?=base_url()?>external/uploads/<?=$rec->iimage?>" 
												class="img-responsive for-insrnc-logo" style="height: 100px;width: 100px;"/>
                                                    <?php } ?>
												</div>
											</div>
											<div class="card-body tryal tryal2 prfile-detail row">
												<div class="col-md-6 col-sm-12">
													<h6>TPA Name</h6>
													<h4><?=$rec->tpa?></h4>
												</div>
												<div class="col-md-6 col-sm-12">
													
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="row" id="viewmembers">
									<div class="col-md-12 col-sm-12">
										<div class="card membr-list-crd">
											<h2>Member Details <!--<a href="javascript:void(0);" class="btn btn-outline-info btn-rounded fs-18" style="width:30%;float:right">Add Dependents</a>--></h2>
											
								<?php 
          $s =1;
            $rel = $this->qm->all('fm_relation_tbl','*',array('cid'=>$cid,'pid'=>$pid,'is_publish'=>1));
            $usedKids = [];
            $kidData = $this->qm->all('ri_dependent_tbl','*',array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid,'reltype'=>'Kid'));
            
            foreach ($rel as $rel) {
                
               
              
              $max = $rel->max_entry;
              for ($i=0; $i < $max; $i++,$s++) { 
                 $dep = $this->qm->single("ri_dependent_tbl","*",array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid,'reltype'=>$rel->reltype));
                 
                 if($rel->reltype == 'Spouse' && $dep->reltype !='Spouse')
                 {
                     echo '<a href="'.base_url('employee/dependents/'.$cid.'/'.$pid.'/'.$eid).'?type=Spouse" class="btn btn-outline-success btn-rounded fs-18" style="width:40%;float:left">ADD SPOUSE</a><br>';
                 }
                 
                 if($rel->reltype == 'Kid' && $dep->reltype !='Kid')
                 {
                    echo '<a href="'.base_url('employee/dependents/'.$cid.'/'.$pid.'/'.$eid).'?type=Kid" class="btn btn-outline-success btn-rounded fs-18" style="width:40%;float:left">ADD KID</a><br>';
                 }
                 
                 if($rel->reltype == 'Father' && $dep->reltype !='Father')
                 {
                     echo '<a href="'.base_url('employee/dependents/'.$cid.'/'.$pid.'/'.$eid).'?type=Father" class="btn btn-outline-success btn-rounded fs-18" style="width:40%;float:left">ADD FATHER</a><br>';
                 }
                 if($rel->reltype == 'Mother' && $dep->reltype !='Mother')
                 {
                     echo '<a href="'.base_url('employee/dependents/'.$cid.'/'.$pid.'/'.$eid).'?type=Mother" class="btn btn-outline-success btn-rounded fs-18" style="width:40%;float:left">ADD MOTHER</a><br>';
                 }
                 if($rel->reltype == 'Father In Law' && $dep->reltype !='Father In Law')
                 {
                     echo '<a href="'.base_url('employee/dependents/'.$cid.'/'.$pid.'/'.$eid).'?type=Father In Law" class="btn btn-outline-success btn-rounded fs-18" style="width:40%;float:left">ADD FATHER IN LAW</a><br>';
                 }
                 if($rel->reltype == 'Mother In Law' && $dep->reltype !='Mother In Law')
                 {
                     echo '<a href="'.base_url('employee/dependents/'.$cid.'/'.$pid.'/'.$eid).'?type=Mother In Law" class="btn btn-outline-success btn-rounded fs-18" style="width:40%;float:left">ADD MOTHER IN LAW</a><br>';
                 }
                 
                 
                 if($rel->reltype=='Self' || $dep->reltype == 'Spouse' || $dep->reltype == 'Kid' ||  $dep->reltype == 'Father' ||  $dep->reltype == 'Mother' ||  $dep->reltype == 'Father In Law' || $dep->reltype == 'Mother In Law')
               {
           ?>  
         <div class="accordion accordion-with-icon"  id="accordion-six<?= $s;?>">
            <div class="accordion-item">
               <div class="accordion-header rounded-lg" id="accord-6One<?= $s;?>" style="border: 0.0625rem solid #4a457d;" data-bs-toggle="collapse" data-bs-target="#collapse6One<?= $s;?>" aria-controls="collapse6One<?= $s;?>" aria-expanded="true" role="button">
                  
                  <span class="accordion-header-text"style="font-size: 16px;" ><?= $rel->reltype;?></span>
                  <span class="accordion-header-indicator"></span>
               </div>
               <div id="collapse6One<?= $s;?>" style="padding-right: 45px;" class="accordion__body collapse show"  data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-controls="collapseOne"   aria-expanded="true" role="button" aria-labelledby="accord-6One<?= $s;?>" data-bs-parent="#accordion-six<?= $s;?>" style="border: 1px solid #c3c3c3;">
                  <div class="accordion-body-text active" style="text-transform: uppercase; color: #000">
                     <?php
                     $data['cid'] = $cid;     
                       $data['pid'] = $pid;     
                       $data['eid'] = $eid;     
                       $data['rel'] = $rel->reltype;
                       if($rel->reltype == 'Self'){
                           $this->load->view('employee/self',$data);
                        }
                        else if($rel->reltype == 'Spouse' && $dep->did>0){
                           $this->load->view('employee/spouse',$data);
                        }
                        else if($rel->reltype == 'Kid' && ($dep->reltype=='Kid') && $dep->did>0){
                            $kidV = [];
                            foreach($kidData as $kdata) {
                                if(!in_array($kdata->did, $usedKids)){
                                    $usedKids[] = $kdata->did;
                                    $kidV[] = $kdata;
                                    break;
                                }
                            }
                            $data['spouse'] = $kidV;
                           $this->load->view('employee/kid',$data);
                        }
                        else if($rel->reltype == 'Father' && $dep->did>0){
                           $this->load->view('employee/father',$data);
                        }
                        else if($rel->reltype == 'Mother' && $dep->did>0){
                           $this->load->view('employee/mother',$data);
                        }
                        else if($rel->reltype == 'Father In Law' && $dep->did>0){
                           $this->load->view('employee/fatherinlaw',$data);
                        }
                        else if($rel->reltype == 'Mother In Law' && $dep->did>0){
                           $this->load->view('employee/motherinlaw',$data);
                        }
                        else{
                           echo "Some Error Occurred";
                        }
                     ?>
                  </div>
               </div>
            </div>
            
          
         </div>

         <?php } } } ?>
								
								
										</div>
									</div>
								</div>
								
						
								
							</div>
							
							<style>
							    .accordion-with-icon a{
							      padding-right: 45px !important;
							    }
							</style>
							
							<div class="col-xl-6">
								<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
									<div class="carousel-indicators">
										<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
										<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
										<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 3"></button>
									</div>
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img class="d-block w-100 slider-img-width" src="<?=base_url()?>external/images/Slide1.PNG" alt="First slide">
                                        </div>
                                        <div class="carousel-item">
                                            <img class="d-block w-100 slider-img-width" src="<?=base_url()?>external/images/Slide2.PNG" alt="Second slide">
                                        </div>
                                        <div class="carousel-item">
                                            <img class="d-block w-100 slider-img-width" src="<?=base_url()?>external/images/Slide3.PNG" alt="Third slide">
                                        </div>
                                        <div class="carousel-item">
                                            <img class="d-block w-100 slider-img-width" src="<?=base_url()?>external/images/Slide4.PNG" alt="Third slide">
                                        </div>
                                    </div>
									<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
										<span class="carousel-control-prev-icon" aria-hidden="true"></span>
										<span class="visually-hidden">Previous</span>
									  </button>
									  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
										<span class="carousel-control-next-icon" aria-hidden="true"></span>
										<span class="visually-hidden">Next</span>
									  </button>
                                </div>
								<div class="row" style="margin: 25px 0px;">
									<div class="col-md-12 col-sm-12">
										<div class="card crd-pd">
											<ul>
												<li><a href="<?= base_url('employee/dashboard/');?><?= $cid;?>/<?= $pid;?>/<?= $eid;?>#knowyourpolicy"><i class="fas fa-clipboard-check" style="margin-right: 8px;"></i> Know Your Policy</a></li>
												<li><a href="<?= base_url('employee/viewmedicalcard/');?><?= $cid;?>/<?= $pid;?>/<?= $eid;?>#kmedicalcard"><i class="fa fa-address-card"></i>  Health E-Card</a></li>
												<li><a href="<?= base_url('employee/focusedclaim/');?><?= $cid;?>/<?= $pid;?>/<?= $eid;?>#"><i class="fas fa-file-signature"></i>  Claim</a></li>
												<li><a href="<?= base_url('employee/faq/');?><?= $cid;?>/<?= $pid;?>/<?= $eid;?>"><i class="fa fa-question-circle" style="margin-right: 8px;"></i>  FAQs</a></li>
											</ul>
										</div>
									</div>
								</div>
								
									<div class="row" style="margin: 25px 0px;">
									<div class="col-md-12 col-sm-12">
										<div class="card crd-pd">
										    
										    <div class="row text-center">
										       
										        <?php 
                                                  $tech = $this->qm->single('ri_clients_tbl','*',array('cid'=>$cid));
                                                  //foreach($tech as $tech)
                                                 ?>
										    
											<div class="col-xl-6 col-sm-6 mb-5">
											    <h3>Tech Support</h3>
                                                <div class="bg-white rounded shadow-sm py-5 px-4 emplyee-span-email-txt"><img src="<?=base_url()?>external/images/tech-support.png" alt="" style="width: 55%;" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                                                    <h5 class="mb-0"><?= ucwords($tech->tname);?></h5>
                                                    <span class="small text-muted"><?= $tech->temail;?></span><br>
                                                    <span class="small text-muted"><?= $tech->tphone;?></span>
                                                   
                                                </div>
                                            </div>
                                            
                                          
                                            <div class="col-xl-6 col-sm-6 mb-5">
                                                <h3>Functional Support</h3>
                                                  <div class="bg-white rounded shadow-sm py-5 px-4 emplyee-span-email-txt"><img src="<?=base_url()?>external/images/tech-support.png" alt="" style="width: 55%;" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                                                    <h5 class="mb-0"><?= ucwords($tech->fname);?></h5>
                                                    <span class="small text-muted"><?= $tech->femail;?></span><br>
                                                    <span class="small text-muted"><?= $tech->fphone;?></span>
                                                   
                                                </div>
                                            </div>
                              </div>
                              
                              
										</div>
									</div>
								</div>
								
							</div>
						</div>
				
					
					
					
				</div>
			
				
            </div>
            