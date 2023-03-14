         <div class="content-body" style="background: rgb(255, 255, 255); min-height: 884px;">
            <!-- row -->
			<div class="container-fluid">
					<div class="row" style="margin-top: -20px;">
							<div class="col-xl-6">
								<div class="row">
									<div class="col-xl-12">
										<div class="card tryal-gradient">
											<div class="card-body tryal row">
												<div class="col-xl-7 col-sm-6">
													<h2>Hello, <?=ucwords($_SESSION['name'])?></h2>
													<h2>Welcome !</h2>
													<span style="margin:0rem;">Well connect with your policy. <br /> <br /></span>
													<a href="<?=base_url('employee/profile/'.$cid.'/'.$pid.'/'.$eid)?>" class="btn btn-rounded  fs-18 crd-detl font-w500" style="margin-top: 10px; border: solid 2px #fff;">Get started</a>
												</div>
												<div class="col-xl-5 col-sm-6">
												    
												     <?php if(!empty($image) && file_exists($image)){ ?>
                                                        <img src="<?= base_url($image) ?>" alt="" class="rounded-circle" style="width:150px;height:150px">
                                                    <?php }else{ ?>
        												<img src="<?=base_url()?>external/images/chart.png" alt="" class="sd-shape">
        											<?php } ?>
												  </div>
												
												
											
												
												
											</div>
											<div class="row">
											    <div class="col-xl-12 col-sm-12">
            									    <div class="dp-upld-bx">
            									        <h5>Upload Your Profile Picture</h5>
            									        <form id="my_form" action="<?= base_url('employee/empUploadImage');?>" enctype="multipart/form-data" method="POST">
            									             <input type="hidden" name="cid" value="<?= $cid;?>">
                                                <input type="hidden" name="pid" value="<?= $pid;?>">
                                                <input type="hidden" name="eid" value="<?= $eid;?>">
                                                            <div class="input-group mb-3">
                                                                <div class="form-file" style="height: 36px;">
                                                                    <input type="file" name="image" class="form-file-input form-control">
                                                                </div>
                                                                 <a href="javascript:void(0)" onclick="document.getElementById('my_form').submit();" type="submit" id="profileimgupdate"  class="btn  fs-18 font-w500" style="background: #7353b3;
    border-radius: 0px 11px 11px 0px !important; font-size: 12px !important;
    color: #fff; line-height: 1; height: 36px;">Upload</a>
                                                            </div>
                                                        </form>
                                                        <!--<form id="my_form" action="<?= base_url('employee/empUploadImage');?>" enctype="multipart/form-data" method="POST">
                                             <?php echo validation_errors(); ?>
                                                <input type="file" name="image" id="profileimg" style="display:none">
                                                <input type="hidden" name="cid" value="<?= $cid;?>">
                                                <input type="hidden" name="pid" value="<?= $pid;?>">
                                                <input type="hidden" name="eid" value="<?= $eid;?>">

                                                <a href="javascript:void(0)" id="profileimgbtn" class="btn btn-rounded  fs-18 font-w500">choose file</a>

                                                <a href="javascript:void(0)" onclick="document.getElementById('my_form').submit();" type="submit" id="profileimgupdate" class="btn btn-rounded  fs-18 font-w500">Upload</a>
                                             </form>-->
            									    </div>
            									</div>
											</div>
										</div>
									</div>
									
								</div>
								
							</div>
							<div class="col-xl-6">
								<div class="row">
									<div class="col-xl-12">
										<div class="row">
											<div class="col-xl-12 col-sm-12">
											    <div class="right">
											       <!-- <h2>WELL CONNECT</h2>
											    <p>We are glad to server you</p>-->
											    <?php //print_r($_SESSION);?>
											    
											    </div>
												<img src="<?=base_url()?>external/images/emply/b.png" class="img-responsive emply-dash-img-hide" style="width: 85%;">
											</div>
											
										</div>
										
									</div>
									
								</div>
							</div>
						</div>
				
					
					<!--<div class="row">
						<div class="col-md-12">
							<div class="see-btn">
								<a href="javascript:void(0);" class="btn btn-outline-info btn-rounded fs-18">Download option</a>
							</div>
						</div>
					</div>-->
					<div class="row" id="kmedicalcard" style="margin-top: -20px;">
					<div class="col-md-5 col-sm-12">
                       <img src="<?=base_url()?>external/images/emply/a.png" class="img-responsive emply-dash-img-hide" style="width: 85%;"> 
                    </div>
					
					<div class="col-md-7 col-sm-12">
						<div class="bxhead-tp">
							<h2>Health E-Card</h2>
						<p>Download your and your family's Health E-Cards.</p>
						
						<a href="<?=base_url('employee/viewmedicalcard/'.$cid.'/'.$pid.'/'.$eid)?>">E-Card </a>
						
						</div>
					</div>
					
					</div>
					
					<div class="row" style="margin-top: -20px;">
					<div class="col-md-7 col-sm-12">
						<div class="bxhead-tp fmly-tp-bx">
							<h2>Your Family</h2>
							
						<p>See your family details in the policy records.</p>
						<ul class="family-details"style="margin-bottom: 20px; font-size: 15px;">
							   <li><i class="fas fa-user-check"></i>Make Corrections if required.</li>
							   <li><i class="fas fa-user-check"></i>Add a New Member to the policy.</li>
							   <li><i class="fas fa-user-check"></i>Delete a Member from the policy.</li>
						</ul>
						<a href="<?=base_url('employee/profile/'.$cid.'/'.$pid.'/'.$eid.'#viewmembers');?>">Covered Members </a>
						
						</div>
					</div>
					
					<div class="col-md-5 col-sm-12">
                       <img src="<?=base_url()?>external/images/emply/f.png" class="img-responsive emply-dash-img-hide" style="width: 85%;"> 
                    </div>
					
					
					</div>
					
					<div class="row" style="margin-top: -20px;">
					    <div class="col-xl-12 col-sm-12">
					        <h2 class="ppt-slider-head">Know About Your Policy</h2>
					    </div>
						<div class="col-md-3 col-sm-12" id="knowyourpolicy">
						    	
							<h5>To know more see the slides</h5>
							<!--<strong>Few Important Points Worth Noting </strong>
							<ul class="knw-abt-plcy-list">
							    <li><i class="fas fa-clipboard-check"></i>It is good to take pre authorization approval before admitting to hospital.</li>
							    <li><i class="fas fa-clipboard-check"></i>For any reimbursement, please inform Riskbirbal/TPA/ claims people within 24 hours of hospitalization to avoid any rejection in claim settlement.</li>
							    <li><i class="fas fa-clipboard-check"></i>Please submit the documents within 15 days from stipulated timelines of Pre and Post  hospitalisation claim.  Within the stipulated period of time</li>
							    <li><i class="fas fa-clipboard-check"></i>Please check cashless hospital network before admission.</li>
							    <li><i class="fas fa-clipboard-check"></i>Please avoid blacklist/ non-preferred/ negative list hospital or it may lead to claim rejection.</li>
							</ul>	-->			
						</div>
						<div class="col-md-12 col-sm-12">
							<div class="ppt-slide-bx">
							    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" style="padding: 42px;">
									<div class="carousel-indicators">
									    <?php
									    $cnt=0;
    									    $img = $this->qm->all('upload_ppt_ri','*',array('cid'=>$cid,'pid'=>$pid));
                                            foreach ($img as $img) {
                                                $cnt++;
                                        ?>
										<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?=$cnt?>" <?=($cnt=='2')?'class="active" aria-current="true"':"";?> class="" aria-label="Slide <?=$cnt?>"></button>
										<?php } ?>
										<!--<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2" class="active" aria-current="true"></button>
										<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3" class=""></button>-->
									</div>
                                     <div class="carousel-inner">
                                             <?php 
               $ss =1;
                $img = $this->qm->all('upload_ppt_ri','*',array('cid'=>$cid,'pid'=>$pid));
               foreach ($img as $img) {
                  
            ?>    
               <div class="carousel-item <?= ($ss==1)?'active':'';?>">
                  <img class="d-block" src="<?= base_url('external/uploads/');?><?= $img->ppt;?>" style="width: 100%;
    background-size: contain;">
               </div>
           <?php 
           $ss++;
        } ?>
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
							</div>
						</div>
								
						
						<div class="col-md-12 col-sm-12">
						    <h4 style="font-size: 1.4rem;
    color: #4a457d;">Few Important Points Worth Noting</h4>
							<ul class="knw-abt-plcy-list">
							    <li><i class="fas fa-clipboard-check"></i>Please check cashless hospital network before admission.</li>
							    <li><i class="fas fa-clipboard-check"></i>Please avoid blacklist/ non-preferred/ negative list hospital or it may lead to claim rejection.</li>
							    <li><i class="fas fa-clipboard-check"></i>It is good to take pre authorization approval before admitting to hospital.</li>
							    <li><i class="fas fa-clipboard-check"></i>For any reimbursement, please inform Riskbirbal/TPA/ claims people within 24 hours of hospitalization to avoid any rejection in claim settlement.</li>
							    <li><i class="fas fa-clipboard-check"></i>Please submit the documents within 15 days from stipulated timelines of Pre and Post  hospitalisation claim.</li>
							    
							    
							</ul>
						</div>
						
					</div>
					
					
					
					
					<div class="row" style="margin-top:35px;" id="faqs">
						<div class="col-md-5 col-sm-12">
						<h2 class="ppt-slider-head">Disclaimer</h2>
						   <p class="faq-dislamer"> This is a general understanding about your policy benefit, terms and conditions. <br />
                                Please refer the policy document for benefits and claim procedure for detailed information about your policy or you may contact Risk Birbal well connect executive.
                                <br />
                                <a href="<?=base_url('employee/contactus/'.$cid.'/'.$pid.'/'.$eid)?>" class="cntct_us">Contact Us</a>
                                </p>
						
						
						
						</div>
						
						<div class="col-md-7 col-sm-12">
							<h2 class="ppt-slider-head">FAQs</h2>
							<!--<div class="accordion accordion-rounded-stylish accordion-bordered" id="accordion-eleven">
								  <div class="accordion-item">
									<div class="accordion-header  rounded-lg" id="accord-11One" data-bs-toggle="collapse" data-bs-target="#collapse11One" aria-controls="collapse11One" aria-expanded="true" role="button">
										<span class="accordion-header-icon"></span>
									  <span class="accordion-header-text">Accordion Header One</span>
									  <span class="accordion-header-indicator"></span>
									</div>
									<div id="collapse11One" class="collapse accordion__body show" aria-labelledby="accord-11One" data-bs-parent="#accordion-eleven">
									  <div class="accordion-body-text">
										 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.
									  </div>
									</div>
								  </div>
								  <div class="accordion-item">
									<div class="accordion-header collapsed rounded-lg" id="accord-11Two" data-bs-toggle="collapse" data-bs-target="#collapse11Two" aria-controls="collapse11Two" aria-expanded="true" role="button">
										<span class="accordion-header-icon"></span>
									  <span class="accordion-header-text">Accordion Header Two</span>
									  <span class="accordion-header-indicator"></span>
									</div>
									<div id="collapse11Two" class="collapse accordion__body" aria-labelledby="accord-11Two" data-bs-parent="#accordion-eleven">
									  <div class="accordion-body-text">
										 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.
									  </div>
									</div>
								  </div>
								  <div class="accordion-item">
									<div class="accordion-header collapsed rounded-lg" id="accord-11Three" data-bs-toggle="collapse" data-bs-target="#collapse11Three" aria-controls="collapse11Three" aria-expanded="true" role="button">
										<span class="accordion-header-icon"></span>
									  <span class="accordion-header-text">Accordion Header Three</span>
									   <span class="accordion-header-indicator"></span>
									</div>
									<div id="collapse11Three" class="collapse accordion__body" aria-labelledby="accord-11Three" data-bs-parent="#accordion-eleven">
									  <div class="accordion-body-text">
										 Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod.
									  </div>
									</div>
								  </div>
								</div>-->
								
								
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
							    
							    <a href="<?=base_url('employee/faq/'.$cid.'/'.$pid.'/'.$eid)?>" class="cntct_us">View More...</a>
							
							</div>
					
					</div>
					
					<!--<div class="row">
					<div class="col-5">
                       <img src="<?=base_url()?>external/images/emply/f.png" class="img-responsive" /> 
                    </div>
					
					<div class="col-7">
						<div class="bxhead-tp">
							<h2>Your Parents Details (Please Provide Heading)</h2>
						<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>
						
						<a href="" />Read More... </a>
						
						</div>
					</div>
					
					</div>-->
					
					<!---<div class="row">
					<div class="col-7">
                        <div class="card">
						<div class="card-header">
                                <h4 class="card-title">Your Medical Card</h4>
                            </div>
                            <div class="card-body">
                                <div class="plcy-card plcy-card-text">
									
									<div class="card-text-btn">
									<div class="row">
										<div class="col-md-4">
											<h4>Employee Name</h4>
										</div>
										<div class="col-md-4">
											<h4>Insurer</h4>
											<div class="brand-logo medical-card-icon">
												<img src="icons/icon/icici-logo.png">
											</div>
											<h6 style="padding-left: 5px;">ICICI</h6>
										</div>
										<div class="col-md-4">
											<h4>Download card</h4>
										</div>
									</div>
									</div>
										
									<div class="card-text-btn">
									<div class="row">
										<div class="col-md-4">
											<h4>Card No</h4>
										</div>
										<div class="col-md-4">
											<h4>TPA Name</hh4>
											<div class="brand-logo medical-card-icon">
												<img src="icons/icon/icici-logo.png">
											</div>
										</div>
										<div class="col-md-4">
											<h4>FAQs</h4>
										</div>
									</div>
									</div>
									
									<div class="card-text" style="margin-top: 20px;">
									<div class="row">
										<div class="col-md-4">
											<h4>Valid from</h4>
										</div>
										<div class="col-md-4">
											<h4>Valid till</h4>
										</div>
										<div class="col-md-4">
											<h4>Get support</h4>
										</div>
									</div>
									</div>
									
									
								</div>
                            </div>
                        </div>
                    </div>
					
					
					<div class="col-5">
                        <div class="card">
						<div class="card-header">
                                <h4 class="card-title">Member details</h4>
                            </div>
                            <div class="card-body">
                                <div class="plcy-card plcy-card-text">
									
									<div class="row">
										<div class="col-md-8">
											<h4>Spouse</h4>
										</div>
										<div class="col-md-4">
											<h6><a href="#">Valid till</a></h6>
										</div>
										<div class="col-md-8">
											<h4>Kid</h4>
										</div>
										<div class="col-md-4">
											<h6><a href="#">Valid till</a></h6>
										</div><div class="col-md-8">
											<h4>Parents</h4>
										</div>
										<div class="col-md-4">
											<h6><a href="#">Valid till</a></h6>
										</div>
									</div>
									
									
								</div>
                            </div>
                        </div>
                    </div>
					</div>--->
					
					
					
					 <!--<div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Self</h4>
								
								<a href="javascript:void(0);" class="btn btn-outline-danger btn-rounded fs-18">Your Family</a>
                            </div>
							
							<div class="row">
                            <div class="col-xl-12 col-lg-6">
                            <div class="card-body">
								<div class="row">
									<div class="col-xl-6 col-lg-6">
                                <div class="basic-form">
                                    <form>
                                        <div class="mb-3">
                                            <input type="text" class="form-control input-default " placeholder="Employee ID">
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control input-default" placeholder="Employee Name">
                                        </div>
										
										<div class="mb-3 row">
                                                    <label class="col-lg-2 col-form-label">DOB</label>
                                                    <div class="col-lg-10">
															<form class="months-fil">
																<input type="date" class="form-control" id="dob" name="dob">
															</form>
                                                    </div>
                                        </div>
										
										<div class="mb-3">
                                            <select class="default-select  form-control wide" >
                                                <option>Gender</option>
                                                <option>Male</option>
                                                <option>Female</option>
                                            </select>
                                        </div>
										
                                    </form>
								
                                </div>
                            </div>
							<div class="col-xl-6 col-lg-6">
                                <div class="basic-form">
                                    <form>
                                        <div class="mb-3">
                                            <input type="text" class="form-control input-default " placeholder="Email ID">
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control input-default" placeholder="Sum Insured">
                                        </div>
                                    </form>
									<form>
                                        <div class="mb-3">
                                            <input type="text" class="form-control input-default " placeholder="Health Card">
                                        </div>
                                        <div class="mb-3 row">
                                                <label class="col-lg-3 col-form-label">Date of Joining</label>
                                                <div class="col-lg-9">
													<form class="months-fil">
														<input type="date" class="form-control" id="joining" name="joining">
													</form>
                                                </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
							
							<div class="col-xl-12 col-lg-6">
                                <div class="basic-form">
                                    <form>
                                        <div class="mb-3">
										  <input type="text" class="form-control input-default" placeholder=" Age(automatically calculate from DOB)">
                                        </div>
                                    </form>
                                </div>
                            </div>
							
							
							
							
							
                            </div>
                            </div>
                      
					</div>
					</div>
					
					
                            </div>
                        </div>
                    </div>--->
					
					
					<!--<div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Member details</h4>
                            </div>
							
							<div class="row">
                            <div class="col-xl-12 col-lg-6">
                            <div class="card-body">
								<div class="row">
									<div class="col-xl-6 col-lg-6">
                                <div class="basic-form">
                                    <form>
                                        <div class="mb-3">
                                            <input type="text" class="form-control input-default " placeholder="Employee ID">
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control input-default" placeholder="Employee Name">
                                        </div>
										<div class="mb-3">
                                             <input type="text" class="form-control input-default" placeholder="Spouse Name">
                                        </div>
										
										<div class="mb-3">
                                            <select class="default-select  form-control" >
                                                <option>Gender</option>
                                                <option>Male</option>
                                                <option>Female</option>
                                            </select>
                                        </div>
                                    </form>
								
                                </div>
                            </div>
							<div class="col-xl-6 col-lg-6">
                                <div class="basic-form">
                                    <form>
                                        <div class="mb-3">
                                            <input type="text" class="form-control input-default " placeholder="Email ID">
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control input-default" placeholder="Sum Insured">
                                        </div>
										
										<div class="mb-3">
                                            <input type="text" class="form-control input-default " placeholder="Health Card">
                                        </div>
										<div class="mb-3 row">
                                                <label class="col-lg-3 col-form-label">Date of Joining</label>
                                                <div class="col-lg-9">
													<form class="months-fil">
														<input type="date" class="form-control" id="joining" name="joining">
													</form>
                                                </div>
                                        </div>
										
                                    </form>
                                </div>
                            </div>
							<div class="col-xl-6 col-lg-6">
                                <div class="basic-form">
                                    <form>
                                        <div class="mb-3">
                                            <input type="text" class="form-control input-default" placeholder="Age(automatically calculate from DOB)">
                                        </div>
										<div class="mb-3">
                                            <input type="text" class="form-control input-default" placeholder="Relation">
                                        </div>
                                    </form>
                                </div>
                            </div>
							<div class="col-xl-6 col-lg-6">
                                <div class="basic-form">
                                    <form>
										<div class="mb-3 row">
                                                <label class="col-lg-3 col-form-label">Wedding Date</label>
                                                <div class="col-lg-9">
													<form class="months-fil">
														<input type="date" class="form-control" id="Wedding" name="Wedding">
													</form>
                                                </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control input-default" placeholder="Wife/husband">
                                        </div>
                                    </form>
                                </div>
                            </div>
							
							
							
							
							
							
                            </div>
                            </div>
                      
					</div>
					</div>
					
					
                            </div>
                        </div>
                    </div>--->
					
					
					<!--<div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Kid1/2/3</h4>
                            </div>
							
							<div class="row">
                            <div class="col-xl-12 col-lg-6">
                            <div class="card-body">
								<div class="row">
									<div class="col-xl-6 col-lg-6">
                                <div class="basic-form">
                                    <form>
                                        <div class="mb-3">
                                            <input type="text" class="form-control input-default " placeholder="Employee ID">
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control input-default" placeholder="Employee Name">
                                        </div>
										<div class="mb-3">
                                             <input type="text" class="form-control input-default" placeholder="Spouse Name">
                                        </div>
										
										<div class="mb-3">
                                            <select class="default-select  form-control" >
                                                <option>Gender</option>
                                                <option>Male</option>
                                                <option>Female</option>
                                            </select>
                                        </div>
                                    </form>
								
                                </div>
                            </div>
							<div class="col-xl-6 col-lg-6">
                                <div class="basic-form">
                                    <form>
                                        <div class="mb-3">
                                            <input type="text" class="form-control input-default " placeholder="Email ID">
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control input-default" placeholder="Sum Insured">
                                        </div>
										
										<div class="mb-3">
                                            <input type="text" class="form-control input-default " placeholder="Health Card">
                                        </div>
                                        <div class="mb-3 row">
                                                <label class="col-lg-3 col-form-label">Wedding Date</label>
                                                <div class="col-lg-9">
													<form class="months-fil">
														<input type="date" class="form-control" id="Wedding" name="Wedding">
													</form>
                                                </div>
                                        </div>
										
                                    </form>
                                </div>
                            </div>
							<div class="col-xl-6 col-lg-6">
                                <div class="basic-form">
                                    <form>
                                        <div class="mb-3">
                                            <input type="text" class="form-control input-default" placeholder="Age(automatically calculate from DOB)">
                                        </div>
										<div class="mb-3">
                                            <input type="text" class="form-control input-default" placeholder="Relation">
                                        </div>
                                    </form>
                                </div>
                            </div>
							<div class="col-xl-6 col-lg-6">
                                <div class="basic-form">
                                    <form>
                                        <div class="mb-3 row">
                                                <label class="col-lg-3 col-form-label">Date of Joining</label>
                                                <div class="col-lg-9">
													<form class="months-fil">
														<input type="date" class="form-control" id="joining" name="joining">
													</form>
                                                </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control input-default" placeholder="Son/Daughter">
                                        </div>
                                    </form>
                                </div>
                            </div>
							
							
							
							
							
							
                            </div>
                            </div>
                      
					</div>
					</div>
					
					
                            </div>
                        </div>
                    </div>-->
					
					<!---<div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Parents</h4>
                            </div>
							
							<div class="row">
                            <div class="col-xl-12 col-lg-6">
                            <div class="card-body">
								<div class="row">
									<div class="col-xl-6 col-lg-6">
                                <div class="basic-form">
                                    <form>
                                        <div class="mb-3">
                                            <input type="text" class="form-control input-default " placeholder="Employee ID">
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control input-default" placeholder="Employee Name">
                                        </div>
										<div class="mb-3">
                                             <input type="text" class="form-control input-default" placeholder="Spouse Name">
                                        </div>
										
										<div class="mb-3">
                                            <select class="default-select  form-control" >
                                                <option>Gender</option>
                                                <option>Male</option>
                                                <option>Female</option>
                                            </select>
                                        </div>
                                    </form>
								
                                </div>
                            </div>
							<div class="col-xl-6 col-lg-6">
                                <div class="basic-form">
                                    <form>
                                        <div class="mb-3">
                                            <input type="text" class="form-control input-default " placeholder="Email ID">
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control input-default" placeholder="Sum Insured">
                                        </div>
										
										<div class="mb-3">
                                            <input type="text" class="form-control input-default " placeholder="Health Card">
                                        </div>
                                        <div class="mb-3 row">
                                                <label class="col-lg-3 col-form-label">Wedding Date</label>
                                                <div class="col-lg-9">
													<form class="months-fil">
														<input type="date" class="form-control" id="Wedding" name="Wedding">
													</form>
                                                </div>
                                        </div>
										
                                    </form>
                                </div>
                            </div>
							<div class="col-xl-6 col-lg-6">
                                <div class="basic-form">
                                    <form>
                                        <div class="mb-3">
                                            <input type="text" class="form-control input-default" placeholder="Age(automatically calculate from DOB)">
                                        </div>
										<div class="mb-3">
                                            <input type="text" class="form-control input-default" placeholder="Relation">
                                        </div>
                                    </form>
                                </div>
                            </div>
							<div class="col-xl-6 col-lg-6">
                                <div class="basic-form">
                                    <form>
                                        <div class="mb-3 row">
                                                <label class="col-lg-3 col-form-label">Date of Joining</label>
                                                <div class="col-lg-9">
													<form class="months-fil">
														<input type="date" class="form-control" id="joining" name="joining">
													</form>
                                                </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control input-default" placeholder="father in law/mother in law">
                                        </div>
                                    </form>
                                </div>
                            </div>
							
							
							
							
							
							
                            </div>
                            </div>
                      
					</div>
					</div>
					
					
                            </div>
                        </div>
                    </div>--->
					
					
					
				</div>
			
				
            </div>
           


       
        