
         <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles">
                  <nav class="navbar navbar-expand-lg navbar-light">
                 

                 <div class="collapse navbar-collapse" id="navbarSupportedContent">
                   <ul class="navbar-nav mr-auto">
                     <li class="nav-item active">
                       <a class="nav-link" href="#ppt"><i class="fa fa-file-powerpoint"></i>
                     <span class="nav-text">PPT</span></a>
                     </li>
                     <li class="nav-item">
                       <a class="nav-link" href="#banner"><i class="fa fa-images"></i>
                     <span class="nav-text">Banners</span></a>
                     </li>
                     <li class="nav-item">
                       <a class="nav-link" href="#faq"><i class="fa fa-comments"></i>
                     <span class="nav-text">FAQ's</span></a>
                     </li>
                     <li class="nav-item">
                       <a class="nav-link" href="#hb"><i class="las la-heartbeat"></i>
                     <span class="nav-text">Health Benefits</span></a>
                     </li>
                     <li class="nav-item">
                       <a class="nav-link" href="#doc"><i class="fa fa-file"></i>
                     <span class="nav-text">Documents</span></a>
                     </li>
                   </ul>
                 </div>
                   <a  href="<?= base_url('client/employees');?>/<?= $pid;?>" class="btn btn-success" aria-expanded="false"><span class="btn-icon-start text-success"><i class="fa fa-users"></i>
                                    </span>Employees </a>
               </nav>
               </div>
               <div class="row">
                  <div class="col-xl-12">
                     <div class="row">
                       <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-4">
                        <div class="widget-stat card bg-success" style="background:#fff !important;">
                           <div class="card-body  p-4">
                                 <div class="media">
                                    <span class="me-3">
                                   <!-- <i class="las la-shield-alt"></i>-->
                                   <img src="<?= base_url('external/');?>images/icons/manage-policies/datadacollection.png" />
                                    </span>
                                 <div class="media-body txt-blue">
                                    <p class="mb-1">Policy Number</p>
                                    <?php 
                                        $pol = $this->qm->all('ri_clientpolicy_tbl','*',array('id'=>$pid));
                                        foreach($pol as $pol);
                                    ?>
                                    <h3 class="txt-blue"><?= ($pol->policy_num==5283)?'Data Collection':$pol->policy_num;?></h3>
                                    <div class="progress mb-2 bg-secondary">
                                    
                                    </div>
                                  <small style="font-size: 15px;" >GHI</small>
                                 </div>
                               </div>
                              </div>
                           </div>
                        </div>

                        <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-4">
                        <div class="widget-stat card ">
                           <div class="card-body  p-4">
                                 <div class="media" style="margin-top: 27px;text-align: center;">
                                   
                                    <img src="<?= base_url('external/');?>images/insu.png" style="width: 130px;">
                                   
                                 <div class="media-body text-black">
                                    <h3 class="mb-1 txt-blue">New India Assurance</h3>
                                    
                                   
                                 
                                 </div>
                               </div>
                              </div>
                           </div>
                        </div>

                        <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-4">
                        <div class="widget-stat card bg-primary" style="background:#fff !important;">
                           <div class="card-body  p-4">
                                 <div class="media">
                                    <span class="me-3">
                                    <!--<i class="la la-users"></i>-->
                                    <img src="<?= base_url('external/');?>images/icons/manage-policies/totallives.png" />
                                    </span>
                                 <div class="media-body text-white">
                                    <p class="mb-1">Total Lives</p>
                                    <?php 
                                        $liv1 = $this->qm->all('ri_employee_tbl','*',array('cid'=>$cid,'pid'=>$pid));
                                        $c1 = count($liv1);
                                        $liv2 = $this->qm->all('ri_dependent_tbl','*',array('cid'=>$cid,'pid'=>$pid));
                                        $c2 = count($liv2);
                                    ?>
                                    <h3 class="txt-blue"><?= $c1+$c2;?></h3>
                                    <div class="progress mb-2 bg-secondary">
                                    
                                    </div>
                  
                                 </div>
                               </div>
                              </div>
                           </div>
                        </div>
                          <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-4">
                        <div class="widget-stat card bg-info" style="background:#fff !important;">
                           <div class="card-body  p-4">
                                 <div class="media">
                                    <span class="me-3">
                                    <!--<i class="la la-user"></i>-->
                                    <img src="<?= base_url('external/');?>images/icons/manage-policies/empolyees.png" />
                                    </span>
                                 <div class="media-body text-white">
                                    <p class="mb-1">Employees</p>
                                  
                                    <h3 class="txt-blue"><?= $c1;?></h3>
                                    <div class="progress mb-2 bg-secondary">
                                    
                                    </div>
                  
                                 </div>
                               </div>
                              </div>
                           </div>
                        </div>
                         
                         <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-4">
                        <div class="widget-stat card bg-danger" style="background:#fff !important;">
                           <div class="card-body  p-4">
                                 <div class="media">
                                    <span class="me-3">
                                    <!--<i class="las la-female"></i>-->
                                    <img src="<?= base_url('external/');?>images/icons/manage-policies/spouse.png" />
                                    </span>
                                 <div class="media-body text-white">
                                    <p class="mb-1">Spouse</p>
                                    <?php 
                                    $wh = "cid ='".$cid."' AND pid='".$pid."' AND reltype IN('Spouse')";
                                     $liv = $this->qm->all('ri_dependent_tbl','*',$wh);
                                        $c = count($liv);
                                    ?>
                                    <h3 class="txt-blue"><?= $c;?></h3>
                                    <div class="progress mb-2 bg-secondary">
                                    
                                    </div>
                  
                                 </div>
                               </div>
                              </div>
                           </div>
                        </div>

                        <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-4">
                        <div class="widget-stat card bg-warning" style="background:#fff !important;">
                           <div class="card-body  p-4">
                                 <div class="media">
                                    <span class="me-3">
                                    <!--<i class="las la-baby"></i>-->
                                    <img src="<?= base_url('external/');?>images/icons/manage-policies/child.png" />
                                    </span>
                                 <div class="media-body text-white">
                                    <p class="mb-1">Child</p>
                                     <?php 
                                      $wh = "cid ='".$cid."' AND pid='".$pid."' AND reltype IN('Kid')";
                                     $liv = $this->qm->all('ri_dependent_tbl','*',$wh);
                                        $c22 = count($liv);
                                    ?>
                                    <h3 class="txt-blue"><?= $c22;?></h3>
                                    <div class="progress mb-2 bg-secondary">
                                    
                                    </div>
                  
                                 </div>
                               </div>
                              </div>
                           </div>
                        </div>

                          <!--<div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-4">
                        <div class="widget-stat card bg-dark">
                           <div class="card-body  p-4">
                                 <div class="media">
                                    <span class="me-3">
                                    <i class="las la-coin"></i>
                                    </span>
                                 <div class="media-body text-white">
                                    <p class="mb-1">Sum Insured</p>
                                    <h3 class="text-white">90</h3>
                                    <div class="progress mb-2 bg-secondary">
                                    
                                    </div>
                  
                                 </div>
                               </div>
                              </div>
                           </div>
                        </div>-->

                          <!--<div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-4">
                        <div class="widget-stat card bg-success">
                           <div class="card-body  p-4">
                                 <div class="media">
                                    <span class="me-3">
                                    <i class="las la-rupee-sign"></i>
                                    </span>
                                 <div class="media-body text-white">
                                    <p class="mb-1">CD Balance</p>
                                    <h3 class="text-white"> 1,00,000</h3>
                                    <div class="progress mb-2 bg-secondary">
                                    
                                    </div>
                  
                                 </div>
                               </div>
                              </div>
                           </div>
                        </div>
                         
                          <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-4">
                        <div class="widget-stat card bg-info">
                           <div class="card-body  p-4">
                                 <div class="media">
                                    <span class="me-3">
                                    <i class="las la-coins"></i>
                                    </span>
                                 <div class="media-body text-white">
                                    <p class="mb-1">Active Claim</p>
                                    <h3 class="text-white">₹ 30,000</h3>
                                    <div class="progress mb-2 bg-secondary">
                                    
                                    </div>
                  
                                 </div>
                               </div>
                              </div>
                           </div>
                        </div>-->
                        
                        <div class="col-lg-10" style="margin:0 auto;" id="ppt">
                           <?php 
                             $ppt = $this->qm->all('upload_ppt_ri','*',array('cid'=>$cid,'pid'=>$pid));
                                       foreach ($ppt as $ppt);

                           ?>
                           <div class="card">
                              <div class="card-header">
                                 <h4 class="card-title"><?= !empty($ppt->ppt_name)?$ppt->ppt_name:'';?></h4>
                              </div>
                              <div class="card-body">
                                  <?php 
                                    if(!empty($ppt->ppt)){
                                  ?>
                                <iframe src='https://view.officeapps.live.com/op/embed.aspx?src=<?= base_url('external/uploads/');?><?= $ppt->ppt;?>' width='100%' height='400px' frameborder='0' style="height: 727px;padding: 30px;"> </iframe>
                                <?php }
                                    else{
                                        echo "PPT Not Uploaded !";
                                    }
                                ?>
                             
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-12" id="hb">
                        
                           <div class="card">
                              <div class="card-header">
                                 <h4 class="card-title">Health Benefits</h4>
                              </div>
                              <div class="card-body">
                                 <div class="row">
                                    <div class="col-xl-3 img">
                                       <img src="<?= base_url('external/');?>images/1.png">
                                    </div>
                                     <div class="col-xl-3 img">
                                       <img src="<?= base_url('external/');?>images/2.png">
                                    </div>
                                     <div class="col-xl-3 img">
                                       <img src="<?= base_url('external/');?>images/3.png">
                                    </div>
                                     <div class="col-xl-3 img">
                                       <img src="<?= base_url('external/');?>images/4.png">
                                    </div>
                                     <div class="col-xl-3 img">
                                       <img src="<?= base_url('external/');?>images/5.png">
                                    </div>
                                     <div class="col-xl-3 img">
                                       <img src="<?= base_url('external/');?>images/6.png">
                                    </div>
                                    <div class="col-xl-3 img">
                                       <img src="<?= base_url('external/');?>images/7.png">
                                    </div>
                                    <div class="col-xl-3 img">
                                       <img src="<?= base_url('external/');?>images/8.png">
                                    </div>

                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-xl-6" id="banner">
                        <div class="card">
                           <div class="card-body p-4">
                              
                                      <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                 
                                          <div class="carousel-inner">
                                             <?php 
               $ss =1;
               $img = $this->qm->all('ri_banner_tbl','*',array('cid'=>$cid,'pid'=>$pid));
               foreach ($img as $img) {
                  
            ?>    
               <div class="carousel-item <?= ($ss==1)?'active':'';?>">
                  <img class="d-block w-100" src="<?= base_url('external/uploads/');?><?= $img->banner_img;?>" style="height: 350px;object-fit: cover;">
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
                    </div>
                        <div class="col-xl-6" id="faq">
                           <div class="card">
                              <div class="card-header d-block">
                                 <h4 class="card-title">FAQ's</h4>
                                
                              </div>
                              <div class="card-body">
                                 <div class="accordion accordion-danger-solid" id="accordion-two">
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
                  </div>



                  <!-- Next Col -->
                  
               </div>
            </div>
         </div>
        