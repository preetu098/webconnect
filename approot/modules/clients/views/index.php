
         <div class="content-body">
            <div class="container-fluid">
               <div class="row page-titles">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item active"><a href="javascript:void(0)">Clients</a></li>
                     <li class="breadcrumb-item"><a href="javascript:void(0)">Add Client</a></li>
                  </ol>
               </div>
               <div class="row">
                
                  
                 
               
                  
                
                  <div class="col-xl-12 col-lg-12">
                     <div class="card">
                        <div class="card-header">
                           <h4 class="card-title">Add Clients</h4>
                            <?php 
                                 if(!empty($this->session->flashdata('success'))){

                                    $success = $this->session->flashdata('success');
                              ?>
                           <div class="alert alert-success alert-dismissible fade show" style="width: 25%;">

                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                              </button>
                              <strong>Success!</strong><?= $success;?>
                           </div>
                        <?php }
                        else if(!empty($this->session->flashdata('error'))){
                           $error = $this->session->flashdata('error');
                         ?>
                          <div class="alert alert-danger alert-dismissible fade show" style="width: 25%;">

                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                              </button>
                              <strong>Error!</strong> <?= $error;?>
                           </div>
                         <?php }else{} ?>  
                        </div>
                        <div class="card-body">
                           <div class="basic-form">
                              <form method="POST" action="<?= base_url('clients/addclient');?>" enctype="multipart/form-data">
                                 <div class="row">
                                    <div class="mb-3 col-md-6">
                                       <label class="form-label"> Company Code </label>
                                       <input type="text" name="ccode" class="form-control" id="cod"  required>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                       <label class="form-label">Company Name</label>
                                       <select class="form-control" name="cname" id="cname" onchange="myFunction(this.value)">
                                        <option>Select Company</option>
                                        <?php 
                                        //   $cli = $this->qm->all('ad_crm_account');
                                        //   foreach ($cli as $cli) {   
                                        /*$curl = curl_init();
                                        curl_setopt($curl, CURLOPT_URL, "https://crm.riskbirbal.com/admin/api/api/index_get/?tb=acc");
                                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                                        $output = curl_exec($curl);
                                        $decode=json_decode($output);
                                        curl_close($curl);
                                        print_r($data);*/
                                        
                                        $decode = $this->qm->all2("ad_crm_account","*",array('account_type_id'=>'2'));
                                  
                                        
                                        
                                        foreach ($decode as $cli){
                                         
                                         ?>

                                          <option value="<?= $cli->account_name;?>"><?= $cli->account_name;?></option>
                                          <?php } ?>
                                       </select>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                       <label class="form-label">Mobile</label>
                                        <input type="text" name="phone" maxlength="10" class="form-control"  required>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                       <label class="form-label">Email</label>
                                       <input type="email" name="email" class="form-control"   required>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                       <label class="form-label">Company Logo</label>
                                       <input type="file" name="image" class="form-control">
                                    </div> 
                                    <div class="mb-3 col-md-6">
                                       <label class="form-label">Status</label>
                                        <select class="form-control" name="status">
                                          <option value="1">Active</option>
                                          <option value="0">Inactive</option>

                                       </select>
                                    </div>

                                     <div class="col-md-3 mb-3">
                                     <label class="form-label">Tech Support Name</label>
                                     <input type="text" name="tname" class="form-control"   required>
                                     
                                   </div>
                                 
                                    <div class="col-md-3 mb-3">
                                     <label class="form-label">Tech Support Mobile</label>
                                     <input type="text" name="tphone" maxlength="10" class="form-control"   required>
                                     
                                   </div>
                                    <div class="col-md-3 mb-3">
                                     <label class="form-label">Tech Support Email</label>
                                     <input type="email" name="temail" class="form-control"   required>
                                     
                                   </div>
                                   
                                   

                                   <div class="col-md-3 mb-3">
                                     <label class="form-label">Functional Support Name</label>
                                     <input type="text" name="fname" class="form-control"   required>
                                    
                                   </div>
                                 
                                    <div class="col-md-3 mb-3">
                                     <label class="form-label">Functional Support Mobile</label>
                                     <input type="text" name="fphone" maxlength="10" class="form-control"   required>
                                    
                                   </div>
                                    <div class="col-md-3 mb-3">
                                     <label class="form-label">Functional Support Email</label>
                                     <input type="email" name="femail" class="form-control"   required>
                                     
                                   </div>
                                   
                                   
                                    <div class="col-md-3 mb-3">
                                     <label class="form-label">Wellness Support Name</label>
                                     <input type="text" name="wname" class="form-control"   required>
                                    
                                   </div>
                                 
                                    <div class="col-md-3 mb-3">
                                     <label class="form-label">Wellness Support Mobile</label>
                                     <input type="text" name="wphone" maxlength="10" class="form-control"   required>
                                    
                                   </div>
                                    <div class="col-md-3 mb-3">
                                     <label class="form-label">Wellness Support Email</label>
                                     <input type="email" name="wemail" class="form-control"   required>
                                     
                                   </div>

                                 </div>
                                 
                                
                                 <button type="submit" class="btn btn-primary">Add Client</button>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
                  
                 
               </div>
            </div>
         </div>
    
