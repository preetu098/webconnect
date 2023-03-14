<div class="content-body">
   <div class="container-fluid">
      <div class="row page-titles">
         <ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Client</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Dependents</a></li>
         </ol>
      </div>

      <div class="row">
         <div class="col-xl-12">
            <div class="card">
               <div class="card-header d-block">
                  <h4 class="card-title">Dependents</h4>
                  <?php
                  if (!empty($this->session->flashdata('succes'))) {

                     $succes = $this->session->flashdata('succes');
                  ?>
                     <div class="alert alert-success alert-dismissible fade show" style="width: 50%;float: right;margin-top: -35px;">

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                        </button>
                        <strong>Success!</strong><?= $succes; ?>
                     </div>
                  <?php } else if (!empty($this->session->flashdata('err'))) {
                     $err = $this->session->flashdata('err');
                  ?>
                     <div class="alert alert-danger alert-dismissible fade show" style="width: 50%;float: right;margin-top: -35px;">

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                        </button>
                        <strong>Error!</strong> <?= $err; ?>
                     </div>
                  <?php } else {
                  } ?>
               </div>
               <div class="card-body">




                  <?php
                  $s = 1;
                  $rel = $this->qm->all('fm_relation_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'is_publish' => 1));
                  foreach ($rel as $rel) {

                     $max = $rel->max_entry;
                     for ($i = 0; $i < $max; $i++, $s++) {

                  ?>
                        <div class="accordion accordion-with-icon" id="accordion-six<?= $s; ?>">
                           <div class="accordion-item">
                              <div class="accordion-header rounded-lg collapsed" id="accord-6One<?= $s; ?>" data-bs-toggle="collapse" data-bs-target="#collapse6One<?= $s; ?>" aria-controls="collapse6One<?= $s; ?>" aria-expanded="false" role="button">
                                 <?php
                                 if ($rel->reltype == 'Self') {
                                    echo '<i class="las la-user" style="font-size: 20px;"></i>';
                                 } else if ($rel->reltype == 'Spouse') {
                                    echo '<i class="las la-female" style="font-size: 20px;"></i>';
                                 } else if ($rel->reltype == 'Kid') {
                                    echo '<i class="las la-baby" style="font-size: 20px;"></i>';
                                 } else if ($rel->reltype == 'Father') {
                                    echo '<i class="las la-male" style="font-size: 20px;"></i>';
                                 } else if ($rel->reltype == 'Mother') {
                                    echo '<i class="las la-female" style="font-size: 20px;"></i>';
                                 } else if ($rel->reltype == 'Father In Law') {
                                    echo '<i class="las la-male" style="font-size: 20px;"></i>';
                                 } else if ($rel->reltype == 'Mother In Law') {
                                    echo '<i class="las la-female" style="font-size: 20px;"></i>';
                                 }
                                 ?>

                                 <span class="accordion-header-text"><?= $rel->reltype; ?></span>
                                 <span class="accordion-header-indicator"></span>
                              </div>
                              <div id="collapse6One<?= $s; ?>" class="accordion__body collapse" aria-labelledby="accord-6One<?= $s; ?>" data-bs-parent="#accordion-six<?= $s; ?>" style="">
                                 <div class="accordion-body-text">
                                    <?php
                                    $data['cid'] = $cid;
                                    $data['pid'] = $pid;
                                    $data['eid'] = $eid;
                                    $data['rel'] = $rel->reltype . $i;
                                    if ($rel->reltype == 'Self') {
                                       $this->load->view('user/self', $data);
                                    } else if ($rel->reltype == 'Spouse') {
                                       $this->load->view('user/spouse', $data);
                                    } else if ($rel->reltype == 'Kid') {
                                       $this->load->view('user/kid', $data);
                                    } else if ($rel->reltype == 'Father') {
                                       $this->load->view('user/father', $data);
                                    } else if ($rel->reltype == 'Mother') {
                                       $this->load->view('user/mother', $data);
                                    } else if ($rel->reltype == 'Father In Law') {
                                       $this->load->view('user/fatherinlaw', $data);
                                    } else if ($rel->reltype == 'Mother In Law') {
                                       $this->load->view('user/motherinlaw', $data);
                                    } else {
                                       echo "Some Error Occurred";
                                    }
                                    ?>
                                 </div>
                              </div>
                           </div>


                        </div>

                  <?php }
                  } ?>
               </div>
            </div>
         </div>


      </div>
   </div>
</div>
</div>