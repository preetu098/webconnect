
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
                                    <!--<i class="las la-shield-alt"></i>-->
                                    <img src="<?= base_url('external/');?>images/icons/employee-dsh/datadacollection.png" />
                                    </span>
                                 <div class="media-body txt-blue">
                                    <p class="mb-1">Policy Number</p>
                                    <?php 
                                        $pol = $this->qm->all('ri_clientpolicy_tbl','*',array('id'=>$pid));
                                        foreach($pol as $pol);
                                    ?>
                                    <h3 class="txt-blue"><?= ($pol->policy_num==5283)?'Data Collection':$pol->policy_num;?></h3>
                                    <div class="progress mb-2 bg-secondary" style="margin: 5px 0px;">
                                    
                                    </div>
                                  <small style="font-size: 15px;">GHI</small>
                                 </div>
                               </div>
                              </div>
                           </div>
                        </div>
  
                        <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-4">
                        <div class="widget-stat card ">
                           <div class="card-body  p-4">
                                 <div class="media" >
                                   <?php $pol = $this->qm->all('ri_clientpolicy_tbl','*',array('id'=>$pid));
                                   foreach($pol as $pol);
                                   
                                        
                                        
                                            
                                   ?>
                                    <img src="<?= base_url('external/uploads/');?><?= $pol->iimage;?>" style="width: 130px;position: relative;left: 34%;">
                                   
                                 <div class="media-body txt-blue">
                                     <?php 
                                    //   $curl = curl_init();
                                    //     curl_setopt($curl, CURLOPT_URL, "https://crm.riskbirbal.com/admin/api/api/index_get/?tb=pol");
                                    //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                                    //     $output = curl_exec($curl);
                                    //     $decode=json_decode($output);
                                    //     curl_close($curl);
                                    //     print_r($data);
                                    //     foreach ($decode as $typ){
                                    //     $emm =    ($typ->policy_type_id==$pol->policy_type)?$typ->pre_insurer_name:'...';
                                    //     }
                                     ?>
                                    <!--<h3 class="mb-1 txt-blue"></h3>-->
                                  
                                   
                                 
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
                                    <!--<i class="las la-id-card"></i>-->
                                    <img src="<?= base_url('external/');?>images/icons/employee-dsh/id-card.png" />
                                    </span>
                                 <div class="media-body txt-blue">
                                    <p class="mb-1">Health Card</p>
                                    <h3 class="txt-blue">
                                          <?php 
                                    $em = $this->qm->all('ri_employee_tbl','*',array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid));
                                    foreach ($em as $em);
                                   
                                            
                                   ?>
                                
                                  
                               
                                        <?= $em->card;?></h3>
                                          <a style="line-height: 30px;" href="<?= base_url('external/uploads/policy_cards/'.$cid.'_'.$pid.'/');?><?= $em->card;?>.pdf" class="btn my-2 btn-success btn-lg px-4"> Download Your Card</a>
                                    <div class="progress mb-2 bg-secondary" style="margin: 5px 0px;">
                                    
                                    </div>
                  
                                 </div>
                               </div>
                              </div>
                           </div>
                        </div>

                         
                     

                     

                          <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-4">
                        <div class="widget-stat card bg-dark" style="background:#fff !important;">
                           <div class="card-body  p-4">
                                 <div class="media">
                                    <span class="me-3">
                                    <!--<i class="las la-restroom"></i>-->
                                    <img src="<?= base_url('external/');?>images/icons/employee-dsh/dependents.png" />
                                    </span>
                                 <div class="media-body txt-blue">
                                    <p class="mb-1">Dependents</p>
                                    <?php 
                                      $liv2 = $this->qm->all('ri_dependent_tbl','*',array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid));
                                        $c2 = count($liv2);
                                    ?>
                                    <a href="javascript:;"  data-bs-toggle="modal" data-bs-target="#pop-3"><h3 class="txt-blue"><?= $c2;?></h3></a>
                                    <div class="progress mb-2 bg-secondary" style="margin: 5px 0px;">
                                    
                                    </div>
                                    
                                    
                                    
                                    <!--<button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#pop-3">3</button>-->
                                          <div class="modal fade bd-example-modal-lg" tabindex="-1" id="pop-3" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Dependents</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                  
                                                   <table class="table table-responsive-sm">
                                                      <thead>
                                                         <tr>
                                                            <th>#</th>
                                                            <th>Relation</th>
                                                            <th>Info</th>
                                                            <th>Dob/Age</th>
                                                            <th>Edit</th>
                                                         </tr>
                                                      </thead>
                                                      <tbody>
                                                          <?php
                                                          $cnt=0;
                                                          $getdep = $this->qm->all("ri_dependent_tbl","*",array('cid'=>$cid,'pid'=>$pid,'eid'=>$eid));
                                                          foreach($getdep as $fow){
                                                              $cnt++;
                                                          ?>
                                                            <tr>
                                                                <td><?=$cnt?></td>
                                                                <td><?=$fow->reltype?></td>
                                                                <td>Name :- <?=$fow->name?><br>
                                                                   Email :- <?=$fow->email?><br>
                                                                   Phone :-  <?=$fow->phone?>                                                           
                                                                </td>
                                                                <td>Dob :- <?=date_format(date_create($fow->dob),"d-M-Y");?><br>
                                                                   Age :- <?=$fow->age?><br>
                                                                </td>
                                                                <td class="color-primary"><a href="<?=base_url('user/dependents/'.$cid.'/'.$pid.'/'.$eid.'/'.$fow->reltype)?>" class="badge badge-success light">Edit</a></td>
                                                             </tr>
                                                         <?php } ?>
                                                         </tbody>
                                                   </table>
                                                </div>
                                                
                                            </div>
                                        </div>
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
                                    <!--<i class="las la-calendar"></i>-->
                                    <img src="<?= base_url('external/');?>images/icons/employee-dsh/calendar.png" />
                                    </span>
                                 <div class="media-body txt-blue">
                                    <p class="mb-1">Policy Period</p>
                                    <?php 
                                        $pol = $this->qm->all('ri_clientpolicy_tbl','*',array('id'=>$pid));
                                        foreach($pol as $pol);
                                    ?>
                                    <h3 class="txt-blue" style="font-size: 25px;"><?= date('d M, Y', strtotime($pol->sdate));?> - <?= date('d M, Y', strtotime($pol->edate));?></h3>
                                    <div class="progress mb-2 bg-secondary" style="margin: 5px 0px;">
                                    
                                    </div>
                  
                                 </div>
                               </div>
                              </div>
                           </div>
                        </div>
                          <!--<div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-4">
                        <div class="widget-stat card bg-warning">
                           <div class="card-body  p-4">
                                 <div class="media">
                                    <span class="me-3">
                                    <i class="las la-calendar"></i>
                                    </span>
                                 <div class="media-body text-white">
                                    <p class="mb-1">Enrollment Date</p>
                                    <h3 class="text-white" style="font-size: 25px;">20 Jan 2022</h3>
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
        