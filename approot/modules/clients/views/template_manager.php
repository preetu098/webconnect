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
                        <h4 class="card-title">Template Manager </h4>
                        <a href="<?= base_url('Clients/template_master/'); ?><?= $cid; ?>/<?= $pid; ?>" class="btn btn-primary">Template Master</a>
                    </div>

                    <?php
                    $data = $this->qm->single("endorsment_calculations", "*", array('cid' => $cid, 'pid' => $pid));
                    $policy_info = $this->qm->single("ri_clientpolicy_tbl", "*", array('id' => $pid, 'cid' => $cid,));

                    ?>
                    <div class="card-body">
                        <div class="basic-list-group">
                            <div class="row">

                                <div class="col-lg-6 col-xl-6">
                                    <div class="tab-content" id="nav-tabContent">



                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>