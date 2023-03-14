
         <div class="content-body">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-xl-12">
                     <div class="row">
                        <div class="col-xl-12">
                           <div class="row">
                              <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-4">
                                 <div class="widget-stat card" style="box-shadow: 0px 0px 10px -2px rgb(55 55 55 / 21%);">
                                    <div class="card-body p-4" >
                                       <div class="media ai-icon">
                                          <span class="me-3 bgl-primary text-primary">
                                            <img src="<?= base_url('external/');?>images/icons/admin-dsh/noofclients.png" class="img-cstm-cod img-responsive" />
                                          <!--<i class="fas fa-users"></i>--->
                                          <circle cx="12" cy="7" r="4"></circle>
                                          </svg>
                                          </span>
                                          <div class="media-body">
                                          <p class="mb-1">No. Of Clients</p>
                                           <?php 
                     $cl = $this->qm->all("ri_clientpolicy_tbl");
                     $client = count($cl);
                     ?>
                                          <h4 class="mb-0"><?= $client;?></h4>
                                         
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                               <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-4">
                                 <div class="widget-stat card" style="box-shadow: 0px 0px 10px -2px rgb(55 55 55 / 21%);">
                                    <div class="card-body p-4" >
                                       <div class="media ai-icon">
                                          <span class="me-3 bgl-warning text-warning">
                                            <img src="<?= base_url('external/');?>images/icons/admin-dsh/noofusers.png" class="img-cstm-cod img-responsive" />
                                          <!--<i class="fas fa-users"></i>-->
                                          <circle cx="12" cy="7" r="4"></circle>
                                          </svg>
                                          </span>
                                          <div class="media-body">
                                          <p class="mb-1 orng-clr">No. Of Users</p>
                                             <?php
                                    
                                       $emp = $this->qm->all('ri_employee_tbl');
                                      $empp = count($emp);
                                    ?>
                                          <h4 class="mb-0"><?= $empp;?></h4>
                                         
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                               <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-4">
                                 <div class="widget-stat card" style="box-shadow: 0px 0px 10px -2px rgb(55 55 55 / 21%);">
                                    <div class="card-body p-4" >
                                       <div class="media ai-icon">
                                          <span class="me-3 bgl-primary text-success">
                                            <img src="<?= base_url('external/');?>images/icons/admin-dsh/totalsum.png" class="img-cstm-cod img-responsive" />
                                         <!--<i class="fas fa-rupee-sign"></i>-->
                                          <circle cx="12" cy="7" r="4"></circle>
                                          </svg>
                                          </span>
                                          <div class="media-body">
                                          <p class="mb-1">Total Sum Insured</p>
                                          <h4 class="mb-0">3280</h4>
                                         
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                               <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-4">
                                 <div class="widget-stat card" style="box-shadow: 0px 0px 10px -2px rgb(55 55 55 / 21%);">
                                    <div class="card-body p-4" >
                                       <div class="media ai-icon">
                                          <span class="me-3 bgl-warning text-dark">
                                              <img src="<?= base_url('external/');?>images/icons/admin-dsh/activepolicies.png" class="img-cstm-cod img-responsive" />
                        
                                         <!--<svg id="icon-orders" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                                          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                          <polyline points="14 2 14 8 20 8"></polyline>
                                          <line x1="16" y1="13" x2="8" y2="13"></line>
                                          <line x1="16" y1="17" x2="8" y2="17"></line>
                                          <polyline points="10 9 9 9 8 9"></polyline>
                                          </svg>-->
                                          <circle cx="12" cy="7" r="4"></circle>
                                          </svg>
                                          </span>
                                          <div class="media-body">
                                              <?php 
                                                    $pol = $this->qm->all('ri_clientpolicy_tbl','*',array('status'=>1));
                                                    $co = count($pol);
                                              ?>
                                          <p class="mb-1 orng-clr">Active Policies</p>
                                          <h4 class="mb-0"><?= $co;?></h4>
                                         
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-4">
                                 <div class="widget-stat card" style="box-shadow: 0px 0px 10px -2px rgb(55 55 55 / 21%);">
                                    <div class="card-body p-4" >
                                       <div class="media ai-icon">
                                          <span class="me-3 bgl-primary text-danger">
                                              <img src="<?= base_url('external/');?>images/icons/admin-dsh/inactive.png" class="img-cstm-cod img-responsive" />

                                         <!--<svg id="icon-orders" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                                          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                          <polyline points="14 2 14 8 20 8"></polyline>
                                          <line x1="16" y1="13" x2="8" y2="13"></line>
                                          <line x1="16" y1="17" x2="8" y2="17"></line>
                                          <polyline points="10 9 9 9 8 9"></polyline>
                                          </svg>-->
                                          <circle cx="12" cy="7" r="4"></circle>
                                          </svg>
                                          </span>
                                          <div class="media-body">
                                               <?php 
                                                    $pol = $this->qm->all('ri_clientpolicy_tbl','*',array('status'=>0));
                                                    $co = count($pol);
                                              ?>
                                          <p class="mb-1">Inactive Policies</p>
                                          <h4 class="mb-0"><?= $co;?></h4>
                                         
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                         
                              <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-4">
                                 <div class="widget-stat card" style="box-shadow: 0px 0px 10px -2px rgb(55 55 55 / 21%);">
                                    <div class="card-body p-4" >
                                       <div class="media ai-icon">
                                          <span class="me-3 bgl-warning text-primary">
                                              <img src="<?= base_url('external/');?>images/icons/admin-dsh/ghi.png" class="img-cstm-cod img-responsive" />

                                          <!--<i class="fas fa-users"></i>-->
                                          <circle cx="12" cy="7" r="4"></circle>
                                          </svg>
                                          </span>
                                          <div class="media-body"><?php 
                                          $curl = curl_init();
                                          curl_setopt($curl, CURLOPT_URL, "https://crm.riskbirbal.com/admin/api/api/index_get/?tb=pol");
                                          curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                                          $output = curl_exec($curl);
                                        $decode=json_decode($output);
                                        curl_close($curl);
                                        
                                        //$co = count($decode);
                                        //print_r($decode);
                                        $flotter = 0;
                                        $nflotter = 0;
                                        foreach($decode as $co)
                                        {
                                            //echo $co['policy_type_id'];
                                            if($co->policy_type_id == 107)
                                            {
                                                $flotter = $flotter+1;
                                            }
                                            if($co->policy_type_id == 108)
                                            {
                                                $nflotter = $nflotter+1;
                                            }
                                        }
                                      
                                        
                                          ?>
                                          <p class="mb-1 orng-clr">GHI-1</p>
                                          <h4 class="mb-0"><?= ($flotter+$nflotter);?></h4>
                                         
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                               <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-4">
                                 <div class="widget-stat card" style="box-shadow: 0px 0px 10px -2px rgb(55 55 55 / 21%);">
                                    <div class="card-body p-4" >
                                       <div class="media ai-icon">
                                          <span class="me-3 bgl-primary text-info">
                                              <img src="<?= base_url('external/');?>images/icons/admin-dsh/gtli.png" class="img-cstm-cod img-responsive" />

                                         <!-- <i class="fas fa-user-plus"></i>--->
                                          <circle cx="12" cy="7" r="4"></circle>
                                          </svg>
                                          </span>
                                          <div class="media-body">
                                            
                                          <p class="mb-1">GTLI</p>
                                          <h4 class="mb-0">0</h4>
                                         
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                               <div class="col-xl-3 col-xxl-4 col-lg-4 col-sm-4">
                                 <div class="widget-stat card" style="box-shadow: 0px 0px 10px -2px rgb(55 55 55 / 21%);">
                                    <div class="card-body p-4" >
                                       <div class="media ai-icon">
                                          <span class="me-3 bgl-warning text-warning">
                                              <img src="<?= base_url('external/');?>images/icons/admin-dsh/gpa.png" class="img-cstm-cod img-responsive" />

                                          <!---<i class="fas fa-user-plus"></i>-->
                                          <circle cx="12" cy="7" r="4"></circle>
                                          </svg>
                                          </span>
                                          <div class="media-body">
                                                <?php 
                                          $curl = curl_init();
                                          curl_setopt($curl, CURLOPT_URL, "https://crm.riskbirbal.com/admin/api/api/index_get/?tb=pol");
                                          curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                                          $output = curl_exec($curl);
                                        $decode=json_decode($output,true);
                                        curl_close($curl);
                                        
                                        //$co = count($decode);
                                        $flotr = 0;
                                        foreach($decode as $co)
                                        {
                                            if($co->policy_type_id == 109)
                                            {
                                                $flotter = $flotr +1;
                                            }
                                            
                                        }
                                        
                                          ?>
                                          <p class="mb-1 orng-clr">GPA</p>
                                          <h4 class="mb-0"><?= $flotter;?></h4>
                                         
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
            </div>
         </div>
        