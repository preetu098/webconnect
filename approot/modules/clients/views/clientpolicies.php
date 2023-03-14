
         <div class="content-body">
            <div class="container-fluid">
               <div class="row page-titles">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item active"><a href="javascript:void(0)">Clients</a></li>
                     <li class="breadcrumb-item"><a href="javascript:void(0)">Client Policies</a></li>
                  </ol>
               </div>
               <div class="row">
                  <div class="col-12">
                     <div class="card">
                        <div class="card-header">
                           <h4 class="card-title">Client List</h4>
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
                        else{} ?> 
                           <a href="<?= base_url('clients/policy');?>" class="btn btn-primary">Add Policy</a>
                        </div>
                        <div class="card-body">
                           <div class="table-responsive">
                              <table id="example3" class="display" style="min-width: 845px">
                                 <thead>
                                    <tr>
                                       <th>Company Code</th>
                                       <th>Company Name</th>
                                       <th>Policy Type</th>
                                       <th>Policy Number</th>
                                       <th>Start date</th>
                                       <th>End date</th>
                                       <th>Status</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php 
                                       $policy = $this->qm->all('ri_clientpolicy_tbl');
                                       foreach ($policy as $policy) {
                                       
                                    ?>
                                    <tr>
                                       <td><?= $policy->ccode;?></td>
                                       <td><?= $policy->cname;?></td>
                                       <td>
                                          <?php 
                                             if($policy->policy_type == 5283){

                                                echo "Data Collection";
                                             }
                                             else{

                                                $typ = $this->qm->all('ad_policy_type','*',array('policy_type_id' => $policy->policy_type));
                                                foreach($typ as $typ);
                                                echo $typ->policy_type_name;
                                             }

                                          ?>

                                       </td>
                                       <td><a href="<?= base_url('clients/clientdetail/');?><?= $policy->cid;?>/<?= $policy->id;?>" class=""><strong><?= ($policy->policy_num==5283)?'Data Collection':$policy->policy_num;?></strong></a></td>
                                       <td><?= date("d M, Y", strtotime($policy->sdate));?></td>
                                       <td><?= date("d M, Y", strtotime($policy->edate));?></td>
                                       <td><?= ($policy->status==1)?'<span class="badge light badge-success">Active</span>':'<span class="badge light badge-danger">Inactive</span>';?></td>
                                       <td>
                                          <div class="d-flex">
                                             <a href="<?= base_url('clients/editpolicy');?>/<?= $policy->id;?>" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                             <!-- <a href="#" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a> -->
                                             <a class="btn btn-danger shadow btn-xs sharp" data-toggle="tooltip" href="javascript:;"
                                                        onclick="delte('<?= $policy->id; ?>','<?= $policy->cid; ?>')"
                                                        class="dropdown-item"><i class="fa fa-trash"></i></a>
                                          </div>
                                       </td>
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

<script>
function delte(id, cid) {
   //  alert(id +" - "+ cid);
    if (confirm('do you want to delete the record?') == true) {
        window.location = "<?= base_url('clients/deleteClientPolicies/') ?>" + id + "/" + cid ;
    }
}
</script>
      