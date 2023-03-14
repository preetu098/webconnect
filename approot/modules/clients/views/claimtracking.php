<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Claim Tracking</h4>
            </div>
            <div class="card-body">
                <div class="basic-list-group">
                    <div class="row">
                        <!-- <div class="col-lg-6 col-xl-6">
                            <div class="list-group mb-4 " id="list-tab" role="tablist">
                                <a class="list-group-item list-group-item-action active" id="list-home-list" data-bs-toggle="list" href="#claimtracklogin" role="tab" aria-selected="true">Track your claim login</a>
                            </div>
                        </div> -->
                        <div class="col-lg-6 col-xl-6">
                            <div class="tab-content" id="nav-tabContent">

                                <div class="tab-pane fade show active" id="claimtracklogin">
                                    <h4 class="mb-4">Login User ID : <?php echo ($policy_data && !empty($policy_data->claim_track_id)) ? $policy_data->claim_track_id :'N/A'; ?></h4>
                                    <h4 class="mb-4">Login Password : <?php echo ($policy_data && !empty($policy_data->claim_track_pass)) ? $policy_data->claim_track_pass :'N/A'; ?></h4>
                                    <h4 class="mb-4">Login URL : <?php echo ($policy_data && !empty($policy_data->claim_track_url)) ? '<a target="_blank" href="'.$policy_data->claim_track_url.'">'.$policy_data->claim_track_url.'</a>' :'N/A'; ?></h4>
                                    <h4 class="mb-4">Is Publish : <span class="badge badge-<?php echo ($policy_data && !empty($policy_data->track_login_publish)) ? 'success' :'danger'; ?>"><?php echo ($policy_data && !empty($policy_data->track_login_publish)) ? 'Active' :'Inactive'; ?></span></h4>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#claimtrackloginmodal"> <i class="fas fa-pencil-alt"></i> Edit</button>
                                    <div class="modal fade" id="claimtrackloginmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form class="form-group" method="POST" action="<?php echo base_url(); ?>clients/updclaimtracking/<?php echo $cid; ?>/<?php echo $pid; ?>">
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <label class="form-label">Login User ID</label>
                                                                <input type="text" name="claim_track_id" value="<?php echo ($policy_data && !empty($policy_data->claim_track_id)) ? $policy_data->claim_track_id :''; ?>" class="form-control">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label class="form-label">Login Password</label>
                                                                <input type="text" name="claim_track_pass" value="<?php echo ($policy_data && !empty($policy_data->claim_track_pass)) ? $policy_data->claim_track_pass :''; ?>" class="form-control">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label class="form-label">Login URL</label>
                                                                <input type="url" name="claim_track_url" value="<?php echo ($policy_data && !empty($policy_data->claim_track_url)) ? $policy_data->claim_track_url :''; ?>" class="form-control">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label class="form-label">Is Publish</label>
                                                                <select class="form-control" name="track_login_publish" required>
                                                                    <option value="">Select</option>
                                                                    <option <?php echo ($policy_data && $policy_data->track_login_publish == '1') ? 'selected' :''; ?> value="1">Yes</option>
                                                                    <option <?php echo ($policy_data && $policy_data->track_login_publish == '0') ? 'selected' :''; ?> value="0">No</option>
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