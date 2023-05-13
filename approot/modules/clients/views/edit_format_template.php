<div class="content-body">
   <div class="container-fluid">
      <div class="row page-titles">
         <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Clients</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Edit Format Template</a></li>



         </ol>
      </div>
      <div class="row">

         <div class="col-xl-12 col-lg-12">
            <div class="card">
               <div class="card-header">
                  <h4 class="card-title">Edit</h4>
                  <?php

                  if (!empty($this->session->flashdata('error'))) {
                     $error = $this->session->flashdata('error');
                  ?>
                     <div class="alert alert-danger alert-dismissible fade show" style="width: 25%;">

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                        </button>
                        <strong>Error!</strong> <?= $error; ?>
                     </div>
                  <?php } else { ?>
                     <div class="alert alert-success alert-dismissible fade show" style="width: 25%;">

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                        </button>
                        <strong>Success!</strong><?= $success; ?>
                     </div>
                  <?php
                  } ?>
               </div>
               <div class="card-body">
                  <div class="basic-form">
                     <form method="POST" action="<?= base_url('clients/update_format'); ?>/<?= $policy_typ; ?>/<?= $endor_type; ?>" enctype="multipart/form-data">
                        <?php
                        $eidtFormat = $this->qm->all("template_format", "*", array('policy_type_id' => $policy_typ, 'endor_type' => $endor_type));
                        foreach ($eidtFormat as $index => $format) {
                        ?>
                           <?php if ($index == 0) { ?>
                              <div class="row">
                                 <div class="mb-3 col-md-4">
                                    <label class="form-label">Insurance Company</label>
                                    <input type="text" class="form-control" readonly value="<?php echo $format->c_name; ?>">
                                 </div>
                                 <div class="mb-3 col-md-4">
                                    <label class="form-label">Policy Type</label>
                                    <input type="text" class="form-control" readonly value="<?php echo $format->policy_type_name; ?>">
                                 </div>
                                 <div class="mb-3 col-md-4">
                                    <label class="form-label">Endorsement Type </label>
                                    <input type="text" class="form-control" readonly value="<?php echo $format->endor_type; ?>">
                                 </div>
                              </div>
                           <?php } ?>

                           <div class="row">
                              <input type="hidden" name="id[]" value="<?php echo $format->id; ?>">
                              <div class="mb-3 col-md-2">
                                 <?php if ($index == 0) { ?> <label class="form-label"> Column Heading Name</label> <?php } ?>
                                 <input type=" text" class="form-control" name="heading_name[]" value="<?php echo $format->heading_name; ?>" required>
                              </div>
                              <div class="mb-3 col-md-2">
                                 <?php if ($index == 0) { ?> <label class="form-label">Mapped with</label> <?php } ?>
                                 <select class="form-control searchfield" name="mapped_field[]" required>
                                    <option value="">Select Field</option>
                                    <?php
                                    $emp = $this->qm->all('ri_employee_tbl', '*', array('cid' => 12, 'pid' => 14));
                                    foreach ($emp[0] as $key => $emps) {
                                    ?>
                                       <option <?= ($format->map_with == $key) ? 'selected' : ''; ?> value="<?php echo $key ?>"><?php echo $key; ?></option>
                                    <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                              <div class="mb-3 col-md-2">
                                 <?php if ($index == 0) { ?> <label class="form-label">Font Style</label> <?php } ?>
                                 <select class="form-control =" name="font_style[]" require>
                                    <option value="">Select Font</option>
                                    <option <?= ($format->font_style == "Arial") ? 'selected' : ''; ?> value="Arial">Arial</option>
                                    <option <?= ($format->font_style == "Verdana") ? 'selected' : ''; ?> value="Verdana">Verdana</option>
                                    <option <?= ($format->font_style == "Trebuchet MS") ? 'selected' : ''; ?> value="Trebuchet MS">Trebuchet MS</option>
                                    <option <?= ($format->font_style == "Times New Roman") ? 'selected' : ''; ?> value="Times New Roman">Times New Roman</option>
                                    <option <?= ($format->font_style == "Georgia") ? 'selected' : ''; ?> value="Georgia">Georgia</option>
                                    <option <?= ($format->font_style == "Garamond") ? 'selected' : ''; ?> value="Garamond">Garamond</option>
                                    <option <?= ($format->font_style == "Courier New") ? 'selected' : ''; ?> value="Courier New">Courier New</option>
                                    <option <?= ($format->font_style == "Brush Script MT") ? 'selected' : ''; ?> value="Brush Script MT">Brush Script MT</option>
                                 </select>
                              </div>
                              <div class="mb-1 col-md-1 ">
                                 <?php if ($index == 0) { ?><label class="form-label">Font Color</label><?php } ?>
                                 <input type="color" name="font_color[]" class="form-control" value="<?php echo $format->font_color; ?>" require>
                              </div>
                              <div class="mb-3 col-md-1">
                                 <?php if ($index == 0) { ?> <label class="form-label">Font Size</label><?php } ?>
                                 <select class="form-control selectSize" name="font_size[]" require>
                                    <option value="">Size</option>
                                    <?php
                                    for ($i = 0; $i < 50; $i++) {
                                       if ($i % 2 == 0) {
                                    ?>
                                          <option <?= ($format->font_size == $i) ? 'selected' : ''; ?> value="<?php echo $i ?>"><?php echo $i; ?></option>
                                    <?php
                                       }
                                    }
                                    ?>
                                 </select>

                              </div>
                              <div class="mb-1 col-md-1 ">
                                 <?php if ($index == 0) { ?> <label class="form-label">Cell Fill Color</label><?php } ?>
                                 <input type="color" name="cell_fill_col[]" class="form-control" value="<?php echo $format->cell_fill_col; ?>" require>
                              </div>
                              <div class="mb-3 col-md-2 ">
                                 <?php if ($index == 0) { ?><label class="form-label">Modification</label><?php } ?>
                                 <input type="text" class="form-control" name="modific[]" value="<?php echo $format->modification; ?>" require>
                              </div>
                           </div>
                           <a data-toggle="tooltip" href="javascript:;" onclick="delte('<?= $format->id; ?>')"> <i class=" fa fa-trash" aria-hidden="true"></i></a>
                        <?php
                        }
                        ?>
                        <div class="row">
                           <div class="mb-3 col-md-2">
                              <button type="submit" class="btn btn-primary">Update Policy</button>
                           </div>
                        </div>
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

   function delte(id) {
      // alert(id);
      if (confirm('do you want to delete the record?') == true) {
         window.location = "<?= base_url('clients/single_delete_template/') ?>" + id;
      }
   }
</script>