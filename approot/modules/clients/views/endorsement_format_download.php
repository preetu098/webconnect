<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Clients</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Endorsement Calculations </a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Endorsement Download</h4>
                    </div>
                   
                    <div class="card-body">
                    <div class="row">

<div class="col-lg-6 col-xl-6">
    <div class="tab-content" id="nav-tabContent">
        <form class="form-group" method="POST"
            action="<?= base_url('Clients/download_endorsement'); ?>/<?= $cid; ?>/<?= $pid; ?>">

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
            <button class="btn btn-primary">Download Endorsement</button>


        </form>
    </div>
</div>
</div>
                    </div>
                </div>
            </div>
        </div>

    </div>