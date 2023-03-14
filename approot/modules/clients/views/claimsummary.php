<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Claim Summary</h4>
            </div>
            <div class="card-body">
                <div class="basic-list-group">
                    <div class="row">
                        <div class="col-lg-6 col-xl-6">
                            <div class="list-group mb-4 " id="list-tab" role="tablist">

                                <a class="list-group-item list-group-item-action active" id="list-home-list" data-bs-toggle="list" href="#claimssumdate" role="tab" aria-selected="true">Claims summary as on date</a>

                                <a class="list-group-item list-group-item-action " id="list-home-list" data-bs-toggle="list" href="#claimsicr" role="tab" aria-selected="true">Claims ICR%</a>

                                <a class="list-group-item list-group-item-action " id="list-home-list" data-bs-toggle="list" href="#incurredclaims" role="tab" aria-selected="true">Incurred claims</a>

                                <a class="list-group-item list-group-item-action " id="list-home-list" data-bs-toggle="list" href="#settledclaims" role="tab" aria-selected="true">Settled claims</a>

                                <a class="list-group-item list-group-item-action " id="list-home-list" data-bs-toggle="list" href="#reimbursementclaims" role="tab" aria-selected="true">Reimbursement claims</a>

                                <a class="list-group-item list-group-item-action " id="list-home-list" data-bs-toggle="list" href="#cashlessclaims" role="tab" aria-selected="true">Cashless claims</a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-6">
                            <div class="tab-content" id="nav-tabContent">

                                <div class="tab-pane fade show active" id="claimssumdate">
                                    <h4 class="mb-4">Claims summary as on date : <?php echo ($policy_data && !empty($policy_data->claim_summary_date)) ? date('d M, Y',strtotime($policy_data->claim_summary_date)) :'N/A'; ?></h4>
                                    <h4 class="mb-4">Is Publish : <span class="badge badge-<?php echo ($policy_data && !empty($policy_data->date_is_publish)) ? 'success' :'danger'; ?>"><?php echo ($policy_data && !empty($policy_data->date_is_publish)) ? 'Active' :'Inactive'; ?></span></h4>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#claimssumdatemodal"> <i class="fas fa-pencil-alt"></i> Edit</button>
                                    <div class="modal fade" id="claimssumdatemodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form class="form-group" method="POST" action="<?php echo base_url(); ?>clients/updclaimsummary/<?php echo $cid; ?>/<?php echo $pid; ?>">
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <label class="form-label">Claims summary as on date</label>
                                                                <input type="date" name="claim_summary_date" value="<?php echo ($policy_data && !empty($policy_data->claim_summary_date)) ? date('Y-m-d',strtotime($policy_data->claim_summary_date)) :''; ?>" class="form-control">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label class="form-label">Is Publish</label>
                                                                <select class="form-control" name="date_is_publish" required>
                                                                    <option value="">Select</option>
                                                                    <option <?php echo ($policy_data && $policy_data->date_is_publish == '1') ? 'selected' :''; ?> value="1">Yes</option>
                                                                    <option <?php echo ($policy_data && $policy_data->date_is_publish == '0') ? 'selected' :''; ?> value="0">No</option>
                                                                </select>
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
                                </div>

                                <div class="tab-pane fade show" id="claimsicr">
                                    <h4 class="mb-4">Claims ICR% : <?php echo ($policy_data && !empty($policy_data->claim_summary_icr)) ? $policy_data->claim_summary_icr.'%' :'N/A'; ?></h4>
                                    <h4 class="mb-4">Is Publish : <span class="badge badge-<?php echo ($policy_data && !empty($policy_data->icr_is_publish)) ? 'success' :'danger'; ?>"><?php echo ($policy_data && !empty($policy_data->icr_is_publish)) ? 'Active' :'Inactive'; ?></span></h4>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#claimsicrmodal"> <i class="fas fa-pencil-alt"></i> Edit</button>
                                    <div class="modal fade" id="claimsicrmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form class="form-group" method="POST" action="<?php echo base_url(); ?>clients/updclaimsummary/<?php echo $cid; ?>/<?php echo $pid; ?>">
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <label class="form-label">Claims ICR%</label>
                                                                <input type="number" name="claim_summary_icr" value="<?php echo ($policy_data && !empty($policy_data->claim_summary_icr)) ? $policy_data->claim_summary_icr :''; ?>" class="form-control">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label class="form-label">Is Publish</label>
                                                                <select class="form-control" name="icr_is_publish" required>
                                                                    <option value="">Select</option>
                                                                    <option <?php echo ($policy_data && $policy_data->icr_is_publish == '1') ? 'selected' :''; ?> value="1">Yes</option>
                                                                    <option <?php echo ($policy_data && $policy_data->icr_is_publish == '0') ? 'selected' :''; ?> value="0">No</option>
                                                                </select>
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
                                </div>

                                <div class="tab-pane fade show" id="incurredclaims">
                                    <h4 class="mb-4">Total no. of incurred claims : <?php echo ($policy_data && !empty($policy_data->claim_summary_noincl)) ? $policy_data->claim_summary_noincl :'N/A'; ?></h4>
                                    <h4 class="mb-4">Amount of incurred claims : <?php echo ($policy_data && !empty($policy_data->claim_summary_amincl)) ? $policy_data->claim_summary_amincl :'N/A'; ?></h4>
                                    <h4 class="mb-4">Is Publish : <span class="badge badge-<?php echo ($policy_data && !empty($policy_data->amincl_is_publish)) ? 'success' :'danger'; ?>"><?php echo ($policy_data && !empty($policy_data->amincl_is_publish)) ? 'Active' :'Inactive'; ?></span></h4>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#incurredclaimsmodal"> <i class="fas fa-pencil-alt"></i> Edit</button>
                                    <div class="modal fade" id="incurredclaimsmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form class="form-group" method="POST" action="<?php echo base_url(); ?>clients/updclaimsummary/<?php echo $cid; ?>/<?php echo $pid; ?>">
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <label class="form-label">Total no. of incurred claims</label>
                                                                <input type="number" name="claim_summary_noincl" value="<?php echo ($policy_data && !empty($policy_data->claim_summary_noincl)) ? $policy_data->claim_summary_noincl :''; ?>" class="form-control">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label class="form-label">Amount of incurred claims</label>
                                                                <input type="number" name="claim_summary_amincl" value="<?php echo ($policy_data && !empty($policy_data->claim_summary_amincl)) ? $policy_data->claim_summary_amincl :''; ?>" class="form-control">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label class="form-label">Is Publish</label>
                                                                <select class="form-control" name="amincl_is_publish" required>
                                                                    <option value="">Select</option>
                                                                    <option <?php echo ($policy_data && $policy_data->amincl_is_publish == '1') ? 'selected' :''; ?> value="1">Yes</option>
                                                                    <option <?php echo ($policy_data && $policy_data->amincl_is_publish == '0') ? 'selected' :''; ?> value="0">No</option>
                                                                </select>
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
                                </div>

                                <div class="tab-pane fade show" id="settledclaims">
                                    <h4 class="mb-4">No. of settled claims : <?php echo ($policy_data && !empty($policy_data->claim_summary_nosetcl)) ? $policy_data->claim_summary_nosetcl :'N/A'; ?></h4>
                                    <h4 class="mb-4">Amount of settled claims : <?php echo ($policy_data && !empty($policy_data->claim_summary_amsetcl)) ? $policy_data->claim_summary_amsetcl :'N/A'; ?></h4>
                                    <h4 class="mb-4">Is Publish : <span class="badge badge-<?php echo ($policy_data && !empty($policy_data->amsetcl_is_publish)) ? 'success' :'danger'; ?>"><?php echo ($policy_data && !empty($policy_data->amsetcl_is_publish)) ? 'Active' :'Inactive'; ?></span></h4>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#settledclaimsmodal"> <i class="fas fa-pencil-alt"></i> Edit</button>
                                    <div class="modal fade" id="settledclaimsmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form class="form-group" method="POST" action="<?php echo base_url(); ?>clients/updclaimsummary/<?php echo $cid; ?>/<?php echo $pid; ?>">
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <label class="form-label">No. of settled claims</label>
                                                                <input type="number" name="claim_summary_nosetcl" value="<?php echo ($policy_data && !empty($policy_data->claim_summary_nosetcl)) ? $policy_data->claim_summary_nosetcl :''; ?>" class="form-control">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label class="form-label">Amount of settled claims</label>
                                                                <input type="number" name="claim_summary_amsetcl" value="<?php echo ($policy_data && !empty($policy_data->claim_summary_amsetcl)) ? $policy_data->claim_summary_amsetcl :''; ?>" class="form-control">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label class="form-label">Is Publish</label>
                                                                <select class="form-control" name="amsetcl_is_publish" required>
                                                                    <option value="">Select</option>
                                                                    <option <?php echo ($policy_data && $policy_data->amsetcl_is_publish == '1') ? 'selected' :''; ?> value="1">Yes</option>
                                                                    <option <?php echo ($policy_data && $policy_data->amsetcl_is_publish == '0') ? 'selected' :''; ?> value="0">No</option>
                                                                </select>
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
                                </div>

                                <div class="tab-pane fade show" id="reimbursementclaims">
                                    <h4 class="mb-4">No. of outstanding reimbursement claims : <?php echo ($policy_data && !empty($policy_data->claim_summary_norecl)) ? $policy_data->claim_summary_norecl :'N/A'; ?></h4>
                                    <h4 class="mb-4">Amount of outstanding reimbursement claims : <?php echo ($policy_data && !empty($policy_data->claim_summary_amrecl)) ? $policy_data->claim_summary_amrecl :'N/A'; ?></h4>
                                    <h4 class="mb-4">Is Publish : <span class="badge badge-<?php echo ($policy_data && !empty($policy_data->amrecl_is_publish)) ? 'success' :'danger'; ?>"><?php echo ($policy_data && !empty($policy_data->amrecl_is_publish)) ? 'Active' :'Inactive'; ?></span></h4>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reimbursementclaimsmodal"> <i class="fas fa-pencil-alt"></i> Edit</button>
                                    <div class="modal fade" id="reimbursementclaimsmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form class="form-group" method="POST" action="<?php echo base_url(); ?>clients/updclaimsummary/<?php echo $cid; ?>/<?php echo $pid; ?>">
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <label class="form-label">No. of outstanding reimbursement claims</label>
                                                                <input type="number" name="claim_summary_norecl" value="<?php echo ($policy_data && !empty($policy_data->claim_summary_norecl)) ? $policy_data->claim_summary_norecl :''; ?>" class="form-control">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label class="form-label">Amount of outstanding reimbursement claims</label>
                                                                <input type="number" name="claim_summary_amrecl" value="<?php echo ($policy_data && !empty($policy_data->claim_summary_amrecl)) ? $policy_data->claim_summary_amrecl :''; ?>" class="form-control">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label class="form-label">Is Publish</label>
                                                                <select class="form-control" name="amrecl_is_publish" required>
                                                                    <option value="">Select</option>
                                                                    <option <?php echo ($policy_data && $policy_data->amrecl_is_publish == '1') ? 'selected' :''; ?> value="1">Yes</option>
                                                                    <option <?php echo ($policy_data && $policy_data->amrecl_is_publish == '0') ? 'selected' :''; ?> value="0">No</option>
                                                                </select>
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
                                </div>

                                <div class="tab-pane fade show" id="cashlessclaims">
                                    <h4 class="mb-4">No. of outstanding cashless claims : <?php echo ($policy_data && !empty($policy_data->claim_summary_nocacl)) ? $policy_data->claim_summary_nocacl :'N/A'; ?></h4>
                                    <h4 class="mb-4">Amount of outstanding cashless claims : <?php echo ($policy_data && !empty($policy_data->claim_summary_amcacl)) ? $policy_data->claim_summary_amcacl :'N/A'; ?></h4>
                                    <h4 class="mb-4">Is Publish : <span class="badge badge-<?php echo ($policy_data && !empty($policy_data->amcacl_is_publish)) ? 'success' :'danger'; ?>"><?php echo ($policy_data && !empty($policy_data->amcacl_is_publish)) ? 'Active' :'Inactive'; ?></span></h4>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cashlessclaimsmodal"> <i class="fas fa-pencil-alt"></i> Edit</button>
                                    <div class="modal fade" id="cashlessclaimsmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form class="form-group" method="POST" action="<?php echo base_url(); ?>clients/updclaimsummary/<?php echo $cid; ?>/<?php echo $pid; ?>">
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <label class="form-label">Total no. of cashless claims</label>
                                                                <input type="number" name="claim_summary_nocacl" value="<?php echo ($policy_data && !empty($policy_data->claim_summary_nocacl)) ? $policy_data->claim_summary_nocacl :''; ?>" class="form-control">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label class="form-label">Total amount of cashless claims</label>
                                                                <input type="number" name="claim_summary_amcacl" value="<?php echo ($policy_data && !empty($policy_data->claim_summary_amcacl)) ? $policy_data->claim_summary_amcacl :''; ?>" class="form-control">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label class="form-label">Is Publish</label>
                                                                <select class="form-control" name="amcacl_is_publish" required>
                                                                    <option value="">Select</option>
                                                                    <option <?php echo ($policy_data && $policy_data->amcacl_is_publish == '1') ? 'selected' :''; ?> value="1">Yes</option>
                                                                    <option <?php echo ($policy_data && $policy_data->amcacl_is_publish == '0') ? 'selected' :''; ?> value="0">No</option>
                                                                </select>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>