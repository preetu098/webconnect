<div class="content-body">
   <div class="container-fluid">
      <div class="row page-titles">
         <!--<ol class="breadcrumb">
            <li class="breadcrumb-item active"><a href="index.php">Home ></a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Invited Employees list</a></li>
         </ol>-->
         <a href="<?php echo base_url(); ?>client/invitationhistory" style="float:right; width:200px" class="btn btn-outline-primary btn-rounded">Back </a>
      </div>
      <!-- row -->
      <div class="row">
         <div class="col-12">
            <div class="card">
               <div class="card-header">
                  <h4 class="card-title">Invited Employees List</h4>
                  
                  <a href="<?php echo base_url(); ?>client/downloadinvitationreport" class="btn btn-outline-primary btn-rounded fs-18">Download Emails List</a>
               </div>
               <div class="card-body">
                  <div class="table-responsive">
                     <table id="example" class="display" style="min-width: 845px">
                        <thead>
                           <tr>
                              <th>Sr No</th>
                              <th>Employee Id</th>
                              <th>Employee Name</th>
                              <th>Emplyee Email</th>
                              <th>Employee Sum Insured</th>
                              <th>Status</th>
                           </tr>
                        </thead>
                        <tbody>
                            <?php
                              $exportList = array();
                              foreach($batchEmails as $key=>$emailList){
                                 $emailRec = json_decode($emailList->queue_data, true);
                                 $exportList[] = $emailRec;
                           ?>
                        <tr>
                                <td><?=$key+1?></td>
                                <td><?=$emailRec['emp_id']?></td>
                                <td><?=$emailRec['emp_name']?></td>
                                <td><?=$emailRec['emp_email']?></td>
                                <td><?=$emailRec['emp_sum_insured']?></td>
                                <td><?php echo ($emailRec['status'] == 'bounce' || $emailRec['status'] == 'failed') ? '<span style="color:red;">'.$emailRec["status"].'</span>' : '<span style="color:green;">'.$emailRec["status"].'</span>'; ?></td>
                        </tr>
                        <?php
                           $_SESSION['export_email_list'] = $exportList;
                              } 
                        ?>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>