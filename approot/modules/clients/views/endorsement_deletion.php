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
                                            <th>Date Of Leaving</th>
                                            <th>EED(43 Days)</th>
                                            <th>Date of Deletion (DOD)</th>
                                            <th>Policy Start date</th>
                                            <th>Policy End Date</th>
                                            <th>Premium</th>
                                            <?php
                                            if ($endorsment_calculations_info->basis_of_calculation == "pro_rata_basis") {


                                                ?>
                                                  <th>No. of days for Refund</th>
                                                <th>Pro Rata Premium</th>
                                                <th>GST</th>
                                                <th>Pro Rata Premium With GST</th>
                                                <?php
                                            } else {
                                                ?>
                                          
                                            <th>Covered upto days in the Policy</th>
                                            <th>Short Period Rate</th>
                                            <th>Short Period Premium</th>
                                            <th>GST</th>
                                            <th>Short Period Premium With GST</th>
                                            <?php
                                            }
                                            ?>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count=1;
                                        $emp = $this->qm->all('ri_employee_tbl', '*', array('cid' => $cid, 'pid' => $pid));
                                        
                                        foreach ($emp as $emp) {
                                            // echo "<pre>";
                                            // print_r($emp->doj);
                                            // echo "</pre>";
                                            if($emp->mode=="Deletion"){

                                            $date_of_leaving = date("Y-m-d", strtotime($emp->dol));
                                            $date_of_leaving ='2023-04-07';
                                            $date_of_policy_start = date("Y-m-d", strtotime($policy_info->start_on));
                                            $diffDays= dateDifference($date_of_leaving,$date_of_policy_start);
                                            
                                            $diffDays = abs($diffDays) + 1;
                                            $pro_date_of_policy_start = date("Y-m-d", strtotime($policy_info->start_on));
                                            $pro_date_of_policy_expire = date("Y-m-d", strtotime($policy_info->expiry_on));
                                            $pro_diffDays = dateDifference($pro_date_of_policy_start, $pro_date_of_policy_expire);

                                            $pro_diffDays = abs($pro_diffDays) + 1;
                                            $pro_rata = (($policy_premium_info->premium / $pro_diffDays) * $diffDays);

                                                $EED = dateDifference($date_of_leaving, date("Y-m-d"));
                                               
                                                
                                            // $diffDays=30;
                                            if ($diffDays <= 7 ) {
                                                $premium = $policy_premium_info->premium * (90 / 100);
                                                $short_peroid_rate='90%';
                                            }
                                            if (($diffDays <= 30 || $diffDays < 30) && $diffDays > 7) {
                                                $premium = $policy_premium_info->premium * (75 / 100);
                                                $short_peroid_rate='75%';
                                            }
                                            if (($diffDays <= 60 || $diffDays < 60) && $diffDays > 30) {
                                                $premium = $policy_premium_info->premium * (65 / 100);
                                                $short_peroid_rate='65%';
                                            }
                                            if (($diffDays == 90 || $diffDays < 90) && $diffDays > 60) {
                                                $premium = $policy_premium_info->premium * (50 / 100);
                                                $short_peroid_rate='50%';
                                            }
                                            if (($diffDays == 120 || $diffDays < 120) && $diffDays > 90) {
                                                $premium = $policy_premium_info->premium * (40 / 100);
                                                $short_peroid_rate='40%';
                                            }
                                            if (($diffDays == 180 || $diffDays < 180) && $diffDays > 120) {
                                                $premium = $policy_premium_info->premium * (25 / 100);
                                                $short_peroid_rate='25%';
                                            }
                                            if (($diffDays == 240 || $diffDays < 240) && $diffDays > 180) {
                                                $premium = $policy_premium_info->premium * (15 / 100);
                                                $short_peroid_rate='15%';
                                            }
                                            
                                            if ($endorsment_calculations_info->gst == 1) {
                                                $gst_premium = $policy_premium_info->premium * ($endorsment_calculations_info->gst_rate / 100);
                                                $short_gst_premium = $gst_premium + $premium;
                                                $pro_gst_premium = $pro_rata * ($endorsment_calculations_info->gst_rate / 100);
                                                $pro_rata_gst_premium = $pro_gst_premium + $pro_rata;
                                            }
                                           
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
                                                
                                                <td><?php echo  date("d-m-Y", strtotime($emp->dol));?></td>
                                                <td>
                                                        <?php
                                                        if ($EED >= 43) {
                                                            echo '43';
                                                        } else {
                                                            echo $EED;
                                                        }
                                                        ?>
                                                    </td>

                                                    <td>
                                                        <?php
                                                        $startdate = strtotime($emp->dol);
                                                        if ($EED >= 43) {
                                                            echo date("d-m-Y", strtotime("+43 days", $startdate)) . "<br>";

                                                        } else {
                                                            echo date("d-m-Y", strtotime($emp->dol)) . "<br>";
                                                        }
                                                        // echo date("d-m-Y", strtotime("+43 days", $startdate)) . "<br>";
                                                        ?>
                                                    </td>
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
                                                    <?php echo $policy_premium_info->premium; ?>
                                                </td>
                                                <?php
                                                    if ($endorsment_calculations_info->basis_of_calculation == "pro_rata_basis") {


                                                        ?>
                                                <td>
                                                    <?php echo $diffDays; ?>
                                                </td>
                                                <td>
                                                            <?php echo (int) $pro_rata ?>
                                                        </td>
                                                        <td>
                                                            <?php echo (int) $pro_gst_premium ?>
                                                        </td>
                                                        <td>
                                                            <?php echo (int) $pro_rata_gst_premium ?>
                                                        </td>
                                                <?php } else{?>
                                                    <td>
                                                    <?php echo $diffDays; ?>
                                                </td>  
                                                <td><?php echo $short_peroid_rate;?></td>
                                                
                                                
                                                <td>
                                                    <?php echo $premium; ?>
                                                </td>
                                                
                                                <td>
                                                    <?php echo $gst_premium; ?>
                                                </td>
                                                <td>
                                                    <?php echo $short_gst_premium; ?>
                                                </td>
                                                <?php }?>
                                               
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
    