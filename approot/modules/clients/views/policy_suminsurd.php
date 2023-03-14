<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Clients</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Policy Suminsured</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Policy Suminsured List</h4>
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
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#short_period_add" class="btn btn-primary">Add Policy Suminsured</a>
                        <div class="modal fade" id="short_period_add" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form class="form-group" method="POST" action="<?php echo base_url(); ?>clients/addsuminsurds/<?= $cid; ?>/<?= $pid; ?>">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label class="form-label">suminsured</label>
                                                    <input type="number" name="suminsured" class="form-control" placeholder="suminsured">
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
                                        <th>Policy Suminsured</th>
                                        <th>Created on</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $s = 1;
                                    $records = $this->qm->all('policy_suminsureds',"*", array('cid'=>$cid, 'pid'=>$pid));
                                    foreach ($records as $key => $val) {
                                    ?>
                                        <tr>
                                            <td> <?= $val->suminsured; ?> </td>
                                            <td> <?= $val->created_on; ?> </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#edit<?= $key+1; ?>" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                                    <a onclick="return confirm('Are you sure want to delete')" href="<?= base_url('clients/deletesuminsured'); ?>/<?= $val->cid; ?>/<?= $val->pid; ?>/<?= $val->id; ?>" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
                                            <div class="modal fade" id="edit<?= $key+1; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                    <?php $record = $this->qm->single("policy_suminsureds","*",array('id'=>$val->id,'cid'=>$cid, 'pid'=>$pid)); ?>
                                                        <form class="form-group" method="POST" action="<?php echo base_url(); ?>clients/updsuminsured/<?= $cid; ?>/<?= $pid; ?>/<?= $record->id; ?>">
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <label class="form-label">Min age</label>
                                                                        <input type="number" name="suminsured" value="<?= $record->suminsured?>" class="form-control">
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