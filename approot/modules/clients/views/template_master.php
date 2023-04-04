<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Clients</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Template Manager</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Template Master </h4>

                    </div>
                    <div class="col-sm-4">

                    </div>
                    <?php
                    $data = $this->qm->single("endorsment_calculations", "*", array('cid' => $cid, 'pid' => $pid));
                    $policy_info = $this->qm->single("ri_clientpolicy_tbl", "*", array('id' => $pid, 'cid' => $cid, ));

                    ?>
                    <div class="card-body">
                        <div class="basic-list-group">
                            <div class="row">

                                <div class="col-lg-6 col-xl-6">
                                    <div class="tab-content" id="nav-tabContent">


                                        <form class="form-group" method="POST"
                                            action="<?= base_url('Clients/create_master'); ?>">

                                            <div class="mb-3">
                                                <label class="form-label">
                                                    <h4>Company Name</h4>
                                                </label>
                                                <select class="form-control" name="cname" id="cname">
                                                    <option>Select Company</option>
                                                    <?php
                                                    $insurance_company = $this->qm->all('ad_crm_account', "*", array('account_type_id' => '1'));
                                                    foreach ($insurance_company as $company) {

                                                        ?>
                                                        <option value="<?= $company->account_id; ?>" <?php
                                                          if ($company->account_id == $_POST['cname']) {
                                                              echo 'selected';
                                                          }
                                                          ?>><?= $company->account_name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <h4 class="mb-4">SELECT Policy Type :

                                                <select class="form-control" name="policy_type" id="type" required>
                                                    <option>Select Type</option>
                                                    <option value="5283">Data Collection</option>
                                                    <?php

                                                    $newd = $this->qm->all2("ad_policy_type", "*", array('policy_dept_id' => '7'));

                                                    foreach ($newd as $typ) {
                                                        ?>
                                                        <option value="<?= $typ->policy_type_id; ?>" <?php
                                                          if ($typ->policy_type_id == $_POST['policy_type']) {
                                                              echo 'selected';
                                                          }
                                                          ?>><?= $typ->policy_type_name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </h4>
                                            <h4 class="mb-4">SELECT Endorsement Type :
                                                <select name="endorsement_type" id="endorsement_type"
                                                    class="form-select form-control" required>
                                                    <option value="">-Select-</option>
                                                    <option value="addition_deletion" <?php
                                                    if ($_POST['endorsement_type'] == "addition_deletion") {
                                                        echo 'selected';
                                                    }
                                                    ?>>Addition & Deletion</option>
                                                    <option value="addition" <?php
                                                    if ($_POST['endorsement_type'] == "addition") {
                                                        echo 'selected';
                                                    }
                                                    ?>>Addition</option>
                                                    <option value="deletion" <?php
                                                    if ($_POST['endorsement_type'] == "deletion") {
                                                        echo 'selected';
                                                    }
                                                    ?>>Deletion</option>
                                                    <option value="correction" <?php
                                                    if ($_POST['endorsement_type'] == "correction") {
                                                        echo 'selected';
                                                    }
                                                    ?>>Correction</option>
                                                </select>
                                            </h4>
                                            <button class="btn btn-primary">Create Master</button>


                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive d-flex justify-content-center">

                                    <?php
                                    $template = $this->qm->all("template_master", "*", array());

                                    if ((count($template) > 0)) {

                                        ?>
                                        <table id="example2" class="table table-bordered table-stripped" style="min-width: 845px">

                                            <tbody>
                                                <?php

                                                foreach ($template as $key => $template) {
                                                    $newd = $this->qm->single("ad_policy_type", "*", array('policy_type_id' => $template->policy_type, 'policy_dept_id' => '7'));
                                                    $insurance_company = $this->qm->single('ad_crm_account', "*", array('account_id' => $template->company_id, 'account_type_id' => '1'));
                                                   
                                                    ?>
                                                    
                                                        <tr>
                                                            <td><?php echo $insurance_company->account_name?></td>
                                                            <td><?php echo $newd->policy_type_name?></td>
                                                            <td><?php echo $template->endorsement_type?></td>
                                                            <td><?php echo $template->company?></td>
                                                            <td><?php echo $template->member?></td>
                                                            <td><?php echo $template->age?></td>
                                                            <td><?php echo $template->si?></td>
                                                            <td><?php echo $template->mode;?></td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                   
                                                </tbody>
                                            </table>
                                            <?php
                                               
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>