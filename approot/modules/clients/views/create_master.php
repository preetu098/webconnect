<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Clients</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Upload Template Master</a></li>
            </ol>
        </div>

        <div class="row">
            <div class="col-xl-4 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Upload Template Master</h4>
                        <?php
                        $newd = $this->qm->single("ad_policy_type", "*", array('policy_type_id' => $policy_type, 'policy_dept_id' => '7'));
                        $insurance_company = $this->qm->single('ad_crm_account', "*", array('account_id' => $cname, 'account_type_id' => '1'));
                        echo $insurance_company->account_name . ' | ' . $newd->policy_type_name . ' | ' . str_replace("_", " ", $endorsement_type);
                        // print_r($_POST);
                        ?>
                    </div>
                    <div class="card-body">
                            <div class="basic-form">
                    <div class="col-lg-6 col-xl-6">
                        <div class="tab-content" id="nav-tabContent">

                            <form class="form-group" method="POST" action="">
                                <input type="hidden" name='policy_type' value='<?= $newd->policy_type?>'>

                                <label class="">SELECT Master Type :</label>
                                <select name="excel_type" id="excel_type" onchange="this.form.submit();"
                                    class="form-select form-control" required>
                                    <option value="">-Select-</option>
                                    <option value="automatic" <?php
                                    if ($_POST['excel_type'] == "automatic") {
                                        echo 'selected';
                                    }
                                    ?>>
                            Create From EXcel File</option>
                                    <option value="manual" <?php
                                    if ($_POST['excel_type'] == "manual") {
                                        echo 'selected';
                                    }
                                    ?>>Manual</option>

                                </select>




                            </form>
                        </div>
                    </div>
                    <?php
                    if ($_POST['excel_type'] == "automatic") {
                        ?>
                        
                                <form method="POST"
                                    action="<?= base_url('clients/uploadTemplateFormat');?>"
                                    enctype="multipart/form-data">
                                    <?php
                                    $cl = $this->qm->all("ri_clients_tbl", "*", array('cid' => $cid));
                                    foreach ($cl as $cl)
                                        ;
                                    ?>
                                    <input type="hidden" name="client_code" value="<?= $cl->ccode; ?>">
                                    <input type="hidden" name="client_name" value="<?= $cl->cname; ?>">
                                    <input type="hidden" name="data_type" value="1">
                                    <div class="row">

                                        <div class="col-lg-6 col-xl-6">
                                            <label class="form-label">Upload</label>
                                            <input type="file" name="efile" class="form-control">
                                        </div>

                                    </div>

                                    <button type="submit" class="btn btn-primary">Upload</button>
                                </form>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                </div>
            </div>



        </div>
    </div>
</div>


</div>

<!-- <div class="row">
                <div class="card-header">
         <h4 class="card-title">Member Upload</h4>
         <a href="<?= base_url('external/'); ?>dependent.xlsx" class="btn btn-info" download><i class="fa fa-download"></i> Dependent Excel</a>
      </div>
                  
                 
              <div class="col-xl-4 col-lg-12">
   <div class="card">
      <div class="card-header">
         <h4 class="card-title">Insert Data</h4>
      </div>
      <div class="card-body">
         <div class="basic-form">
            <form method="POST" action="<?= base_url('clients/uploadmember'); ?>/<?= $cid; ?>/<?= $pid; ?>" enctype="multipart/form-data">
                  <?php
                  $cl = $this->qm->all("ri_clients_tbl", "*", array('cid' => $cid)); foreach ($cl as $cl)
                      ;
                  ?>
                     <input type="hidden" name="client_code" value="<?= $cl->ccode; ?>">
                     <input type="hidden" name="client_name" value="<?= $cl->cname; ?>">
                     <input type="hidden" name="data_type" value="1">
               <div class="row">
               
                  <div class="mb-3 col-md-12">
                     <label class="form-label">Upload</label>
                     <input type="file" name="efile" class="form-control">
                  </div>
                  
               </div>
               
               <button type="submit" class="btn btn-primary">Upload</button>
            </form>
         </div>
      </div>
   </div>
</div>
<div class="col-xl-4 col-lg-12">
   <div class="card">
      <div class="card-header">
         <h4 class="card-title">Update Data</h4>
      </div>
      <div class="card-body">
         <div class="basic-form">
              <form method="POST" action="<?= base_url('clients/updatemember'); ?>/<?= $cid; ?>/<?= $pid; ?>" enctype="multipart/form-data">
               <?php
               $cl = $this->qm->all("ri_clients_tbl", "*", array('cid' => $cid)); foreach ($cl as $cl)
                   ;
               ?>
                     <input type="hidden" name="client_code" value="<?= $cl->ccode; ?>">
                     <input type="hidden" name="client_name" value="<?= $cl->cname; ?>">
                     <input type="hidden" name="data_type" value="1">
               <div class="row">
               
                  <div class="mb-3 col-md-12">
                     <label class="form-label">Upload</label>
                     <input type="file" name="efile" class="form-control">
                  </div>
                  
               </div>
               
               <button type="submit" class="btn btn-primary">Upload</button>
            </form>
         </div>
      </div>
   </div>
</div>
<div class="col-xl-4 col-lg-12">
   <div class="card">
      <div class="card-header">
         <h4 class="card-title">Delete Data</h4>
      </div>
      <div class="card-body">
         <div class="basic-form">
            <form method="POST" action="<?= base_url('clients/deletemember'); ?>/<?= $cid; ?>/<?= $pid; ?>" enctype="multipart/form-data">
                 <?php
                 $cl = $this->qm->all("ri_clients_tbl", "*", array('cid' => $cid)); foreach ($cl as $cl)
                     ;
                 ?>
                     <input type="hidden" name="client_code" value="<?= $cl->ccode; ?>">
                     <input type="hidden" name="client_name" value="<?= $cl->cname; ?>">
                     <input type="hidden" name="data_type" value="1">
               <div class="row">
               
                  <div class="mb-3 col-md-12">
                     <label class="form-label">Upload</label>
                     <input type="file" name="efile" class="form-control">
                  </div>
                  
               </div>
               
               <button type="submit" class="btn btn-primary">Upload</button>
            </form>
         </div>
      </div>
   </div>
</div>

                  
                
                 
                  
                 
               </div> -->
</div>
</div>