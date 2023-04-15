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
                                        <input type="hidden" name='policy_type' value='<?= $newd->policy_type ?>'>

                                        <label class="">SELECT Master Type :</label>
                                        <select name="excel_type" id="excel_type" onchange="masterType(this.value);"
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


                            <form method="POST" id="form" style="display: none;"
                                action="<?= base_url('clients/uploadTemplateFormat'); ?>" enctype="multipart/form-data">
                               
                                <input type="hidden" name="company_id" value="<?= $cname; ?>">
                                <input type="hidden" name="policy_type" value="<?= $policy_type ?>">
                                <input type="hidden" name="endorsement_type" value="<?= $endorsement_type ?>">
                                <div class="row">

                                    <div class="col-lg-6 col-xl-6">
                                        <label class="form-label">Upload</label>
                                        <input type="file" name="efile" class="form-control">
                                    </div>

                                </div>

                                <button type="submit" class="btn btn-primary">Upload</button>
                            </form>

                            <form method="POST" id="form1" style="display: none;"
                                action="<?= base_url('clients/manualTemplateFormat'); ?>">
                                <input type="hidden" name="company_id" value="<?= $cname; ?>">
                                <input type="hidden" name="policy_type" value="<?= $policy_type ?>">
                                <input type="hidden" name="endorsement_type" value="<?= $endorsement_type ?>">

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Corporate</label>
                                        <input type="text" class="form-control" name="corporate">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Employee</label>
                                        <input type="text" class="form-control" name="employee">
                                    </div>
                                    <div class="col-sm-6">
                                        <lable>Age</lable>
                                        <input type="text" class="form-control" name="age">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Sum insured</label>
                                        <input type="text" class="form-control" name="suminsured">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Mode</label>
                                        <input type="text" class="form-control" name="mode">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>DOJ</label>
                                        <input type="text" class="form-control" name="doj">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="dol">DOL</label>
                                        <input type="text" class="form-control" name="dol">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="edd">EDD</label>
                                        <input type="text" class="form-control" name="edd">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="premium">Premium</label>
                                        <input type="text" class="form-control" name='premium'>
                                    </div>

                                </div>

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                            <form method="POST" id="form2" action="<?= base_url('clients/RulesTemplateFormat'); ?>">
                                <input type="hidden" name="company_id" value="<?= $cname; ?>">
                                <input type="hidden" name="policy_type" value="<?= $policy_type ?>">
                                <input type="hidden" name="endorsement_type" value="<?= $endorsement_type ?>">

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>A1</label>
                                        <input type="text" class="form-control" name="A1">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>B1</label>
                                        <input type="text" class="form-control" name="B1">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>C1</label>
                                        <input type="text" class="form-control" name="C1">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>D1</label>
                                        <input type="text" class="form-control" name="D1">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>E1</label>
                                        <input type="text" class="form-control" name="E1">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>F1</label>
                                        <input type="text" class="form-control" name="F1">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>G1</label>
                                        <input type="text" class="form-control" name="G1">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>H1</label>
                                        <input type="text" class="form-control" name="H1">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>I1</label>
                                        <input type="text" class="form-control" name="I1">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>J1</label>
                                        <input type="text" class="form-control" name="J1">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>K1</label>
                                        <input type="text" class="form-control" name="K1">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>L1</label>
                                        <input type="text" class="form-control" name="L1">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>M1</label>
                                        <input type="text" class="form-control" name="M1">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>N1</label>
                                        <input type="text" class="form-control" name="N1">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>O1</label>
                                        <input type="text" class="form-control" name="O1">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>P1</label>
                                        <input type="text" class="form-control" name="P1">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Q1</label>
                                        <input type="text" class="form-control" name="Q1">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>R1</label>
                                        <input type="text" class="form-control" name="R1">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>S1</label>
                                        <input type="text" class="form-control" name="S1">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>T1</label>
                                        <input type="text" class="form-control" name="T1">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>U1</label>
                                        <input type="text" class="form-control" name="U1">
                                    </div>



                                </div>

                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>


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
<script>
    function masterType(value) {
        console.log(value);
        if (value == "automatic") {
            $("#form").css('display', 'block');
            $("#form1").css('display', 'none');
        } else {
            $("#form").css('display', 'none');
            $("#form1").css('display', 'block');
        }
    }
</script>