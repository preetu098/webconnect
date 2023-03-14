<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Endorsment Calculations</h4>
            </div>
            <div class="card-body">
                <div class="basic-list-group">
                    <div class="row">
                        <div class="col-lg-6 col-xl-6">
                            <div class="list-group mb-4 " id="list-tab" role="tablist">
                                <a class="list-group-item list-group-item-action active" id="tb3" data-bs-toggle="list" href="#premiumcontnet" role="tab" aria-selected="true">Setup Premium</a>
                                <a class="list-group-item list-group-item-action" id="tb1" data-bs-toggle="list" href="#gsttbcontnet" role="tab" aria-selected="true">Setup GST</a>
                                <a class="list-group-item list-group-item-action " id="tb2" data-bs-toggle="list" href="#tb2cnt" role="tab" aria-selected="true">Select the basis of calculations</a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-6">
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show" id="gsttbcontnet">
                                    <form class="form-group" method="POST" action="<?php echo base_url(); ?>clients/endorsmentCalculation/<?php echo $cid; ?>/<?php echo $pid; ?>">
                                        <h4 class="mb-4">GST :
                                            <select name="gst" id="gst" class="form-select form-control">
                                                <option value="0" <?= ($endorscalc->gst == '0') ? 'selected' : ''; ?>>No
                                                </option>
                                                <option value="1" <?= ($endorscalc->gst == '1') ? 'selected' : ''; ?>>
                                                    Yes</option>
                                            </select>
                                        </h4>
                                        <h4>GST Rate :
                                            <input type="text" name="gst_rate" id="gst_rate" class="form-text form-control" placeholder="GST Rate" value="<?= $endorscalc->gst_rate; ?>">
                                        </h4>
                                        <input type="hidden" name="tab" value="gst_tab">
                                        <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#claimssumdatemodal"> <i class="fas fa-pencil-alt"></i>
                                            Update</button>
                                    </form>
                                </div>
                                <div class="tab-pane fade show" id="tb2cnt">
                                    <form class="form-group" method="POST" action="<?php echo base_url(); ?>clients/endorsmentCalculation/<?php echo $cid; ?>/<?php echo $pid; ?>">
                                        <h4 class="mb-4">SELECT THE BASIS OF CALCULATIONS :
                                            <select name="basis_of_calculation" id="basis_of_calculation" class="form-select form-control" required <?= $endorscalc->basis_of_calculation; ?>>
                                                <option value="">-Select-</option>
                                                <option value="pro_rata_basis" <?= ($endorscalc->basis_of_calculation == 'pro_rata_basis') ? 'selected' : ''; ?>>
                                                    PRO RATA BASIS</option>
                                                <option value="short_period_scale" <?= ($endorscalc->basis_of_calculation == 'short_period_scale') ? 'selected' : ''; ?>>
                                                    SHORT PERIOD SCALE</option>
                                            </select>
                                        </h4>
                                        <h4>Backdation days :
                                            <input type="number" name="backdation_days" id="backdation_days" class="form-text form-control" placeholder="Backdation days" value="<?= $endorscalc->backdation_days; ?>">
                                        </h4>
                                        <h4>Start Date :
                                            <input type="date" name="sdate" id="sdate" class="form-text form-control" placeholder="Start Date" value="<?= $policy_data->sdate; ?>">
                                        </h4>
                                        <h4>End Date :
                                            <input type="date" name="edate" id="edate" class="form-text form-control" placeholder="End Date" value="<?= $policy_data->edate; ?>">
                                        </h4>
                                        <input type="hidden" name="tab" value="basis_calc_tab">
                                        <div class="publish_unpublish">
                                            <h4> Publish/Unpublish:</h4>
                                            <h4><label class="switch">
                                                    <input type="hidden" name="status" value="0">
                                                    <input type="checkbox" name="status" checked value="1">
                                                    <span class="slider round"></span>
                                                </label></h4>
                                        </div>
                                        <button type="submit" class="btn btn-primary"> <i class="fas fa-pencil-alt"></i>
                                            Update</button>
                                        <span id="showpopupbtn"></span>
                                    </form>
                                </div>
                                <div class="tab-pane fade show active" id="premiumcontnet">
                                    <a href="<?php echo base_url('clients/policyagebands/' . $cid . '/' . $pid); ?>" class="btn btn-primary" target="_blank">Policy Agebands</a>
                                    <a href="<?php echo base_url('clients/policysuminsurds/' . $cid . '/' . $pid); ?>" class="btn btn-primary" target="_blank">Policy SumInsureds</a>
                                    <a href="<?php echo base_url('clients/policypremium/' . $cid . '/' . $pid); ?>" class="btn btn-primary" target="_blank">Policy Premium</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Age Band</h4>
                <div class="reload">
                    <button type="button" id="btn-open-endclc" onclick="getForm(this.value, <?= $cid; ?>, <?= $pid; ?>)" class="btn btn-info" value="12">
                        <!-- Reload -->
                        <i class="fa fa-retweet"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive d-flex justify-content-center">
                    <table id="example2" class="display table table-bordered" style="min-width: 845px">
                        <thead>
                            <tr>
                                <th>SumInsured</th>
                                <?php
                                $ageband = $this->qm->all("policy_agebands", "*", array('cid' => $cid, 'pid' => $pid), '', 'both', '', 'min_age');
                                foreach ($ageband as $key => $val) {
                                ?>
                                    <th><?php echo $val->min_age . " - " . $val->max_age; ?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $psuminsured = $this->qm->all("policy_suminsureds", "*", array('cid' => $cid, 'pid' => $pid), '', 'both', '', 'suminsured');
                            foreach ($psuminsured as $key => $psuminsuredVal) { ?>
                                <tr>
                                    <td> <?php echo $psuminsuredVal->suminsured; ?> </td>
                                    <?php foreach ($ageband as $key => $agebandVal) { ?>
                                        <td> <?php
                                                $premium = $this->qm->single("policy_premium", "*", array('suminsured_id' => $psuminsuredVal->id, 'ageband_id' => $agebandVal->id, 'cid' => $cid, 'pid' => $pid));
                                                if ($premium->premium  == '')
                                                    echo "N/A";
                                                echo $premium->premium; ?> </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#basis_of_calculation").change(function() {
            if ($(this).val() == 'short_period_scale') {
                $("#showpopupbtn").html(
                    "<a href='<?= base_url('clients/shortperiodscale/' . $cid . '/' . $pid) ?>' class='btn btn-primary' target='_blank'>Short period scale</a>"
                );
            } else if ($(this).val() == 'pro_rata_basis') {
                $("#showpopupbtn").html("");
            }
        });
        $("#basis_of_calculation").change();
    });
</script>