<div class="content-body">
   <div class="container-fluid">
      <div class="row page-titles">
         <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Clients</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Tenplate Format</a></li>
         </ol>
      </div>
      <div class="row">
         <div class="col-12">
            <div class="card">
               <div class="card-header">
                  <h4 class="card-title">Template List</h4>
                  <?php
                  if (!empty($this->session->flashdata('success'))) {

                     $success = $this->session->flashdata('success');
                  ?>
                     <div class="alert alert-success alert-dismissible fade show" style="width: 25%;">

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                        </button>
                        <strong>Success!</strong><?= $success; ?>
                     </div>
                  <?php } else {
                  } ?>
                  <!-- <a href="<?= base_url('clients/policy'); ?>" class="btn btn-primary">Add Policy</a> -->
               </div>
               <div class="card-body">
                  <div class="table-responsive">
                     <table id="example3" class="display" style="min-width: 845px">
                        <thead>
                           <tr>
                              <th>Company Name</th>
                              <th>Policy Type</th>
                              <th>Endorsement Type</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           // $templates = $this->qm->all('template_format');
                           // $templates = $this->qm->groupByAll('template_format', '*', " ", array("policy_type_name", "endor_type"));
                           $templates = $this->qm->getAllWithoutWhere('template_format', '*', array("policy_type_name", "endor_type"));

                           foreach ($templates as $template) {

                           ?>
                              <tr>
                                 <td><?= $template->c_name; ?></td>
                                 <td><?= $template->policy_type_name; ?></td>
                                 <td><?= $template->endor_type; ?></td>
                                 <!--  <td><?= $template->heading_name; ?></td>
                                 <td><?= $template->map_with; ?></td> -->

                                 <td>
                                    <div class="d-flex">
                                       <a href="<?= base_url('clients/edit_template_format'); ?>/<?= $template->policy_type_id; ?>/<?= $template->endor_type; ?>" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                       <a class="btn btn-danger shadow btn-xs sharp" data-toggle="tooltip" href="javascript:;" onclick="delte('<?= $template->policy_type_id; ?>','<?= $template->endor_type; ?>')" class="dropdown-item"><i class="fa fa-trash"></i></a>
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
   function delte(policy_type_id, endor_type) {
      // alert(id);
      if (confirm('do you want to delete the record?') == true) {
         window.location = "<?= base_url('clients/delete_template/') ?>" + endor_type + '/' + policy_type_id;
      }
   }
</script>