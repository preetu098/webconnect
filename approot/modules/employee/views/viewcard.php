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
										<div class="col-xl-12">
										<div class="card tryal-gradient2">	
											<div class="card-body tryal tryal-1 prfile-detail row">
												<div class="col-xl-7 col-sm-6">
												<h3><?=$type->policy_type_name?></h3>
												<!--<img src="<?=base_url()?>external/uploads/<?=$rec->iimage?>" 
												class="img-responsive for-insrnc-logo" style="height: 100px;width: 100px;"/>-->
												 
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
												   <?php if(!empty($image) && file_exists($image)){ ?>
                                                        <img src="<?= base_url($image) ?>" alt="" class="sd-shape" style="height: 150px;width: 150px;">
                                                    <?php }else{ ?>
        												<img src="<?=base_url()?>external/uploads/<?=$rec->iimage?>" 
												class="img-responsive for-insrnc-logo" style="height: 150px;width: 150px;"/>
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
								</div>
								
								<div class="row">
									<div class="col-md-12 col-sm-12">
										<div class="card membr-list-crd">
											<h2>Dependents Card</h2>
										<div class="row">
											<div class="col-md-6 col-sm-12">
											
												<ul class="membrs-list">
												    <li><a href="javascript:;">Self</a></li>
												    <?php
												    $depd = $this->qm->all("ri_dependent_tbl","*",array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid));
												    foreach($depd as $depd){
												    ?>
													<li><a href="javascript:;"><?=($depd->reltype=="Kid" || $depd->reltype=="Kid0" || $depd->reltype=="KID0" || $depd->reltype=="KID1" || $depd->reltype=="KID2" || $depd->reltype=="KID3" || $depd->reltype=="Kid1" || $depd->reltype=="Kid2" || $depd->reltype=="Kid3")?"Kid":$depd->reltype?></a></li>
													<?php } ?>
													<!--<li><a href="">Kid</a></li>
													<li><a href="">Parents</a></li>
													<li><a href="">Father &amp; Mother in law</a></li>-->
												</ul>
											</div>
											<div class="col-md-6 col-sm-12">
												<ul class="membrs-list-btn">
												    <!--<li><?php if(file_exists(base_url('external/uploads/policy_cards/'.$cid.'_'.$pid.'/'.str_replace('#', '%23', $emp->card).'.pdf'))){ ?><a href="<?=base_url('external/upload/policy_cards/'.$cid.'_'.$pid.'/'.str_replace('#', '%23', $emp->card).'.pdf')?>">Download Card</a><?php } ?></li>-->
												    <li><a href="<?=base_url('external/uploads/policy_cards/'.$cid.'_'.$pid.'/'.str_replace('#', '%23', $emp->card).'.pdf')?>" download>Download Card</a></li>
												    <?php
												    $depd = $this->qm->all("ri_dependent_tbl","*",array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid));
												    foreach($depd as $depd){
												    ?>
													<li>
													    <?php  if(!empty($depd->card)){ ?>
													        <a href="<?=base_url('external/uploads/policy_cards/'.$cid.'_'.$pid.'/'.str_replace('#', '%23', $emp->card).'.pdf')?>" download>Download Card</a>
													    <?php } ?>
													    </li>
												<?php }  ?>
												</ul>
											</div>
										</div>
										</div>
									</div>
								</div>
								
						
								
							</div>
							
							<style>
							    
							    
							    .membrs-list-btn li a {
    font-size: 18px;
    background: #0554a3;
    color: #fff;
    padding: 5px 9px;
    border-radius: 8px;
}
							</style>
							
							
							<div class="col-xl-6">
								<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
									<div class="carousel-indicators">
										<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
										<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
										<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
									</div>
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img class="d-block w-100 slider-img-width" style="width: 122%;" src="<?=base_url()?>external/images/big/img1.jpg" alt="First slide">
                                        </div>
                                        <div class="carousel-item">
                                            <img class="d-block w-100 slider-img-width" style="width: 122%;" src="<?=base_url()?>external/images/big/img2.jpg" alt="Second slide">
                                        </div>
                                        <div class="carousel-item">
                                            <img class="d-block w-100 slider-img-width" style="width: 122%;" src="<?=base_url()?>external/images/big/img3.jpg" alt="Third slide">
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
										<div class="card crd-pd" style="">
											<ul>
												<li><a href="<?= base_url('employee/dashboard/');?><?= $cid;?>/<?= $pid;?>/<?= $eid;?>#knowyourpolicy"><i class="fa fa-info-circle" style="margin-right: 8px;"></i> Know Your Policy</a></li>
												<li><a href="<?= base_url('employee/profile/');?><?= $cid;?>/<?= $pid;?>/<?= $eid;?>"><i class="fa fa-address-card"></i>  Your Policy Details</a></li>
												<li><a href="<?= base_url('employee/focusedclaim/');?><?= $cid;?>/<?= $pid;?>/<?= $eid;?>#"><i class="fa fa-address-card"></i>  Claims</a></li>
												<li><a href="<?= base_url('employee/dashboard/');?><?= $cid;?>/<?= $pid;?>/<?= $eid;?>#faqs"><i class="fa fa-question-circle" style="margin-right: 8px;"></i>  FAQs</a></li>
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
                                                <div class="bg-white rounded shadow-sm py-5 px-4"><img src="<?=base_url()?>external/images/tech-support.png" alt="" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                                                    <h5 class="mb-0"><?= ucwords($tech->tname);?></h5>
                                                    <span class="small text-muted"><?= $tech->temail;?></span><br>
                                                    <span class="small text-muted"><?= $tech->tphone;?></span>
                                                   
                                                </div>
                                            </div>
                                            
                                          
                                            <div class="col-xl-6 col-sm-6 mb-5">
                                                <h3>Functional Support</h3>
                                                  <div class="bg-white rounded shadow-sm py-5 px-4">
                                                      <img src="<?=base_url()?>external/images/tech-support.png" alt="" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                                                    <h5 class="mb-0"><?= ucwords($tech->fname);?></h5>
                                                    <span class="small text-muted_"><?= $tech->femail;?></span><br>
                                                    <span class="small text-muted_"><?= $tech->fphone;?></span>
                                                   
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