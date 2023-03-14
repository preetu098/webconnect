<div class="content-body">
   <div class="container-fluid">
      <div class="row page-titles">
         <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Clients</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Add Policy</a></li>
         </ol>
      </div>
      <div class="row">
         <div class="col-xl-12 col-lg-12">
            <div class="card">
               <div class="card-header">
                  <h4 class="card-title">Add Policy</h4>
                  <?php
                  if (!empty($this->session->flashdata('error'))) {
                     $error = $this->session->flashdata('error');
                  ?>
                     <div class="alert alert-danger alert-dismissible fade show" style="width: 25%;">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                        </button>
                        <strong>Error!</strong> <?= $error; ?>
                     </div>
                  <?php } else {
                  } ?>
               </div>
               <div class="card-body">
                  <div class="basic-form">
                     <form method="POST" action="<?= base_url('clients/addpolicy'); ?>" enctype="multipart/form-data">
                        <div class="row">
                           <div class="mb-3 col-md-6">
                              <label class="form-label">Company Name</label>
                              <select class="form-control" name="cname" id="cname" required>
                                 <option>Select Company</option>
                                 <?php
                                 $cli = $this->qm->all('ri_clients_tbl');
                                 foreach ($cli as $cli) {
                                 ?>
                                    <option value="<?= $cli->cid; ?>|<?= $cli->cname; ?>|<?= $cli->ccode; ?>"><?= $cli->cname; ?></option>
                                 <?php } ?>
                              </select>
                           </div>
                           <div class="mb-3 col-md-6">
                              <label class="form-label">Policy Type</label>
                              <select class="form-control" name="policy_type" id="type" onchange="chnType(this.value)" required>
                                 <option>Select Type</option>
                                 <option value="5283">Data Collection</option>
                                 <?php
                                 //   $cli = $this->qm->all('ad_crm_account');
                                 //   foreach ($cli as $cli) {   

                                 //print_r($data);
                                 $newd = $this->qm->all2("ad_policy_type", "*", array('policy_dept_id' => '7'));
                                 //print_r($newd);
                                 foreach ($newd as $typ) {
                                 ?>
                                    <option value="<?= $typ->policy_type_id; ?>"><?= $typ->policy_type_name; ?></option>
                                 <?php } ?>
                              </select>
                           </div>
                           <div class="mb-3 col-md-3">
                              <label class="form-label">Status</label>
                              <select class="form-control" name="status" required>
                                 <option value="1">Active</option>
                                 <option value="0">Inactive</option>
                              </select>
                           </div>
                           <div class="mb-3 col-md-3">
                              <label class="form-label">Insurer Image</label>
                              <input type="file" name="iimage" class="form-control">
                           </div>
                           <div class="mb-3 col-md-3">
                              <label class="form-label">List of TPA</label>
                              <select class="form-control" name="tpa" required>
                                 <option value="">Select TPA</option>
                                 <?php
                                 $tp = $this->qm->all2("ad_crm_account", "*", array('account_type_id' => '5'));
                                 foreach ($tp as $tps) {
                                 ?>
                                    <option value="<?= $tps->account_name ?>"><?= $tps->account_name ?></option>
                                 <?php } ?>
                              </select>
                           </div>
                           <div class="mb-3 col-md-3">
                              <div id="inp"></div>
                           </div>
                           <div class="mb-3 col-md-3">
                              <label class="form-label">Servicing Team Member</label>
                              <!--<input type="date" name="sdate" value="<?= $pol->sdate; ?>" class="form-control">-->
                              <select name="servicing" class="form-control">
                                 <option>Select Option</option>
                                 <?php
                                 $serv = $this->qm->all2("ad_user", "*", array('department_id' => '28'));
                                 foreach ($serv as $row) {
                                 ?>
                                    <option value="<?= $row->firstname . ' ' . $row->lastname ?>"><?= $row->firstname . ' ' . $row->lastname ?></option>
                                 <?php } ?>
                              </select>
                           </div>
                           <div class="mb-3 col-md-6">
                              <label class="form-label">Start Date</label>
                              <input type="date" name="sdate" class="form-control">
                           </div>
                           <div class="mb-3 col-md-6">
                              <label class="form-label">End Date</label>
                              <input type="date" name="edate" class="form-control">
                           </div>
                           <div class="mb-3 col-md-6">
                              <label class="form-label">Sum Insured</label>
                              <input type="text" name="suminsured" class="form-control" placeholder="1lac,2lac,4lac..">
                           </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Policy</button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script type="text/javascript">
   function chnType(typ) {

      $.ajax({
         type: "GET",
         url: "<?= base_url('clients/getpolicy/'); ?>" + typ,
         success: function(result) {

            $("#inp").html(result);


         }
      });
   }
</script>