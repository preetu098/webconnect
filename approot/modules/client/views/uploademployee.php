<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Clients</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Upload Employee</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="card-header">
                <h4 class="card-title">Employee Enrollment</h4>
                <!--<a href="<?= base_url('external/'); ?>Book1.xlsx" class="btn btn-primary" download><i class="fa fa-download"></i> Employee Excel</a>-->
            </div>
            <div class="col-xl-4 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Multiple Addition</h4>

                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form method="POST" action="<?= base_url('client/uploademp'); ?>/<?= $pid; ?>" enctype="multipart/form-data">
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
                                        <br>
                                        Download Sample Sheet: <a href="<?= base_url('external/'); ?>multiple_additions.xlsx"> <i class="fas fa-download"></i></a>
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
                        <h4 class="card-title">Multiple Corrections</h4>

                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form method="POST" action="<?= base_url('client/updateupload'); ?>/<?= $pid; ?>" enctype="multipart/form-data">
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
                                        <br>
                                        Download Sample Sheet: <a href="<?= base_url('external/'); ?>multiple_corrections.xlsx"> <i class="fas fa-download"></i></a>
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
                        <h4 class="card-title">Multiple Deletion Data</h4>

                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form method="POST" action="<?= base_url('client/deleteemp/'); ?><?= $pid; ?>" enctype="multipart/form-data">
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
                                        <br>
                                        Download Sample Sheet: <a href="<?= base_url('external/'); ?>multiple_deletions.xlsx"> <i class="fas fa-download"></i></a>
                                    </div>

                                </div>

                                <button type="submit" class="btn btn-primary">Upload</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>






        </div>

        <!--
               <div class="row">
                <div class="card-header">
         <h4 class="card-title">New Member Addition</h4>
         <a href="<?= base_url('external/'); ?>dependent.xlsx" class="btn btn-info" download><i class="fa fa-download"></i> Dependent Excel</a>
      </div>
                  
                 
              <div class="col-xl-4 col-lg-12">
   <div class="card">
      <div class="card-header">
         <h4 class="card-title">Insert Data</h4>
      </div>
      <div class="card-body">
         <div class="basic-form">
            <form method="POST" action="<?= base_url('client/uploadmember'); ?>/<?= $pid; ?>" enctype="multipart/form-data">
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
              <form method="POST" action="<?= base_url('client/updatemember'); ?>/<?= $pid; ?>" enctype="multipart/form-data">
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
            <form method="POST" action="<?= base_url('client/deletemember'); ?>/<?= $pid; ?>" enctype="multipart/form-data">
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

                  
                
                 
                  
                 
               </div>-->
    </div>
</div>