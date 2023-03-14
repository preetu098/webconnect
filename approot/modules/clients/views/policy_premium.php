<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Clients</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Policy Premium</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Policy Premium List</h4>
                        <?php if (!empty($this->session->flashdata('success'))) : ?>
                            <div class="alert alert-success alert-dismissible fade show" style="width: 25%;">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
                                <strong>Success!</strong><?= $this->session->flashdata('success'); ?>
                            </div>
                        <?php elseif (!empty($this->session->flashdata('error'))) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" style="width: 25%;">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
                                <strong>Error!</strong> <?= $this->session->flashdata('error'); ?>
                            </div>
                        <?php endif; ?>
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#add" class="btn btn-primary">Add Policy Premium</a>
                        <div class="modal fade" id="add" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form class="form-group" method="POST" action="<?php echo base_url(); ?>clients/addpremium/<?= $cid; ?>/<?= $pid; ?>">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label class="form-label">Policy Agebands</label>
                                                    <select  class="form-control" name="ageband" id="ageband">
                                                        <option value="">-select-</option>
                                                        <?php 
                                                        $age_bands = $this->qm->all('policy_agebands',"*", array('cid'=>$cid, 'pid'=>$pid));
                                                        if(!empty($age_bands)):
                                                         foreach ($age_bands as $key => $val) {?>
                                                            <option value="<?= $val->id;?>"><?= $val->min_age;?>-<?= $val->max_age;?></option>
                                                        <?php } endif; ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="form-label">Policy Suminsureds</label>
                                                    <select  class="form-control" name="suminsureds" id="suminsureds">
                                                        <option value="">-select-</option>
                                                        <?php $suminsureds = $this->qm->all('policy_suminsureds',"*", array('cid'=>$cid, 'pid'=>$pid));
                                                        if(!empty($suminsureds)):
                                                         foreach ($suminsureds as $key => $val) {?>
                                                            <option value="<?= $val->id;?>"><?= $val->suminsured;?></option>
                                                        <?php } endif; ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-12">
                                                    <label class="form-label">Policy Premium</label>
                                                    <input type="number" name="premium" class="form-control" placeholder="Premium">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Add</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example2" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Policy Premium</th>
                                        <th>Policy Ageband</th>
                                        <th>Policy Suminsured</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $s = 1;
                                    $records = $this->qm->all('policy_premium',"*", array('cid'=>$cid, 'pid'=>$pid));
                                    foreach ($records as $key => $val) {
                                    ?>
                                        <tr>
                                            <td> <?= $val->premium; ?> </td>
                                            <td> <?php
                                            $ageband = $this->qm->single("policy_agebands","*",array('id'=>$val->ageband_id,'cid'=>$cid, 'pid'=>$pid));
                                             echo $ageband->min_age.' - '.$ageband->max_age
                                             ?> </td>
                                             <td> <?php
                                            $psuminsured = $this->qm->single("policy_suminsureds","*",array('id'=>$val->suminsured_id,'cid'=>$cid, 'pid'=>$pid));
                                             echo $psuminsured->suminsured ?> </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#edit<?= $key+1; ?>" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                                    <a onclick="return confirm('Are you sure want to delete')" href="<?= base_url('clients/deletepremium'); ?>/<?= $val->cid; ?>/<?= $val->pid; ?>/<?= $val->id; ?>" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
                                            <div class="modal fade" id="edit<?= $key+1; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                    <?php $record = $this->qm->single("policy_premium","*",array('id'=>$val->id,'cid'=>$cid, 'pid'=>$pid)); ?>
                                                        <form class="form-group" method="POST" action="<?php echo base_url(); ?>clients/updpremium/<?= $cid; ?>/<?= $pid; ?>/<?= $record->id; ?>">
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                <div class="col-lg-6">
                                                                <label class="form-label">Policy Agebands</label>
                                                                <select  class="form-control" name="ageband" id="ageband">
                                                                    <option value="">-select-</option>
                                                                    <?php 
                                                                    $age_bands = $this->qm->all('policy_agebands',"*", array('cid'=>$cid, 'pid'=>$pid));
                                                                    if(!empty($age_bands)):
                                                                    foreach ($age_bands as $key => $val) {?>
                                                                        <option <?php echo ($val->id == $record->ageband_id) ? 'selected' :''; ?> value="<?= $val->id;?>"><?= $val->min_age;?>-<?= $val->max_age;?></option>
                                                                    <?php } endif; ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label class="form-label">Policy Suminsureds</label>
                                                                <select  class="form-control" name="suminsureds" id="suminsureds">
                                                                    <option value="">-select-</option>
                                                                    <?php $suminsureds = $this->qm->all('policy_suminsureds',"*", array('cid'=>$cid, 'pid'=>$pid));
                                                                    if(!empty($suminsureds)):
                                                                    foreach ($suminsureds as $key => $val) {?>
                                                                        <option value="<?= $val->id;?>" <?php echo ($val->id == $record->suminsured_id) ? 'selected' :''; ?>><?= $val->suminsured;?></option>
                                                                    <?php } endif; ?>
                                                                </select>
                                                            </div>
                                                                    <div class="col-lg-12">
                                                                        <label class="form-label">Policy premium</label>
                                                                        <input type="number" name="premium" value="<?= $record->premium?>" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
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