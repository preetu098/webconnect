<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Clients</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Endorsement Deletion </a></li>
            </ol>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Endorsement Deletion List</h4>
                    </div>
                   
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="example2" class="display" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Employee ID</th>
                                            <th>Employee Name</th>
                                            <th>Date of Birth</th>
                                            <th>Age</th>
                                            <th>Gender</th>
                                            <th>RelationShip</th>
                                            <th>Sum insured</th>
                                            <th>Date Of Leaving</th>
                                            <th>Policy Start date</th>
                                            <th>Policy End Date</th>
                                            <th>Difference Days</th>
                                            <th>Short Period Rate</th>
                                            <th>Premium</th>
                                            <th>Short Period Premium</th>
                                            <th>Net Endorsement Premium</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count=1;
                                        $policy_info = $this->qm->single("ad_policy", "*", array('policy_id' => $pid));
                                        $emp = $this->qm->all('ri_employee_tbl', '*', array('cid' => $cid, 'pid' => $pid));
                                        foreach ($emp as $emp) {
                                            // echo "<pre>";
                                            // print_r($emp->doj);
                                            // echo "</pre>";
                                            if($emp->mode=="Deletion"){
                                            $date1 = date("Y-m-d", strtotime($emp->dol));
                                            $date2 = date("Y-m-d", strtotime($policy_info->start_on));

                                            $diff = abs(strtotime($date1) - strtotime($date2));

                                            $years = floor($diff / (365 * 60 * 60 * 24));
                                            $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                                            $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                                            $diffDays = abs($days) + 1;

                                            $policy_premium_info = $this->qm->single("policy_premium", "*", array('cid' => $cid, 'pid' => $pid));
                                            $policy_premium_info->premium;
                                            // $diffDays=30;
                                            if ($diffDays == 7 || $diffDays < 30) {
                                                $premium = $policy_premium_info->premium * (90 / 100);
                                                $short_peroid_rate='90%';
                                            }
                                            if ($diffDays == 30) {
                                                $premium = $policy_premium_info->premium * (75 / 100);
                                                $short_peroid_rate='75%';
                                            }
                                            if ($diffDays == 60) {
                                                $premium = $policy_premium_info->premium * (65 / 100);
                                                $short_peroid_rate='65%';
                                            }
                                            if ($diffDays == 90) {
                                                $premium = $policy_premium_info->premium * (50 / 100);
                                                $short_peroid_rate='50%';
                                            }
                                            if ($diffDays == 120) {
                                                $premium = $policy_premium_info->premium * (40 / 100);
                                                $short_peroid_rate='40%';
                                            }
                                            if ($diffDays == 180) {
                                                $premium = $policy_premium_info->premium * (25 / 100);
                                                $short_peroid_rate='25%';
                                            }
                                            if ($diffDays == 240) {
                                                $premium = $policy_premium_info->premium * (15 / 100);
                                                $short_peroid_rate='15%';
                                            }
                                            
                                            $after_endorsement_premium = $premium - $policy_premium_info->premium;
                                           
                                            ?>
                                            <tr>
                                                <td>
                                                   <?php echo $count++;?>
                                                </td>
                                                <td><?php echo $emp->emp_id?></td>
                                                <td><?php echo $emp->emp_name?></td>
                                                <td><?php echo $emp->dob?></td>
                                                <td><?php echo $emp->age?></td>
                                                <td><?php echo $emp->gender?></td>
                                                <td><?php echo $emp->relation?></td>
                                                <td><?php echo $emp->sum_insured?></td>
                                                <td><?php echo $emp->dol?></td>
                                                <td>
                                                    <?php
                                                    echo $date1 = date("d-m-Y", strtotime($policy_info->start_on));

                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    echo $date2 = date("d-m-Y", strtotime($policy_info->expiry_on));
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php echo $diffDays; ?>
                                                </td>
                                                <td><?php echo $short_peroid_rate;?></td>
                                                
                                                
                                                <td>
                                                    <?php echo $policy_premium_info->premium; ?>
                                                </td>
                                                <td>
                                                    <?php echo $premium; ?>
                                                </td>
                                                <td>
                                                    <?php echo abs($after_endorsement_premium); ?>
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="javascript:void(0)" data-bs-toggle="modal"
                                                            data-bs-target="#short_period_edit<?= $key + 1; ?>"
                                                            class="btn btn-primary shadow btn-xs sharp me-1"><i
                                                                class="fas fa-pencil-alt"></i></a>
                                                        <a onclick="return confirm('Are you sure want to delete')"
                                                            href="<?= base_url('clients/deletePeriodScale'); ?>/<?= $val->cid; ?>/<?= $val->pid; ?>/<?= $val->id; ?>"
                                                            class="btn btn-danger shadow btn-xs sharp"><i
                                                                class="fa fa-trash"></i></a>
                                                    </div>
                                                </td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        <?php } } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    