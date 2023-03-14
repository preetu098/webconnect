<div class="content-body" style="background:#fff;">

    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-6 col-sm-12 card-body">
                <h2>Make Correction and Add / Delete Dependents</h2>
                <?php if (!empty($this->session->flashdata('success'))) {
                    $echnpass = $this->session->flashdata('success');
                ?>
                    <div class="alert alert-success alert-dismissible fade show" style="width: 100%;">

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                        </button>
                        <strong>Success!</strong> <?= $echnpass; ?>
                    </div>
                <?php } else {
                } ?>

                <div class="basic-form">
                    <form method="POST" action="<?= base_url('client/updself/'); ?><?= $pid; ?>/<?= $eid; ?>" enctype="multipart/form-data">
                        <?php

                        $uemp = $this->qm->single('ri_employee_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'eid' => $eid));
                        //print_r($uemp);
                        //foreach ($uemp as $uemp) {
                        ?>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" placeholder="Name" required value="<?= $uemp->name; ?>" name="name" class="form-control">
                            </div>
                            <div class="mb-3 col-md-6" title="Please contact HR to change Employee ID">
                                <label class="form-label">Employee ID</label>
                                <input type="text" disabled class="form-control" required style="background:#f8f8f8" value="<?= $uemp->emp_id; ?>" placeholder="Your Employee ID">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Health Card No.</label>
                                <input type="text" disabled class="form-control" style="background:#f8f8f8" value="<?= $uemp->card; ?>" placeholder="Health Card No.">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Sum Insured</label>
                                <input type="text" disabled class="form-control" style="background:#f8f8f8" value="<?= $uemp->sum_insured; ?>" placeholder="Contact HR to know">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" placeholder="Email" required value="<?= $uemp->email; ?>" name="email" class="form-control">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Mobile</label>
                                <input type="text" placeholder="Mobile" required value="<?= $uemp->mobile; ?>" name="mobile" class="form-control">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Gender</label>
                                <select class="form-control" required name="gender">
                                    <option>Select gender(<?php echo $uemp->gender ?>)</option>
                                    <option value="Male" <?= ($uemp->gender == 'Male' || $uemp->gender == 'M') ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female" <?= ($uemp->gender == 'Female' || $uemp->gender == 'F') ? 'selected' : ''; ?>>Female</option>
                                    <option value="Others" <?= ($uemp->gender == 'Others' || ($uemp->gender != 'Male' && $uemp->gender != 'M' && $uemp->gender != 'F' && $uemp->gender != 'Female')) ? 'selected' : ''; ?>>Others</option>
                                </select>
                            </div>
                            <!--<div class="mb-3 col-md-6">
                                                      <label class="form-label">Wedding Date</label>
                                                        <input type="date" name="wedd_date" value="<?= $uemp->wedd_date; ?>" class="form-control" placeholder="Wedding Date">
                                                   </div>-->
                            <div class="mb-3 col-md-6">
                                <label class="form-label">DOB</label>
                                <input type="date" name="dob" required id="dob" class="form-control" value="<?= $uemp->dob; ?>" placeholder="Dob">
                            </div>
                            <div class="mb-3 col-md-6" title="Contact HR to Update">
                                <label class="form-label">Date of Joining</label>
                                <input type="text" class="form-control" disabled style="background:#f8f8f8" value="<?= date_format(date_create($uemp->doj), "d-m-Y"); ?>" placeholder="">

                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Age</label>
                                <input type="text" name="age" required id="age" class="form-control" value="<?= $uemp->age; ?>" placeholder="Age">
                            </div>
                            <div class="mb-3 col-md-12">
                                <div class="row">
                                    <div class="col-xl-8">
                                        <label class="form-label">Reason for correction</label>
                                        <input type="text" name="reson" value="<?= !empty($uemp->reson) ? $uemp->reson : ''; ?>" class="form-control">
                                    </div>

                                </div>
                            </div>
                            <div class="mb-3 col-md-8">
                                <div class="row">
                                    <div class="col-xl-10">
                                        <label class="form-label">Upload Aadhar in case of Name/DOB/Gender correction</label>
                                        <input type="file" name="pimage" class="form-control">
                                    </div>
                                    <?php if (!empty($uemp->pimage)) : ?>
                                        <div class="col-xl-2">
                                            <img src="<?= base_url('external/uploads/' . $uemp->pimage) ?>" height="50" style="width:100px">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>


                        </div>
                        <?php //} 
                        ?>

                        <?php if ($uemp->status != 2) : ?>
                            <button class="btn btn-primary" type="submit">Save Record</button>
                        <?php else : ?>
                            <button disabled class="btn btn-primary" type="button"><?php echo getEmployeeStatus($uemp->eid, 'Self')['statustext']; ?></button>
                        <?php endif; ?>
                    </form>
                </div>

            </div>


            <div class="col-xl-6 col-sm-12 card-body">
                <div class="point-box">
                    <h4>Points Worth Noting</h4>

                    <h5>Correction</h5>
                    <p><i class="fa fa-check" style="color: #225ca3;"></i>Any correction request should be backed by documentary proof. Kindly upload a copy of government-approved document such as a voter ID/ Valid Passport/ Aadhar Card/ Driving License.</p>
                    <p><i class="fa fa-check" style="color: #225ca3;"></i>All corrections requests will be processed after your HR approval (In-built system functionality)</p>
                    <p><i class="fa fa-check" style="color: #225ca3;"></i>Correction is processed by the Insurer through an endorsement. The requested correction will reflect in "Well Connect" by the 15th of the corresponding month.</p>
                    <h5>Dependant Additions</h5>
                    <p><i class="fa fa-check" style="color: #225ca3;"></i>Mid Term Addition is only possible in case of childbirth and in the event of marriage only.</p>
                    <p><i class="fa fa-check" style="color: #225ca3;"></i>A new-born Baby should be added to the policy as soon as possible and a maximum of 90 days from the date of birth.</p>
                    <p><i class="fa fa-check" style="color: #225ca3;"></i>The newlywed spouse should be added to the policy within 30 Days of marriage.</p>
                    <p><i class="fa fa-check" style="color: #225ca3;"></i>Additions are processed by the Insurer through an endorsement. The requested additions will reflect in "Well Connect" by the 15th of the corresponding month.</p>
                    <h5>Dependant Deletion</h5>
                    <p><i class="fa fa-check" style="color: #225ca3;"></i>Deletion of Dependants are possible in special cases such as any unfortunate death or Divorce.</p>
                    <p><i class="fa fa-check" style="color: #225ca3;"></i>Deletion does not mean deletion of data from the system, it means deleting the coverage from the policy which requires a procedural deletion endorsement by the insurer. The requested deletion will reflect in "Well Connect" by the 15th of the corresponding month.</p>
                </div>


            </div>
            <style>
                .point-box {
                    border: 1px solid #2f5ea3;
                    padding: 10px 25px 10px 25px;
                    background-color: #cde6ff;
                    border-radius: 10px;
                    text-align: justify;
                }

                .point-box p {
                    font-size: 12px;
                }

                .point-box p i {
                    margin-right: 5px;
                }

                .point-box p span {
                    margin-left: 16px;
                }
            </style>
        </div>
    </div>


    <div class="row" id="viewmembers" style="margin:20px;">
        <div class="col-md-12 col-sm-12">
            <div class="card membr-list-crd">
                <h2>Member Details
                    <!--<a href="javascript:void(0);" class="btn btn-outline-info btn-rounded fs-18" style="width:30%;float:right">Add Dependents</a>-->
                </h2>

                <?php
                $s = 1;
                $rel = $this->qm->all('fm_relation_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'is_publish' => 1));
                $usedKids = [];
                $kidData = $this->qm->all('ri_dependent_tbl', '*', array('cid' => $cid, 'pid' => $pid, 'eid' => $eid, 'reltype' => 'Kid'));
                foreach ($rel as $rel) {



                    $max = $rel->max_entry;
                    for ($i = 0; $i < $max; $i++, $s++) {
                        $dep = $this->qm->single("ri_dependent_tbl", "*", array('cid' => $cid, 'pid' => $pid, 'eid' => $eid, 'reltype' => $rel->reltype));

                        if ($rel->reltype == 'Spouse' && $dep->reltype != 'Spouse') {
                            echo '<a href="' . base_url('client/updspouse/' . $pid . '/' . $eid) . '" class="btn btn-outline-success btn-rounded fs-18" style="width:40%;float:left">ADD SPOUSE</a><br>';
                        }

                        if ($rel->reltype == 'Kid' && $dep->reltype != 'Kid') {
                            echo '<a href="' . base_url('client/addkid/' . $pid . '/' . $eid) . '" class="btn btn-outline-success btn-rounded fs-18" style="width:40%;float:left">ADD KID</a><br>';
                        }

                        if ($rel->reltype == 'Father' && $dep->reltype != 'Father') {
                            echo '<a href="' . base_url('client/updfather/' . $pid . '/' . $eid) . '" class="btn btn-outline-success btn-rounded fs-18" style="width:40%;float:left">ADD FATHER</a><br>';
                        }
                        if ($rel->reltype == 'Mother' && $dep->reltype != 'Mother') {
                            echo '<a href="' . base_url('client/updmother/' . $pid . '/' . $eid) . '" class="btn btn-outline-success btn-rounded fs-18" style="width:40%;float:left">ADD MOTHER</a><br>';
                        }
                        if ($rel->reltype == 'Father In Law' && $dep->reltype != 'Father In Law') {
                            echo '<a href="' . base_url('client/updfatherinlaw/' . $pid . '/' . $eid) . '" class="btn btn-outline-success btn-rounded fs-18" style="width:40%;float:left">ADD FATHER IN LAW</a><br>';
                        }
                        if ($rel->reltype == 'Mother In Law' && $dep->reltype != 'Mother In Law') {
                            echo '<a href="' . base_url('client/updmotherinlaw/' . $pid . '/' . $eid) . '" class="btn btn-outline-success btn-rounded fs-18" style="width:40%;float:left">ADD MOTHER IN LAW</a><br>';
                        }



                        if ($dep->reltype == 'Spouse' ||  $dep->reltype == 'Kid' ||  $dep->reltype == 'Father' ||  $dep->reltype == 'Mother' ||  $dep->reltype == 'Father In Law' || $dep->reltype == 'Mother In Law') {
                ?>
                            <div class="accordion accordion-with-icon" style="padding:20px" id="accordion-six<?= $s; ?>">
                                <div class="accordion-item">
                                    <div class="accordion-header rounded-lg collapsed" id="accord-6One<?= $s; ?>" style="border: 0.0625rem solid #4a457d;" data-bs-toggle="collapse" data-bs-target="#collapse6One<?= $s; ?>" aria-controls="collapse6One<?= $s; ?>" aria-expanded="<?= ($rel->reltype == 'Self') ? "true" : "false" ?>" role="button">

                                        <span class="accordion-header-text" style="font-size: 16px;"><?= $rel->reltype; ?></span>
                                        <span class="accordion-header-indicator"></span>
                                    </div>
                                    <div id="collapse6One<?= $s; ?>" style="padding-right: 45px;" class="accordion__body collapse" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-controls="collapseOne" aria-expanded="true" role="button" aria-labelledby="accord-6One<?= $s; ?>" data-bs-parent="#accordion-six<?= $s; ?>" style="border: 1px solid #c3c3c3;">
                                        <div class="accordion-body-text active" style="text-transform: uppercase; color: #000">
                                            <?php
                                            $data['cid'] = $cid;
                                            $data['pid'] = $pid;
                                            $data['eid'] = $eid;
                                            $data['emp_id'] = $uemp->emp_id;
                                            $data['rel'] = $rel->reltype;

                                            if ($rel->reltype == 'Spouse' && $dep->did > 0) {
                                                $this->load->view('client/spouse', $data);
                                            } else if ($rel->reltype == 'Kid' && ($dep->reltype == 'Kid' || $dep->reltype == 'Kid0' || $dep->reltype == 'Kid1' || $dep->reltype == 'Kid2')  && $dep->did > 0) {
                                                $kidV = [];
                                                foreach ($kidData as $kdata) {
                                                    if (!in_array($kdata->did, $usedKids)) {
                                                        $usedKids[] = $kdata->did;
                                                        $kidV[] = $kdata;
                                                        break;
                                                    }
                                                }
                                                $data['spouse'] = $kidV;
                                                $this->load->view('client/kid', $data);
                                            } else if ($rel->reltype == 'Father' && $dep->did > 0) {
                                                $this->load->view('client/father', $data);
                                            } else if ($rel->reltype == 'Mother' && $dep->did > 0) {
                                                $this->load->view('client/mother', $data);
                                            } else if ($rel->reltype == 'Father In Law' && $dep->did > 0) {
                                                $this->load->view('client/fatherinlaw', $data);
                                            } else if ($rel->reltype == 'Mother In Law' && $dep->did > 0) {
                                                $this->load->view('client/motherinlaw', $data);
                                            } else {
                                                echo "Some Error Occurred";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>


                            </div>

                <?php }
                    }
                } ?>


            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deletedepmodal" tabindex="-1" aria-labelledby="deletedepmodalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletedepmodalLabel">Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="delete-dep-form" enctype="multipart/form-data">
                    <input type="hidden" name="did">
                    <label for="img">DOL:</label>
                    <input type="date" class="form-control" id="dol" name="dol">
                    <span class='error'></span><br>
                    <label for="img">Reason:</label>
                    <textarea class="form-control" name="reson"></textarea>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" onclick="doDelDep()" class="btn btn-primary delete-dep-invite-excel">Submit</button>
            </div>
        </div>
    </div>
</div>

<script>
    function deleterec(did) {
        $('#deletedepmodal').find('input[name="did"]').val(did);
        $('#deletedepmodal').modal('show');
    }

    function doDelDep() {
        msg = $('#deletedepmodal').find('input[name="dol"]').val();
        reson = $('#deletedepmodal').find('textarea[name="reson"]').val();
        if (msg == '' || reson == '') {
            alert('Please fill Date of leaving and Reason');
            return false;
        }
        did = $('#deletedepmodal').find('input[name="did"]').val();
        window.location.href = "<?= base_url('client/deletedep/' . $pid . '/') ?>" + did + "?reson=" + reson + "&dol=" + msg;
    };
</script>