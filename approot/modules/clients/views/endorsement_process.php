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
                        <h4 class="card-title">Endorsement Addition List</h4>
                        <a href="<?= base_url('Clients/endorsement_deletion/'); ?><?= $cid; ?>/<?= $pid; ?>" class="btn btn-primary">Deletion List</a>
                        <!-- <a href="<?= base_url('Clients/endorsement_pro_rata/'); ?><?= $cid; ?>/<?= $pid; ?>" class="btn btn-primary">Endorsement Pro Rata</a> -->
                    </div>
                    <?php
                    $endorsment_calculations_info = $this->qm->single("endorsment_calculations", "*", array('cid' => $cid, 'pid' => $pid));
                    $policy_info = $this->qm->single("ad_policy", "*", array('policy_id' => $pid));
                    $policy_premium_info = $this->qm->single("policy_premium", "*", array('cid' => $cid, 'pid' => $pid));
                    function dateDifference($start_date, $end_date)
                    {
                        $start_array = date_parse($start_date);
                        $end_array = date_parse($end_date);
                        $start_date = GregorianToJD($start_array["month"], $start_array["day"], $start_array["year"]) . "</br>";
                        $end_date = GregorianToJD($end_array["month"], $end_array["day"], $end_array["year"]);
                        return round(($end_date - $start_date), 0);
                    }

                    ?>
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
                                            <th>Date Of Joining</th>
                                            <th>EED(43 Days)</th>
                                            <th>Date of Commencement (DOC)</th>
                                            <th>Policy Start date</th>
                                            <th>Policy End Date</th>
                                            <th>Premium(Add/Del)</th>
                                            <th>No. of days of coverage</th>
                                            <?php
                                            if ($endorsment_calculations_info->basis_of_calculation == "pro_rata_basis") {


                                            ?>
                                                <th>Pro Rata Basis</th>
                                                <th>GST</th>
                                                <th>Pro Rata Period Premium With GST</th>
                                            <?php
                                            } else {
                                            ?>
                                                
                                                <th>Short Period Rate</th>
                                                <th>Short Period Premium</th>
                                                <th>GST</th>
                                                <th>Short Period Premium With GST</th>
                                            <?php
                                            }
                                            ?>

                                            <!-- <th>Net Endorsement Premium</th> -->
                                            <!-- <th>Action</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 1;

                                        $emp = $this->qm->all('ri_employee_tbl', '*', array('cid' => $cid, 'pid' => $pid));

                                        foreach ($emp as $emp) {

                                            if ($emp->mode == "New Addition") {


                                                $date_of_joining = date("Y-m-d", strtotime($emp->doj));
                                                $date_of_policy_expire = date("Y-m-d", strtotime($policy_info->expiry_on));
                                                $diffDays = dateDifference($date_of_joining, $date_of_policy_expire);
                                                $EED = dateDifference($date_of_joining, date("Y-m-d"));
                                                $diffDays = abs($diffDays) + 1;

                                                $pro_date_of_policy_start = date("Y-m-d", strtotime($policy_info->start_on));
                                                $pro_date_of_policy_expire = date("Y-m-d", strtotime($policy_info->expiry_on));
                                                $pro_diffDays = dateDifference($pro_date_of_policy_start, $pro_date_of_policy_expire);

                                                $pro_diffDays = abs($pro_diffDays) + 1;
                                                $pro_rata= (($policy_premium_info->premium / $pro_diffDays) * $diffDays);


                                                if ($endorsment_calculations_info->gst == 1) {
                                                    $gst_premium = $policy_premium_info->premium * ($endorsment_calculations_info->gst_rate / 100);
                                                    $short_gst_premium = $gst_premium + $policy_premium_info->premium;
                                                    $pro_gst_premium = $pro_rata * ($endorsment_calculations_info->gst_rate / 100);
                                                    $pro_rata_gst_premium = $pro_gst_premium + $pro_rata;
                                                }
                                                $policy_premium_info->premium;

                                                // $diffDays=30;
                                                if ($diffDays <= 7) {
                                                    $premium = $policy_premium_info->premium * (10 / 100);
                                                    $short_peroid_rate = '10%';
                                                }
                                                if ($diffDays <= 30) {
                                                    $premium = $policy_premium_info->premium * (25 / 100);
                                                    $short_peroid_rate = '25%';
                                                }
                                                if ($diffDays <= 60) {
                                                    $premium = $policy_premium_info->premium * (35 / 100);
                                                    $short_peroid_rate = '35%';
                                                }
                                                if ($diffDays <= 90) {
                                                    $premium = $policy_premium_info->premium * (50 / 100);
                                                    $short_peroid_rate = '50%';
                                                }
                                                if ($diffDays <= 120) {
                                                    $premium = $policy_premium_info->premium * (60 / 100);
                                                    $short_peroid_rate = '60%';
                                                }
                                                if ($diffDays <= 180) {
                                                    $premium = $policy_premium_info->premium * (75 / 100);
                                                    $short_peroid_rate = '75%';
                                                }
                                                if ($diffDays == 240) {
                                                    $premium = $policy_premium_info->premium / 100;
                                                    $short_peroid_rate = '100%';
                                                }

                                                $after_endorsement_premium = $premium + $policy_premium_info->premium;

                                        ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $count++; ?>
                                                    </td>
                                                    <td><?php echo $emp->emp_id ?></td>
                                                    <td><?php echo $emp->emp_name ?></td>
                                                    <td><?php echo $emp->dob ?></td>
                                                    <td><?php echo $emp->age ?></td>
                                                    <td><?php echo $emp->gender ?></td>
                                                    <td><?php echo $emp->relation ?></td>
                                                    <td><?php echo $emp->sum_insured ?></td>
                                                    <td><?php echo  date("d-m-Y", strtotime($emp->doj)); ?></td>
                                                    <td><?php
                                                        if ($EED >= 43) {
                                                            echo '43';
                                                        } else {
                                                            echo $EED;
                                                        }
                                                        ?></td>

                                                    <td>
                                                        <?php
                                                        $startdate = strtotime($emp->doj);
                                                        //    if ($EED >= 43) {
                                                        //     echo date("d-m-Y", strtotime("+43 days", $startdate)) . "<br>";

                                                        //    }else{
                                                        //     echo date("d-m-Y", strtotime(date("Y-m-d"),$startdate)) . "<br>";
                                                        //    }
                                                        echo date("d-m-Y", strtotime("+43 days", $startdate)) . "<br>";
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        echo  date("d-m-Y", strtotime($policy_info->start_on));

                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        echo  date("d-m-Y", strtotime($policy_info->expiry_on));
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $policy_premium_info->premium; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $diffDays; ?>
                                                    </td>
                                                    <?php
                                                    if ($endorsment_calculations_info->basis_of_calculation == "pro_rata_basis") {


                                                    ?>
                                                    <td><?php echo $pro_rata?></td>
                                                    <td><?php echo $pro_gst_premium?></td>
                                                    <td><?php echo $pro_rata_gst_premium?></td>
                                                    <?php
                                                    } else {
                                                    ?> <td><?php echo $short_peroid_rate; ?></td>



                                                        <td>
                                                            <?php echo $premium; ?>
                                                        </td>
                                                        <td><?php echo $gst_premium; ?></td>
                                                        <td><?php echo $short_gst_premium; ?></td>

                                                    <?php
                                                    }
                                                    ?>


                                                    <!-- <td>
                                                        <?php echo $after_endorsement_premium; ?>
                                                    </td> -->
                                                    <!-- <td>
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
                                                </td> -->
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                        <?php }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>