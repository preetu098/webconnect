
         <div class="content-body">
            <div class="container-fluid">
               <div class="row page-titles">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item active"><a href="javascript:void(0)">Clients</a></li>
                     <li class="breadcrumb-item"><a href="javascript:void(0)">Manage Clients</a></li>
                  </ol>
               </div>
               <div class="row">
                  <div class="col-12">
                     <div class="card">
                        <div class="card-header">
                           <h4 class="card-title">Client List</h4>
                           <?php if(!empty($this->session->flashdata('success'))): ?>
                              <div class="alert alert-success alert-dismissible fade show" style="width: 25%;">
                              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
                              <strong>Success!</strong><?= $this->session->flashdata('success');?>
                           </div>
                           <?php elseif(!empty($this->session->flashdata('error'))): ?>
                              <div class="alert alert-danger alert-dismissible fade show" style="width: 25%;">
                                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
                                 <strong>Error!</strong> <?= $this->session->flashdata('error');?>
                              </div>
                           <?php endif; ?>
                        </div>
                        <div class="card-body">
                           <div class="table-responsive">
                              <table id="example2" class="display" style="min-width: 845px">
                                 <thead>
                                    <tr>
                                       <th>Company Code</th>
                                       <th>Company Name</th>
                                       <th>Phone</th>
                                       <th>Email</th>
                                       <th>Image</th>
                                       <th>Policies</th>                                       
                                       <th>Status</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php 
                                       $s = 1;
                                       $client = $this->qm->all('ri_clients_tbl');
                                       foreach ($client as $key=> $client) {
                                       
                                    ?>
                                    <tr>
                                       <td><?= $client->ccode;?></td>
                                       <td><?= $client->cname;?></td>
                                       <td><?= $client->phone;?></td>
                                       <td><?= $client->email;?></td>
                                       <td><img style="width: 100px;" src="<?= base_url('external/uploads/');?><?= $client->image;?>"/></td>
                                       <td>
                                       <?php
                                          $clientpolicies = $this->qm->all('ri_clientpolicy_tbl', '*', array('cid' => $client->cid));
                                          $count = count($clientpolicies);
                                       ?>
                                          <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#pop-<?= $key; ?>"><?= $count; ?></button>
                                          <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="pop-<?= $key; ?>" aria-hidden="true">
                                          <div class="modal-dialog modal-lg">
                                             <div class="modal-content">
                                                <div class="modal-header">
                                                   <h5 class="modal-title">Client policy</h5>
                                                   <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                   </button>
                                                </div>
                                                <div class="modal-body">

                                                   <table class="table table-responsive-sm">
                                                      <thead>
                                                         <tr>
                                                            <th>#</th>
                                                            <th>Policy Type</th>
                                                            <th>Policy Number</th>
                                                            <th>Start Date</th>
                                                            <th>End Date</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                         </tr>
                                                      </thead>
                                                      <tbody>
                                                         <?php
                                                         $e = 1;
                                                         
                                                         foreach ($clientpolicies as $cpval) {
                                                         ?>
                                                            <tr>
                                                               <th><?= $e; ?></th>
                                                               <td><?= $cpval->policy_type ?></td>
                                                               <td><?= $cpval->policy_num ?></td>
                                                               <td><?= $cpval->sdate ?></td>
                                                               <td><?= $cpval->edate ?></td>
                                                               <td class="color-primary"><?php
                                                               if ($cpval->status == 1) {
                                                                  echo '<span class="badge light badge-success light">Active</span>';
                                                               } else {
                                                                  echo '<span class="badge light badge-danger">Inactive</span>';
                                                               }
                                                               ?></td>
                                                               <td>
                                                               <div class="d-flex">
                                                                  <a href="<?= base_url('clients/clientdetail/');?><?= $cpval->cid;?>/<?= $cpval->id;?>" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-eye"></i></a>
                                                               </div>
                                                            </tr>

                                                         <?php $e++;
                                                         } ?>
                                                      </tbody>
                                                   </table>
                                                </div>

                                             </div>
                                          </div>
                                       </div>
                                       </td>
                                      
                                       <td><?= ($client->status==1)?'<span class="badge light badge-success">Active</span>':'<span class="badge light badge-danger">Inactive</span>';?></td>
                                       <td>
                                          <div class="d-flex">
                                             <!-- <a href="" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a> -->
                                            <a onclick="return confirm('Are you sure want to delete')" href="<?= base_url('clients/deleteCleint');?>/<?= $client->cid;?>" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a> 
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
      