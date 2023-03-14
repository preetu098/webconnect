<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Clients</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Upload Employee</a></li>
            </ol>
        </div>
        <?php
        $cl = $this->qm->all("ri_clientpolicy_tbl", "*", array('id' => $pid));
        foreach ($cl as $cl);
        ?><div class="col-12 card-header">
            <h4 class="card-title">Client Name : - <?= $cl->cname; ?></h4>
            <h4 class="card-title">Policy Number : -
                <?= ($cl->policy_num == 5283) ? 'Data Collection' : $cl->policy_num; ?>
            </h4>

        </div>
        <div class="row">
            <div class="card-header">
                <h4 class="card-title">Employee Enrollment</h4>
                <!-- <a href="<?= base_url('external/'); ?>insert-emp-templates.xlsx" class="btn btn-primary" download><i class="fa fa-download"></i> Employee & Dependent Excel Templates</a> -->
            </div>


            <div class="col-xl-4 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Insert Data</h4>
                        <a href="<?= base_url('external/'); ?>multiple_additions_admin.xlsx" class="btn btn-primary"
                            download><i class="fa fa-download"></i>Download</a>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form method="POST" action="<?= base_url('clients/uploademp'); ?>/<?= $cid; ?>/<?= $pid; ?>"
                                enctype="multipart/form-data">
                                <?php
                                $cl = $this->qm->all("ri_clients_tbl", "*", array('cid' => $cid));
                                foreach ($cl as $cl);
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
                        <a href="<?= base_url('external/'); ?>multiple_corrections_admin.xlsx" class="btn btn-primary"
                            download><i class="fa fa-download"></i>Download</a>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form method="POST"
                                action="<?= base_url('clients/updateupload'); ?>/<?= $cid; ?>/<?= $pid; ?>"
                                enctype="multipart/form-data">
                                <?php
                                $cl = $this->qm->all("ri_clients_tbl", "*", array('cid' => $cid));
                                foreach ($cl as $cl);
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
                        <a href="<?= base_url('external/'); ?>multiple_deletions.xlsx" class="btn btn-primary"
                            download><i class="fa fa-download"></i>Download</a>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form method="POST" action="<?= base_url('clients/deleteemp/'); ?><?= $cid; ?>/<?= $pid; ?>"
                                enctype="multipart/form-data">
                                <?php
                                $cl = $this->qm->all("ri_clients_tbl", "*", array('cid' => $cid));
                                foreach ($cl as $cl);
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
                    $cl = $this->qm->all("ri_clients_tbl", "*", array('cid' => $cid));
                    foreach ($cl as $cl);
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
                $cl = $this->qm->all("ri_clients_tbl", "*", array('cid' => $cid));
                foreach ($cl as $cl);
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
                    $cl = $this->qm->all("ri_clients_tbl", "*", array('cid' => $cid));
                    foreach ($cl as $cl);
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