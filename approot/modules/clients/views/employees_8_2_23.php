<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <!--<li class="breadcrumb-item active"><a href="javascript:void(0)">Clients</a></li>
                     <li class="breadcrumb-item"><a href="javascript:void(0)">Employees</a></li>-->
            </ol>

            <?php
         $spouse = $parents = $kid = $inlaw =  0;
         $rest = $this->qm->all("ri_employee_tbl", "*", array('cid' => $cid, 'pid' => $pid));
         foreach ($rest as $res) {
            $depp = $this->qm->all("ri_dependent_tbl", "*", array('cid' => $cid, 'pid' => $pid, 'eid' => $res->eid));
            foreach ($depp as $dt) {
               //echo $dt->reltype;
               if ($dt->reltype == 'Spouse') {
                  $spouse = $spouse + 1;
               }
               if (($dt->reltype == 'Father' || $dt->reltype == 'Mother')) {
                  $parents = $parents + 1;
               }
               if ($dt->reltype == 'Kid') {
                  $kid = $kid + 1;
               }
               if ($dt->reltype == 'Father In Law' || $dt->reltype == 'Mother In Law') {
                  $inlaw = $inlaw + 1;
               }
            }
         }
         ?>
            <h4 class="ttl-emplye-dymic-velue">
                TOTAL EMPLOYEE: <span class="badge badge-primary light"><?= count($rest); ?></span>
                <?php
            $aaa = $this->qm->all("fm_relation_tbl", "*", array('cid' => $cid, 'pid' => $pid, 'is_publish' => 1));
            foreach ($aaa as $row) {
               if ($row->reltype == 'Spouse') {
            ?> |
                SPOUSE: <span class="badge badge-primary light"><?= $spouse; ?></span> |
                <?php }
               if ($row->reltype == 'Kid') { ?>
                KIDs: <span class="badge badge-primary light"><?= $kid; ?></span> |
                <?php }
               if ($row->reltype == 'Mother' || ($row->reltype == 'Father')) { ?>
                PARENTS: <span class="badge badge-primary light"><?= $parents; ?></span>
                <?php }
               if ($row->reltype == 'Mother In Law' || ($row->reltype == 'Father In Law')) { ?>|
                PARENTS In LAWS: <span class="badge badge-primary light"><?= $inlaw; ?></span> |
                <?php }
            } ?></span>
                TOTAL LIVES: <span
                    class="badge badge-primary light"><?= count($rest) + $spouse + $kid + $parents + $inlaw; ?></span>
        </div>

        <div class="row page-titles">
            <div class="col-xl-5 col-sm-12">
                <h3>Manage Employees</h3>
            </div>
            <div class="col-xl-7 col-sm-12">
                <form method="post">
                    <table class="table emplyee-filtr-bx" style="margin: 0;">
                        <tr>
                            <td><input type="text" name="empid" style="width: 250px;"
                                    value="<?= (isset($_POST['empid'])) ? $_POST['empid'] : ''; ?>"
                                    placeholder="multiple email ids eg: 1,2,3" class="form-control inpt_field" /></td>
                            <td><input type="text" name="emp_name"
                                    value="<?= (isset($_POST['emp_name'])) ? $_POST['emp_name'] : ''; ?>"
                                    placeholder="Employee Name" class="form-control inpt_field" /></td>
                            <td><input type="submit" class="btn add_emply" value="Apply Filter" /><a
                                    href="<?= base_url('clients/employees/' . $cid . '/' . $pid) ?>"
                                    class="btn btn-info restbtn">Reset</a></td>
                            <!--<td><a href="<?= base_url('clients/employees/' . $cid . '/' . $pid) ?>" class="btn btn-info">Reset</a></td>-->
                        </tr>
                    </table>
                </form>
            </div>

        </div>

        <?php
      $cl = $this->qm->all("ri_clientpolicy_tbl", "*", array('id' => $pid));
      foreach ($cl as $cl);
      ?><div class="col-12 card-header">
            <h4 class="card-title"> <?= $cl->cname; ?></h4>
            <h4 class="card-title">Policy Number -
                <?= ($cl->policy_num == 5283) ? 'Data Collection' : $cl->policy_num; ?></h4>
            <div class="btn-group">
                <a href="<?= base_url('clients/inactive_employees'); ?>/<?= $cid; ?>/<?= $pid; ?>"
                    class="btn btn-danger">Inactive Employees</a>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uplcard">Upload
                    Card</button>
            </div>
            <div class="modal fade" id="uplcard">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Upload Card</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                            </button>
                        </div>
                        <form class="row" action="<?= base_url('clients/uplcard/'); ?><?= $cid; ?>/<?= $pid; ?>"
                            enctype="multipart/form-data" method="POST">
                            <div class="modal-body">
                                <div class="col-12">
                                    <label>Card</label>
                                    <!-- List the selected files -->
                                    <div id="statusResponse"></div>

                                    <br>

                                    <!-- File browse input field -->
                                    <div class="form-group">
                                        <input type="file" class="form-control" id="fileInput" multiple>
                                    </div>

                                    <br>

                                    <!-- Progress bar -->
                                    <div style="height:12px;" class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="border-top: 0 !important;">
                                <button type="button" class="btn btn-danger light"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="button" id="uploadBtn" onclick="uploadCardFiles();"
                                    class="btn btn-primary">Upload Card</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Client List</h4>
                        <?php
                  if (!empty($this->session->flashdata('success'))) {
                     $success = $this->session->flashdata('success');
                  ?>
                        <div class="alert alert-success alert-dismissible fade show" style="width: 25%;">

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                            </button>
                            <strong>Success!</strong><?= $success; ?>
                        </div>
                        <?php } else {
                  } ?>
                        <!--<a href="<?= base_url('clients/depexcel'); ?>/<?= $cid; ?>/<?= $pid; ?>" class="btn btn-info">Download Dependents</a>-->
                        <a href="<?= base_url('clients/downloademp'); ?>/<?= $cid; ?>/<?= $pid; ?>/?empid=<?= $this->input->post('empid') ?>&emp_name=<?= $this->input->post('emp_name') ?>"
                            class="btn btn-info">Download Excel</a>
                        <div class="btn-group">
                            <a href="<?= base_url('clients/addemployee'); ?>/<?= $cid; ?>/<?= $pid; ?>"
                                class="btn btn-primary">Add New Employee</a>
                            &nbsp;
                            <a href="<?= base_url('clients/uploademployee'); ?>/<?= $cid; ?>/<?= $pid; ?>"
                                class="btn btn-info">Upload Employees</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example_" class="table display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Created On</th>
                                        <th>Sum Insured</th>
                                        <th>E-Card</th>
                                        <th>User/Password</th>
                                        <th>Emp Id</th>
                                        <th>Emp. Name</th>
                                        <th>Emp. Info</th>
                                        <th>Dependents</th>
                                        <th>DOB/Age</th>
                                        <th>Status</th>
                                        <th>Mode</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                           $s = 1;
                           //$emp = $this->qm->all('ri_employee_tbl','*',array('cid'=>$cid,'pid'=>$pid));
                           foreach ($emp as $emp) {

                              if ($emp->status == 1) {
                           ?>
                                    <tr>
                                        <td><?= $emp->up_time; ?></td>
                                        <td><?= $emp->sum_insured; ?>
                                        </td>
                                        <td><a style="width: 50px;"
                                                href="<?= base_url('external/uploads/policy_cards/' . $cid . '_' . $pid . '/'); ?><?= str_replace('#','',$emp->card); ?>.pdf"
                                                download>
                                                <?= $emp->card; ?></a></td>
                                        <td>User - <?= $emp->username; ?><br>Pass - <?= $emp->password; ?></td>
                                        <td><?= $emp->emp_id; ?></td>
                                        <td><?= $emp->emp_name; ?></td>
                                        <td style="width: 195px;">Email - <?= $emp->email; ?><br>
                                            Phone - <?= $emp->mobile; ?><br>
                                            Relation - <?= $emp->relation; ?><br>
                                            Gender - <?= $emp->gender; ?><br>
                                            <?php ?>
                                            <?php
                                       if ($emp->wedd_date != '1970-01-01') {
                                          echo "Wedding Date - " . date('d M, Y', strtotime($emp->wedd_date));
                                       } else {
                                       }
                                       ?>
                                        </td>

                                        <?php
                                    $fam = $this->qm->all('ri_dependent_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'eid' => $emp->eid));
                                    $count = count($fam);
                                    ?>
                                        <td> <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal"
                                                data-bs-target="#pop-<?= $s; ?>"><?= $count; ?></button>
                                            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
                                                id="pop-<?= $s; ?>" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Dependents</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal">
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <table class="table table-responsive-sm">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Relation</th>
                                                                        <th>Card</th>
                                                                        <th>Info</th>
                                                                        <th>Dob/Age</th>
                                                                        <th>Status</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                         $e = 1;
                                                         $rel = $this->qm->all('ri_dependent_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'eid' => $emp->eid));
                                                         foreach ($rel as $rel) {
                                                         ?>
                                                                    <tr>
                                                                        <th><?= $e; ?></th>
                                                                        <td><?= $rel->reltype . $rel->rel_index; ?></td>
                                                                        <td><a style="width: 50px;"
                                                                                href="<?= base_url('external/uploads/policy_cards/' . $cid . '_' . $pid . '/'); ?><?= str_replace('#','',$rel->card); ?>.pdf"
                                                                                download><?= $rel->card; ?></a></td>
                                                                        <td>Name :- <?= $rel->name; ?><br>
                                                                            Email :- <?= $rel->email; ?><br>
                                                                            Phone :- <?= $rel->phone; ?>
                                                                        </td>
                                                                        <td>Dob :-
                                                                            <?= date('d M, Y', strtotime($rel->dob)); ?><br>
                                                                            Age :- <?= $rel->age; ?><br>
                                                                            <?php
                                                                  if ($rel->wedd_date != '1970-01-01') {
                                                                     echo "Wedding Date :- " . date('d M, Y', strtotime($rel->wedd_date));
                                                                  } else {
                                                                  }
                                                                  ?>
                                                                        </td>
                                                                        <td class="color-primary"><?php
                                                                                          if ($rel->status == 1) {
                                                                                             echo '<span class="badge badge-success light">New Member Addition</span>';
                                                                                          } else {
                                                                                             echo '<span class="badge badge-info light">Family Data Correction</span>';
                                                                                          }
                                                                                          ?></td>
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
                                        <td style="width: 100%;">D.O.B -
                                            <?= date('d M, Y', strtotime($emp->dob)); ?><br>Age - <?= $emp->age; ?></td>

                                        <td><?php if ($emp->status == 1) {
                                             echo '<span class="badge badge-success light">Active</span>';
                                          } else {
                                             echo '<span class="badge badge-danger light">Inactive</span>';
                                          } ?></td>
                                        <td><?= $emp->mode; ?></td>
                                        <td>
                                            <div class="dropdown ms-auto text-end">
                                                <div class="btn-link" data-bs-toggle="dropdown" aria-expanded="true">
                                                    <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none"
                                                            fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"></rect>
                                                            <circle fill="#000000" cx="5" cy="12" r="2"></circle>
                                                            <circle fill="#000000" cx="12" cy="12" r="2"></circle>
                                                            <circle fill="#000000" cx="19" cy="12" r="2"></circle>
                                                        </g>
                                                    </svg>
                                                </div>
                                                <div class="dropdown-menu dropdown-menu-end"
                                                    style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(-92px, 27px);"
                                                    data-popper-placement="bottom-end">
                                                    <a href="<?= base_url('clients/editemployee/'); ?><?= $cid; ?>/<?= $pid; ?>/<?= $emp->eid; ?>"
                                                        class="dropdown-item"><i class="fas fa-pencil-alt"></i> Edit
                                                        Employee</a>
                                                    <a href="<?= base_url('employee/loggedin/'); ?><?= $cid; ?>/<?= $pid; ?>/<?= $emp->eid; ?>/<?= $emp->username; ?>/<?= $emp->password; ?>"
                                                        target="_blank" class="dropdown-item"><i
                                                            class="fas fa-lock"></i> Login</a>
                                                    <a data-toggle="tooltip"
                                                        href="<?= base_url('employee/login/'); ?><?= $cid; ?>/<?= $pid; ?>/<?= $emp->eid; ?>"
                                                        class="dropdown-item copy"><i class="fas fa-copy"></i> Copy
                                                        Url</a>
                                                    <a data-toggle="tooltip" href="javascript:;"
                                                        onclick="delte('<?= $emp->eid; ?>','self')"
                                                        class="dropdown-item"><i class="fa fa-trash"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                        <!--   <td>
                                       </td> -->
                                    </tr>
                                    <?php
                              }
                              $s++;
                           } ?>
                                </tbody>
                        </div>
                        </table>
                        <p><?php echo $links; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('external/'); ?>js/plupload/js/plupload.full.min.js"></script>

<script>
function delte(cid, pid, eid, brg) {
    //alert(arg+'/'+brg);
    if (confirm('do you want to delete the record?') == true) {
        window.location = "<?= base_url('clients/deleteemployee') ?>" + cid + "/" + pid + "/" + eid + "/" + brg;
    }
}
</script>

<script>
function uploadCardAjax(form_data) {
    return $.ajax({
        url: '<?php echo base_url(); ?>/clients/uplcard/<?php echo $cid; ?>/<?php echo $pid; ?>',
        type: 'post',
        data: form_data,
        contentType: false,
        processData: false
    });
};

async function uploadCardFiles() {

    var totalUploaded = 0;
    var errorfilenames = [];
    var totalfiles = document.getElementById('fileInput').files.length;

    $('.progress-bar').css('width', '0%');
    $('.progress-bar').attr('aria-valuenow', 0);
    $('.progress-bar').html('');
    $('#statusResponse').html('');

    $('#uploadBtn').html('Please wait...');

    if (totalfiles <= 0) {
        alert('Please select some files');
        return false;
    }

    for (var index = 0; index < totalfiles; index++) {
        var form_data = new FormData();
        form_data.append("card[]", document.getElementById('fileInput').files[index]);
        try {
            var response = await uploadCardAjax(form_data);
            response = $.parseJSON(response);
            if (!response.status) {
                errorfilenames.push(document.getElementById('fileInput').files[index].name);
            }
            totalUploaded += 1;
            var percent = parseInt((totalUploaded / totalfiles) * 100);
            $('.progress-bar').css('width', percent + '%');
            $('.progress-bar').attr('aria-valuenow', percent);
            $('.progress-bar').html(percent + '%');
        } catch (err) {
            errorfilenames.push(document.getElementById('fileInput').files[index].name);
            totalUploaded += 1;
            var percent = parseInt((totalUploaded / totalfiles) * 100);
            $('.progress-bar').css('width', percent + '%');
            $('.progress-bar').attr('aria-valuenow', percent);
            $('.progress-bar').html(percent + '%');

        }
    }

    $('#uploadBtn').html('Upload Card');

    if (errorfilenames.length > 0) {
        var message = 'Total Uploads : ' + totalfiles + '<br>Failed uploads : ' + errorfilenames.length;
        $('#statusResponse').html(message);
    } else {
        $('#statusResponse').html('All files uploaded successfully');
    }
}
</script>